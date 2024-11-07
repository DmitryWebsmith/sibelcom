<?php

namespace App\Services;

class ScrapeDynamicHtmlService
{
    private LoggerService $logger;

    public function __construct()
    {
        $this->logger = new LoggerService();
    }

    public function getHtml(string $url): ?string
    {
        $output = [];
        $returnVar = 0;
        $scrapeJsPath = dirname(__DIR__, 2) . '/resources/js/scrape.js';

        // CLI проверка
        // node resources/js/scrape.js "https://www.chip1stop.com/USA/en/view/searchResult/SearchResultTop?keyword=BAS521%2C115&partSameFlg=false"
        exec("node " . $scrapeJsPath . " " . $url, $output, $returnVar);

        if ($returnVar !== 0) {
            $this->logger->log(
                "ScrapeDynamicHtmlService | getHtml",
                [
                    "url" => $url,
                    "returnVar" => $returnVar,
                    "Ошибка: " => $output,
                ],
                $this->logger::ERROR_LEVEL
            );
            return null;
        }

        return implode("\n", $output);
    }
}
