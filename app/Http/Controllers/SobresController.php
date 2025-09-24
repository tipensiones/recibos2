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
                        //->whereIn('tipo_nomina',['N','NR','DJ','AG','CA'])
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
        //dd($items);
        $maestro = Arr::get(auth()->user(), 'persona');
        $file = Arr::get($items, '0.archivo');

        $year = '20' . substr($file, 0, 2);
        $month = substr($file, 2, 2);

        $date = Carbon::parse("$year-$month-01");
        $mes = array_search($month, static::MESES);

        // ultimo dia del mes anterior
        $fecha = $date->copy()->subMonth()->endOfMonth()->format('d/m/Y');
        $periodo = strtolower('0'.$date->startOfMonth()->day . ' al ' . $date->endOfMonth()->day . ' de ' . $mes . ' del ' . $year);

        
        $datosPorTipo = [];

        foreach ($items as $item) {
            $tipo = Arr::get($item, 'tipo_nomina');

            if($tipo == 'DM'){

                // Deducciones
                $deducciones = RespaldoNomina::where('archivo', $item['archivo'])
                                ->where('tipo_nomina', $tipo)
                                ->where('jpp', $item['jpp'])
                                ->where('numjpp', $item['numjpp'])
                                ->where('clave','>',106)
                                ->orderBy('clave')
                                ->orderBy('secuen')
                                ->get();

                // Percepciones
                $percepciones = RespaldoNomina::where('archivo', $item['archivo'])
                                ->where('tipo_nomina', $tipo)
                                ->where('jpp', $item['jpp'])
                                ->where('numjpp', $item['numjpp'])
                                ->where('clave','<',107)
                                ->orderBy('clave')
                                ->orderBy('secuen')
                                ->get();

            }if($tipo == 'UT'){

                // Deducciones
                $deducciones = RespaldoNomina::where('archivo', $item['archivo'])
                                ->where('tipo_nomina', $tipo)
                                ->where('jpp', $item['jpp'])
                                ->where('numjpp', $item['numjpp'])
                                ->where('clave','>',107)
                                ->orderBy('clave')
                                ->orderBy('secuen')
                                ->get();

                // Percepciones
                $percepciones = RespaldoNomina::where('archivo', $item['archivo'])
                                ->where('tipo_nomina', $tipo)
                                ->where('jpp', $item['jpp'])
                                ->where('numjpp', $item['numjpp'])
                                ->where('clave','<',108)
                                ->orderBy('clave')
                                ->orderBy('secuen')
                                ->get();

            }else{

                // Deducciones
                $deducciones = RespaldoNomina::where('archivo', $item['archivo'])
                                ->where('tipo_nomina', $tipo)
                                ->where('jpp', $item['jpp'])
                                ->where('numjpp', $item['numjpp'])
                                ->where('clave','>',60)
                                ->orderBy('clave')
                                ->orderBy('secuen')
                                ->get();

                // Percepciones
                $percepciones = RespaldoNomina::where('archivo', $item['archivo'])
                                ->where('tipo_nomina', $tipo)
                                ->where('jpp', $item['jpp'])
                                ->where('numjpp', $item['numjpp'])
                                ->where('clave','<',60)
                                ->orderBy('clave')
                                ->orderBy('secuen')
                                ->get();
            }
            

            $datosPorTipo[$tipo] = [
                'deducciones' => $deducciones,
                'percepciones' => $percepciones,
                'maestro' => $maestro,
                'fecha' => $fecha,
                'periodo' => $periodo,
            ];
        }

        $pdf = Pdf::loadView('recibo', [
            'datosPorTipo' => $datosPorTipo
        ])->setPaper('letter', 'landscape');

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
