<?php

declare(strict_types=1);

const SERVICE_HOST = 'localhost';
const SERVICE_PORT = '8000';
const SERVICE_TASK_PATH = '/todo/api/tasks';

/**
 * @return array{status:int,body:array<string,mixed>|list<mixed>|null}
 */
function request_json(string $method, string $path, ?array $payload = null): array
{
    $url = 'http://'.SERVICE_HOST.':'.SERVICE_PORT.$path;

    $ch = curl_init($url);
    if ($ch === false) {
        throw new RuntimeException('Unable to initialize cURL.');
    }

    $headers = ['Accept: application/json'];
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    if ($payload !== null) {
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload, JSON_THROW_ON_ERROR));
    }

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $rawResponse = curl_exec($ch);
    if ($rawResponse === false) {
        $error = curl_error($ch);
        curl_close($ch);
        throw new RuntimeException("HTTP request failed: {$error}");
    }

    $status = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    curl_close($ch);

    $decoded = json_decode($rawResponse, true);

    return [
        'status' => $status,
        'body' => is_array($decoded) ? $decoded : null,
    ];
}

function print_response(string $label, array $response): void
{
    echo $label.PHP_EOL;
    echo 'Status: '.$response['status'].PHP_EOL;
    echo json_encode($response['body'], JSON_PRETTY_PRINT).PHP_EOL;
    echo str_repeat('-', 40).PHP_EOL;
}
