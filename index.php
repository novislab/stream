<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 * This file redirects all requests to public/index.php
 */

// Change to the public directory
chdir(__DIR__ . '/public');

// Include the public index.php
require __DIR__ . '/public/index.php';
