<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class GuzzleHttpService
{
    private LoggerService $logger;

    public function __construct()
    {
        $this->logger = new LoggerService();
    }

    public function sendRequest(
        string $endPoint,
        array $body = [],
        array $headers = [],
        array $options = [],
        string $method = 'GET'
    ): ?string {
        if (count($body) == 0) {
            $request = new Request($method, $endPoint, $headers);
        } else {
            $request = new Request($method, $endPoint, $headers, json_encode($body));
        }

        $client = new Client(
            [
                'headers' => $headers,
                'http_errors' => false,
                'verify' => false,
            ]
        );

        try {
            if (count($options) == 0) {
                $response = $client->sendAsync($request)->wait();
            } else {
                $response = $client->sendAsync($request, $options)->wait();
            }
        } catch (\Exception $exception) {
            $this->logger->log(
                "GuzzleHttpService | sendRequest | Exception",
                [
                    "exception" => $exception->getMessage(),
                    "endPoint" => $endPoint,
                    "method" => $method,
                ],
                $this->logger::ERROR_LEVEL
            );

            return null;
        }

        if ($response->getStatusCode() == 200) {
            return $response->getBody()->getContents();
        }

        $this->logger->log(
            "GuzzleHttpService | sendPostRequest | Data sent and got",
            [
                "status_code" => $response->getStatusCode(),
            ]
        );

        return null;
    }
}
