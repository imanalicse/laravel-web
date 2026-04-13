<?php

namespace App\Utils;

use Exception;

class HttpClient
{
    protected string $baseUrl;
    protected array $headers;
    protected int $timeout;
    protected int $retryAttempts;

    public function __construct(
        string $baseUrl = '',
        array $headers = [],
        int $timeout = 30,
        int $retryAttempts = 1
    ) {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->headers = $headers;
        $this->timeout = $timeout;
        $this->retryAttempts = $retryAttempts;
    }

    /**
     * Generic request handler
     */
    protected function request(string $method, string $url, array $data = []): array
    {
        $attempts = 0;
        $response = null;

        do {
            $attempts++;
            $ch = curl_init();

            $fullUrl = $this->baseUrl . $url;

            // Query params for GET/DELETE
            if (in_array($method, ['GET', 'DELETE']) && !empty($data)) {
                $fullUrl .= '?' . http_build_query($data);
            }

            curl_setopt_array($ch, [
                CURLOPT_URL => $fullUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => $method,
                CURLOPT_HTTPHEADER => array_merge($this->headers, ['Content-Type: application/json']),
                CURLOPT_TIMEOUT => $this->timeout,
            ]);

            // JSON payload for POST/PUT/PATCH
            if (in_array($method, ['POST', 'PUT', 'PATCH']) && !empty($data)) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            }

            $result = curl_exec($ch);
            $error = curl_error($ch);
            $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if (!$error) {
                $response = [
                    'status' => $statusCode,
                    'body' => json_decode($result, true) ?? $result,
                    'error' => null
                ];
                break;
            }

            $response = [
                'status' => 0,
                'body' => null,
                'error' => $error
            ];

        } while ($attempts < $this->retryAttempts);

        return $response;
    }

    public function get(string $url, array $params = []): array
    {
        return $this->request('GET', $url, $params);
    }

    public function post(string $url, array $data = []): array
    {
        return $this->request('POST', $url, $data);
    }

    public function put(string $url, array $data = []): array
    {
        return $this->request('PUT', $url, $data);
    }

    public function patch(string $url, array $data = []): array
    {
        return $this->request('PATCH', $url, $data);
    }

    public function delete(string $url, array $params = []): array
    {
        return $this->request('DELETE', $url, $params);
    }
}
