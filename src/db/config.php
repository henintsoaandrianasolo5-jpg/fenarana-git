<?php
declare(strict_types=1);

return [
    // Default for local development
    'DB_HOST' => getenv('DB_HOST') ?: '127.0.0.1',
    'DB_NAME' => getenv('DB_NAME') ?: 'fenarana',
    'DB_USER' => getenv('DB_USER') ?: 'root',
    'DB_PASS' => getenv('DB_PASS') ?: '',
];

