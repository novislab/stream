<?php

/**
 * Auto SQL Import with Backup/Rollback
 *
 * Usage:
 * - Import: POST /import-sql.php?key=SECRET
 * - Rollback: POST /import-sql.php?key=SECRET&action=rollback
 * - List backups: GET /import-sql.php?key=SECRET&action=list
 */

$envFile = dirname(__DIR__) . '/.env';
$config = [];
if (file_exists($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            [$key, $value] = explode('=', $line, 2);
            $config[trim($key)] = trim($value);
        }
    }
}

$secretKey = $config['DEPLOY_KEY'] ?? '';
$action = $_GET['action'] ?? 'import';

// Auth check
if (empty($secretKey) || !isset($_GET['key']) || $_GET['key'] !== $secretKey) {
    http_response_code(403);
    exit('Invalid key');
}

// Database config
$host = $config['DB_HOST'] ?? '127.0.0.1';
$database = $config['DB_DATABASE'] ?? '';
$username = $config['DB_USERNAME'] ?? '';
$password = $config['DB_PASSWORD'] ?? '';
$sqlDir = dirname(__DIR__) . '/sql';

if (empty($database) || empty($username)) {
    http_response_code(500);
    exit('Database not configured in .env');
}

// Ensure sql directory exists
if (!is_dir($sqlDir)) {
    mkdir($sqlDir, 0755, true);
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    switch ($action) {
        case 'list':
            // List all SQL files
            $files = glob($sqlDir . '/*.sql');
            usort($files, fn($a, $b) => filemtime($b) - filemtime($a));
            $list = array_map(fn($f) => basename($f) . ' (' . date('Y-m-d H:i', filemtime($f)) . ')', $files);
            header('Content-Type: application/json');
            echo json_encode($list);
            break;

        case 'rollback':
            // Find latest backup
            $backups = glob($sqlDir . '/backup_*.sql');
            if (empty($backups)) {
                http_response_code(404);
                exit('No backups found');
            }
            usort($backups, fn($a, $b) => filemtime($b) - filemtime($a));
            $backupFile = $backups[0];

            // Import backup
            $sql = file_get_contents($backupFile);
            $pdo->exec($sql);
            echo "OK: Rolled back to " . basename($backupFile);
            break;

        case 'import':
        default:
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                exit('POST required for import');
            }

            // Find latest migration SQL (not backup)
            $migrations = array_filter(
                glob($sqlDir . '/*.sql'),
                fn($f) => strpos(basename($f), 'backup_') !== 0
            );
            if (empty($migrations)) {
                http_response_code(404);
                exit('No migration SQL files found');
            }
            usort($migrations, fn($a, $b) => filemtime($b) - filemtime($a));
            $sqlFile = $migrations[0];

            // Create backup before import
            $backupName = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
            $backupPath = $sqlDir . '/' . $backupName;

            // Export current database
            $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
            $backup = "";
            foreach ($tables as $table) {
                $backup .= "DROP TABLE IF EXISTS `$table`;\n";
                $create = $pdo->query("SHOW CREATE TABLE `$table`")->fetch(PDO::FETCH_ASSOC);
                $backup .= $create['Create Table'] . ";\n\n";

                $rows = $pdo->query("SELECT * FROM `$table`")->fetchAll(PDO::FETCH_ASSOC);
                foreach ($rows as $row) {
                    $values = array_map(fn($v) => $v === null ? 'NULL' : $pdo->quote($v), $row);
                    $backup .= "INSERT INTO `$table` VALUES (" . implode(',', $values) . ");\n";
                }
                $backup .= "\n";
            }
            file_put_contents($backupPath, $backup);

            // Clean old backups (keep 5)
            $backups = glob($sqlDir . '/backup_*.sql');
            usort($backups, fn($a, $b) => filemtime($b) - filemtime($a));
            foreach (array_slice($backups, 5) as $old) {
                unlink($old);
            }

            // Drop all tables and import new SQL
            foreach ($tables as $table) {
                $pdo->exec("DROP TABLE IF EXISTS `$table`");
            }

            $sql = file_get_contents($sqlFile);
            $pdo->exec($sql);

            echo "OK: Imported " . basename($sqlFile) . ", backup: " . $backupName;
            break;
    }

} catch (PDOException $e) {
    http_response_code(500);
    exit('Database error: ' . $e->getMessage());
}
