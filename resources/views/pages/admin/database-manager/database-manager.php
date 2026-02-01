<?php

declare(strict_types=1);

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts::admin')] #[Title('Database Manager')] class extends Component
{
    public string $message = '';

    public string $messageType = 'success';

    #[Computed]
    public function sqlFiles(): array
    {
        $sqlDir = base_path('sql');
        if (! is_dir($sqlDir)) {
            return [];
        }

        $files = glob($sqlDir.'/*.sql');
        usort($files, fn ($a, $b) => filemtime($b) - filemtime($a));

        return array_map(fn ($file) => [
            'name' => basename($file),
            'path' => $file,
            'size' => $this->formatBytes(filesize($file)),
            'date' => date('Y-m-d H:i:s', filemtime($file)),
            'isBackup' => str_starts_with(basename($file), 'backup_'),
        ], $files);
    }

    #[Computed]
    public function migrations(): array
    {
        return array_values(array_filter($this->sqlFiles, fn (array $f) => ! $f['isBackup']));
    }

    #[Computed]
    public function backups(): array
    {
        return array_values(array_filter($this->sqlFiles, fn (array $f) => $f['isBackup']));
    }

    public function importLatest(): void
    {
        $migrations = $this->migrations;
        if (empty($migrations)) {
            $this->setMessage('No migration SQL files found', 'error');

            return;
        }

        $this->importFile($migrations[0]['path']);
    }

    public function importFile(string $path): void
    {
        if (! file_exists($path)) {
            $this->setMessage('File not found', 'error');

            return;
        }

        try {
            // Create backup first
            $this->createBackup();

            // Drop all tables
            $tables = DB::select('SHOW TABLES');
            $tableKey = 'Tables_in_'.config('database.connections.mysql.database');

            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            foreach ($tables as $table) {
                DB::statement('DROP TABLE IF EXISTS `'.$table->$tableKey.'`');
            }
            DB::statement('SET FOREIGN_KEY_CHECKS=1');

            // Import new SQL
            $sql = file_get_contents($path);
            DB::unprepared($sql);

            $this->setMessage('Imported '.basename($path).' successfully', 'success');
            unset($this->sqlFiles, $this->migrations, $this->backups);

        } catch (Exception $e) {
            $this->setMessage('Import failed: '.$e->getMessage(), 'error');
        }
    }

    public function rollback(string $backupName): void
    {
        $path = base_path('sql/'.$backupName);
        if (! file_exists($path)) {
            $this->setMessage('Backup file not found', 'error');

            return;
        }

        try {
            // Drop all tables
            $tables = DB::select('SHOW TABLES');
            $tableKey = 'Tables_in_'.config('database.connections.mysql.database');

            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            foreach ($tables as $table) {
                DB::statement('DROP TABLE IF EXISTS `'.$table->$tableKey.'`');
            }
            DB::statement('SET FOREIGN_KEY_CHECKS=1');

            // Import backup
            $sql = file_get_contents($path);
            DB::unprepared($sql);

            $this->setMessage('Rolled back to '.$backupName, 'success');
            unset($this->sqlFiles, $this->migrations, $this->backups);

        } catch (Exception $e) {
            $this->setMessage('Rollback failed: '.$e->getMessage(), 'error');
        }
    }

    public function createBackup(): void
    {
        $sqlDir = base_path('sql');
        if (! is_dir($sqlDir)) {
            mkdir($sqlDir, 0755, true);
        }

        $backupName = 'backup_'.date('Y-m-d_H-i-s').'.sql';
        $backupPath = $sqlDir.'/'.$backupName;

        try {
            $tables = DB::select('SHOW TABLES');
            $tableKey = 'Tables_in_'.config('database.connections.mysql.database');

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
                $backup .= "\n";
            }

            file_put_contents($backupPath, $backup);

            // Clean old backups (keep 5)
            $backups = glob($sqlDir.'/backup_*.sql');
            usort($backups, fn ($a, $b) => filemtime($b) - filemtime($a));
            foreach (array_slice($backups, 5) as $old) {
                unlink($old);
            }

            unset($this->sqlFiles, $this->migrations, $this->backups);

        } catch (Exception $e) {
            $this->setMessage('Backup failed: '.$e->getMessage(), 'error');
        }
    }

    public function deleteFile(string $name): void
    {
        $path = base_path('sql/'.$name);
        if (file_exists($path)) {
            unlink($path);
            $this->setMessage('Deleted '.$name, 'success');
            unset($this->sqlFiles, $this->migrations, $this->backups);
        }
    }

    protected function setMessage(string $message, string $type): void
    {
        $this->message = $message;
        $this->messageType = $type;
    }

    protected function formatBytes(int $bytes): string
    {
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2).' MB';
        }
        if ($bytes >= 1024) {
            return number_format($bytes / 1024, 2).' KB';
        }

        return $bytes.' B';
    }
};
