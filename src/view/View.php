<?php
declare(strict_types=1);

class View
{
    public function render(string $template, array $vars = []): void
    {
        // template e.g. 'products/index'
        $file = __DIR__ . '/../../views/' . $template . '.php';
        if (!file_exists($file)) {
            http_response_code(500);
            echo "View not found: " . htmlspecialchars($template);
            return;
        }

        extract($vars, EXTR_SKIP);
        require $file;
    }
}

