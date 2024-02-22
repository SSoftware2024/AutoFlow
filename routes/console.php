<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Inspiring;
use function Laravel\Prompts\confirm;
use function Laravel\Prompts\progress;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
Artisan::command('database-truncate', function () {
    $confirmed = confirm(
        label: 'Do you really want to truncate your database?',
        default: false,
        hint: 'The action is irreversible'
    );
    if ($confirmed) {
        // Obter todas as tabelas do banco de dados
        $tables = DB::select('SHOW TABLES');
        progress(
            label: 'Updating users',
            steps: $tables,
            callback: function ($tables, $progress) {
                foreach ($tables as $table) {
                    $progress
                        ->label("Truncating table $table");
                    // Verificar se a tabela não é a tabela de migração
                    if ($table !== 'migrations') {
                        Schema::disableForeignKeyConstraints();
                        DB::table($table)->truncate();
                        Schema::enableForeignKeyConstraints();
                    }
                }
            },
            hint: 'This may take some time.',
        );
        $this->comment('All tables truncated except migration');
    }
})->purpose('Truncante all tables of database except migrations');
