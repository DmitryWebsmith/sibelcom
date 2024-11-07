<?php

declare(strict_types=1);

namespace App\Services;

class ReadInputFileService
{
    const string STATUS_SUCCESS = 'success';
    const string STATUS_ERROR = 'error';

    private array $inputData;

    public function __construct(string $filename)
    {
        $this->inputData = $this->readFile($filename);
    }

    // метод возвращает массив документов
    public function getDocuments(): array
    {
        if ($this->inputData['status'] === self::STATUS_ERROR) {
            return $this->inputData;
        }

        $docsAmount = (int)$this->inputData['data'][0];
        $docsList = [];

        for ($i = 1; $i <= $docsAmount; $i++) {
            $docsList[] = $this->inputData['data'][$i];
        }

        return $docsList;
    }

    // метод возвращает массив запросов
    public function getQueries(): array
    {
        if ($this->inputData['status'] === self::STATUS_ERROR) {
            return $this->inputData;
        }

        $docsAmount = (int)$this->inputData['data'][0];
        $queriesAmount = (int)$this->inputData['data'][$docsAmount+1];

        $queriesList = [];

        for ($i = $docsAmount+2; $i <= $docsAmount+$queriesAmount+1; $i++) {
            $queriesList[] = $this->inputData['data'][$i];
        }

        return $queriesList;
    }

    // метод читает построчно файл и возвращает массив строк
    private function readFile(string $filename): array
    {
        $lines = [];

        if (!file_exists($filename)) {
            return [
                'status' => self::STATUS_ERROR,
                'message' => 'File not found',
            ];
        }

        $file = fopen($filename, 'r');

        while (($line = fgets($file)) !== false) {
            $lines[] = trim($line);
        }

        fclose($file);

        return [
            'status' => self::STATUS_SUCCESS,
            'data' => $lines,
        ];
    }
}