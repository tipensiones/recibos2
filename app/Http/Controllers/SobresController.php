<?php

namespace App\Http\Controllers;

use App\Models\RespaldoNomina;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class SobresController extends Controller
{
    const MESES = [
        'ENERO' => '01',
        'FEBRERO' => '02',
        'MARZO' => '03',
        'ABRIL' => '04',
        'MAYO' => '05',
        'JUNIO' => '06',
        'JULIO' => '07',
        'AGOSTO' => '08',
        'SEPTIEMBRE' => '09',
        'OCTUBRE' => '10',
        'NOVIEMBRE' => '11',
        'DICIEMBRE' => '12'
    ];
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $year = substr(Arr::get($request, 'year'), 2, 2);
        $month = static::MESES[Arr::get($request, 'month')];
        $file = implode('', [$year, $month]);
        $persona = Arr::get(auth()->user(), 'persona');

        $records = RespaldoNomina::where('jpp', Arr::get($persona, 'jpp'))
                        ->where('numjpp', Arr::get($persona, 'num'))
                        ->where('archivo', $file)
                        ->get();

        return response()->json($records);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        set_time_limit(0);
        $ids = explode(',', $id);
        $items = RespaldoNomina::whereIn('id', $ids)->groupBy('tipo_nomina')->get();
        $maestro = Arr::get(auth()->user(), 'persona');

        $file = Arr::get($items, '0.archivo');
        $year = implode('', ['20', substr($file, 0, 2)]);
        $month = substr($file, 2, 2);

        $date = Carbon::parse(implode('-', [$year, $month, '01']));
        $mes = array_search($month, static::MESES);

        $fecha = implode('-', [$date->endOfMonth()->day, $month, $year]);
        $periodo = implode(' ', ['DEL', $date->startOfMonth()->day, 'AL', $date->endOfMonth()->day, 'DE', $mes, 'DEL', $year]);

        $respaldos = [];
        foreach ($items as $item) {
            $archivo = Arr::get($item, 'archivo');
            $tipo_nomina = Arr::get($item, 'tipo_nomina');
            $jpp = Arr::get($item, 'jpp');
            $numjpp = Arr::get($item, 'numjpp');
            $nomina = RespaldoNomina::where('archivo', $archivo)
                        ->where('tipo_nomina', $tipo_nomina)
                        ->where('jpp', $jpp)
                        ->where('numjpp', $numjpp)
                        ->where('clave','>',60)
                        ->get();
            array_push($respaldos, $nomina);
        }

        
        $respaldos2 = [];
        foreach ($items as $item) {
            $archivo2 = Arr::get($item, 'archivo');
            $tipo_nomina2 = Arr::get($item, 'tipo_nomina');
            $jpp2 = Arr::get($item, 'jpp');
            $numjpp2 = Arr::get($item, 'numjpp');
            $nomina2 = RespaldoNomina::where('archivo', $archivo2)
                        ->where('tipo_nomina', $tipo_nomina2)
                        ->where('jpp', $jpp2)
                        ->where('numjpp', $numjpp2)
                        ->where('clave','<',60)
                        ->get();
            array_push($respaldos, $nomina2);
        }
        /*
        return view('recibo', [
            'respaldo' => $respaldo,
            'maestro' => $maestro
        ]);
        */
        
        $pdf = Pdf::loadView('recibo', [
            'respaldos' => $respaldos,
            //'respaldos2' => $respaldos2,
            'maestro' => $maestro,
            'fecha' => $fecha,
            'periodo' => $periodo
        ]);
        $uuid = Uuid::uuid4();
        return $pdf->stream("$uuid.pdf");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
