<?php

declare(strict_types=1);

namespace App\Services;

class DetermineRelevanceService
{
    public function getRelevanceResults(): array
    {
        $filepath = dirname(__DIR__, 2) . '/storage/input.txt';

        $readInputFileService = new ReadInputFileService($filepath);
        $documents = $readInputFileService->getDocuments();
        $queries = $readInputFileService->getQueries();

        $determineRelevanceService = new DetermineRelevanceService();
        $queryRelevances = [];
        foreach ($queries as $key => $query) {
            $queryRelevances[$key] = $determineRelevanceService->getQueryRelevanceToAllDocuments($documents, $query);
        }

        return [
            'documents' => $documents,
            'queries' => $queries,
            'queryRelevances' => $queryRelevances,
            'task' => 1,
        ];
    }

    // метод возвращает список релевантных запросу документов в порядке убывания релевантности
    private function getQueryRelevanceToAllDocuments(array $documents, string $query): string
    {
        $relevanceList = [];

        foreach ($documents as $documentNumber => $document) {
            $relevance = $this->getQueryRelevanceToDocument($document, $query);
            $relevanceList[] = [
                'relevance' => $relevance,
                'documentNumber' => $documentNumber,
            ];
        }

        // Сортировка массива по ключу 'relevance' в порядке убывания
        usort($relevanceList, function ($a, $b) {
            return $b['relevance'] <=> $a['relevance'];
        });

        // приведение к требуемому формату: номера документов, и немного отсебя, в скобках значени релевантности документа запросу
        // исключение документов с нулевой релевантностью
        $relevantDocuments = [];
        foreach ($relevanceList as $relevantDocument) {
            if ($relevantDocument['relevance'] === 0) {
                continue;
            }
            $relevantDocuments[] = $relevantDocument['documentNumber'] . '(' . $relevantDocument['relevance'] . ')';
        }

        return implode(" ", $relevantDocuments);
    }

    // метод возвращает суммарную величину релевантности запроса для заданного документа
    private function getQueryRelevanceToDocument(string $document, string $query): int
    {
        $queryWords = explode(' ', $query);

        $relevance = 0;

        foreach ($queryWords as $word) {
            $relevance += $this->countWordOccurrences($document, $word);
        }

        return $relevance;
    }

    // метод считает количество вхождений слов в строке
    private function countWordOccurrences($string, $word): int
    {
        // Используем регулярное выражение для поиска слова с границами
        $pattern = '/\b' . preg_quote($word, '/') . '\b/i'; // 'i' для нечувствительности к регистру
        preg_match_all($pattern, $string, $matches);
        return count($matches[0]);
    }
}
