<?php

namespace Core;

class Response
{
    private string $message;
    private array|string $data;
    private int $status_code;

    public function __construct(string $message = '', array|string $data = [], int $status_code = 200)
    {
        $this->message = $message;
        $this->data = $data;
        $this->status_code = $status_code;
    }

    public function __toString(): string
    {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($this->status_code);

        $response = [
            'message' => $this->message,
            'data' => $this->data,
            'success' => $this->status_code == 200
        ];

        return json_encode($response, JSON_UNESCAPED_SLASHES);
    }
}