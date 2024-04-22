<?php

namespace App\Console\Commands;

use App\Models\Maestro;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MakePasswords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'passwords:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera los passwords iniciales. USAR SOLAMENTE UNA VEZ AL LIBERAR EL SISTEMA.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $maestro = Maestro::all();

        $progressBar = $this->output->createProgressBar(count($maestro));
        $progressBar->start();

        foreach ($maestro as $m) {
            $username = implode('', [Arr::get($m, 'jpp'), Arr::get($m, 'num')]);
            $rfc = Arr::get($m, 'rfc');
            $password = Hash::make($rfc);

            try {
                $user = User::create([
                    'name' => Arr::get($m, 'nombre'),
                    'email' => implode('@', [$username, 'pensiones.net']),
                    'password' => $password,
                    'username' => $username,
                ]);

                Arr::set($m, 'user_id', Arr::get($user, 'id'));
                $m->update();
            } catch (\Throwable $th) {
                //throw $th;
            }

            $progressBar->advance();
        }
        $progressBar->finish();
        /*
        $users = User::all();
        foreach ($users as $user) {
            $username = Arr::get($user, 'username');
            if(empty($username)){
                continue;
            }

            $maestro = Maestro::where('clave', $username)->first();
            Arr::set($maestro, 'user_id', Arr::get($user, 'id'));
            $maestro->update();

            $password = Arr::get($maestro, 'rfc');
            $password = Hash::make($password);
            Arr::set($user, 'password', $password);
            $user->update();
        }
        */
    }
}
