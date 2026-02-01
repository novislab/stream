<?php

use App\Http\Controllers\ShortUrlRedirectController;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('s/{code}', ShortUrlRedirectController::class)->name('short-url.redirect');

// Deploy auto-import route (called by GitHub Actions)
Route::post('/deploy/import-sql', function (): ResponseFactory|Response {
    $key = request()->query('key');
    $deployKey = config('app.deploy_key');

    if (empty($deployKey) || $key !== $deployKey) {
        return response('Invalid key', 403);
    }

    $sqlDir = base_path('sql');
    $migrations = array_filter(
        glob($sqlDir.'/*.sql') ?: [],
        fn (string $f) => ! str_starts_with(basename($f), 'backup_')
    );

    if ($migrations === []) {
        return response('No migration SQL files found', 404);
    }

    usort($migrations, fn ($a, $b) => filemtime($b) - filemtime($a));
    $sqlFile = $migrations[0];

    try {
        // Create backup first
        $backupName = 'backup_'.date('Y-m-d_H-i-s').'.sql';
        $backupPath = $sqlDir.'/'.$backupName;
        $tableKey = 'Tables_in_'.config('database.connections.mysql.database');
        $tables = DB::select('SHOW TABLES');

        $backup = '';
        foreach ($tables as $table) {
            $tableName = $table->$tableKey;
            $backup .= "DROP TABLE IF EXISTS `$tableName`;\n";
            $create = DB::selectOne("SHOW CREATE TABLE `$tableName`");
            $backup .= $create->{'Create Table'}.";\n\n";
            $rows = DB::table($tableName)->get();
            foreach ($rows as $row) {
                $values = collect((array) $row)->map(fn ($v) => $v === null ? 'NULL' : "'".addslashes((string) $v)."'")->implode(',');
                $backup .= "INSERT INTO `$tableName` VALUES ($values);\n";
            }
        }
        file_put_contents($backupPath, $backup);

        // Clean old backups (keep 5)
        $backups = glob($sqlDir.'/backup_*.sql');
        usort($backups, fn ($a, $b) => filemtime($b) - filemtime($a));
        foreach (array_slice($backups, 5) as $old) {
            unlink($old);
        }

        // Drop all tables and import
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        foreach ($tables as $table) {
            DB::statement('DROP TABLE IF EXISTS `'.$table->$tableKey.'`');
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $sql = file_get_contents($sqlFile);
        DB::unprepared($sql);

        return response('OK: Imported '.basename($sqlFile).', backup: '.$backupName, 200);
    } catch (Exception $e) {
        return response('Error: '.$e->getMessage(), 500);
    }
})->withoutMiddleware([VerifyCsrfToken::class]);
Route::livewire('/', 'pages::home')->name('home');
Route::livewire('/register', 'pages::register')->name('register');
Route::livewire('/payment', 'pages::payment')->name('payment');
