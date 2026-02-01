<?php

/**
 * Zero-downtime deployment activator for cPanel
 * Switches the active release atomically
 */
$deployKeyFile = dirname(__DIR__, 2).'/deploy_key.txt';
$deployKey = file_exists($deployKeyFile) ? trim(file_get_contents($deployKeyFile)) : '';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method not allowed');
}

if (! isset($_POST['key']) || $_POST['key'] !== $deployKey || ($deployKey === '' || $deployKey === '0')) {
    http_response_code(403);
    exit('Invalid deploy key');
}

if (! isset($_POST['release']) || empty($_POST['release'])) {
    http_response_code(400);
    exit('Release name required');
}

$release = preg_replace('/[^a-zA-Z0-9_-]/', '', (string) $_POST['release']);
$homeDir = dirname(__DIR__, 2);
$releasesDir = $homeDir.'/releases';
$releasePath = $releasesDir.'/'.$release;
$sharedDir = $homeDir.'/shared';
$currentLink = $homeDir.'/current';

if (! is_dir($releasePath)) {
    http_response_code(404);
    exit('Release not found: '.$release);
}

try {
    // Setup shared directories
    $sharedDirs = [
        '/storage/app/public',
        '/storage/framework/cache/data',
        '/storage/framework/sessions',
        '/storage/framework/views',
        '/storage/logs',
    ];

    foreach ($sharedDirs as $dir) {
        $path = $sharedDir.$dir;
        if (! is_dir($path)) {
            mkdir($path, 0755, true);
        }
    }

    // Remove release storage and link to shared
    $releaseStorage = $releasePath.'/storage';
    if (is_dir($releaseStorage) && ! is_link($releaseStorage)) {
        exec('rm -rf '.escapeshellarg($releaseStorage));
    }
    if (! file_exists($releaseStorage)) {
        symlink($sharedDir.'/storage', $releaseStorage);
    }

    // Link .env from shared
    $releaseEnv = $releasePath.'/.env';
    $sharedEnv = $sharedDir.'/.env';
    if (file_exists($sharedEnv)) {
        if (file_exists($releaseEnv) && ! is_link($releaseEnv)) {
            unlink($releaseEnv);
        }
        if (! file_exists($releaseEnv)) {
            symlink($sharedEnv, $releaseEnv);
        }
    }

    // Atomic switch: update ~/current symlink
    $tempLink = $homeDir.'/current_new';
    if (file_exists($tempLink)) {
        unlink($tempLink);
    }
    symlink($releasePath, $tempLink);
    rename($tempLink, $currentLink);

    // Run Laravel optimizations
    $artisan = $currentLink.'/artisan';
    if (file_exists($artisan)) {
        exec('cd '.escapeshellarg($currentLink).' && php artisan config:cache 2>&1');
        exec('cd '.escapeshellarg($currentLink).' && php artisan route:cache 2>&1');
        exec('cd '.escapeshellarg($currentLink).' && php artisan view:cache 2>&1');
        exec('cd '.escapeshellarg($currentLink).' && php artisan migrate --force 2>&1');
    }

    // Cleanup old releases (keep 5)
    $releases = glob($releasesDir.'/release_*');
    usort($releases, fn ($a, $b) => filemtime($b) - filemtime($a));

    foreach (array_slice($releases, 5) as $old) {
        exec('rm -rf '.escapeshellarg((string) $old));
    }

    // Log deployment
    $log = date('Y-m-d H:i:s')." - Activated: $release\n";
    file_put_contents($homeDir.'/deployments.log', $log, FILE_APPEND);

    echo "OK: Activated $release";

} catch (Exception $e) {
    http_response_code(500);
    exit('Error: '.$e->getMessage());
}
