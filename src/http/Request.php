<?php
declare(strict_types=1);

class Request
{
    public string $method;
    public string $path;
    public array $query;
    public array $post;
    public array $headers;

    public function __construct()
    {
        $this->method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
        $this->path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
        $this->query = $_GET ?? [];
        $this->post = $_POST ?? [];
        $this->headers = function_exists('getallheaders') ? (array)getallheaders() : [];
    }

    public function getString(string $key, ?string $default = null): ?string
    {
        $value = $this->post[$key] ?? $this->query[$key] ?? $default;
        if ($value === null) return null;
        return is_string($value) ? trim($value) : (string)$value;
    }

    public function getInt(string $key, ?int $default = null): ?int
    {
        $value = $this->post[$key] ?? $this->query[$key] ?? $default;
        if ($value === null) return null;
        return (int)$value;
    }
}

