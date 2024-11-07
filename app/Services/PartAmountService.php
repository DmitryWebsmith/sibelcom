<?php

namespace App\Services;

use Symfony\Component\DomCrawler\Crawler;

class PartAmountService
{
    private GuzzleHttpService $guzzleHttpService;
    private ScrapeDynamicHtmlService $scrapeDynamicHtmlService;
    public function __construct()
    {
        $this->guzzleHttpService = new GuzzleHttpService();
        $this->scrapeDynamicHtmlService = new ScrapeDynamicHtmlService();
    }

    public function getPartAmounts(): array
    {
        $data = [
            [
                'url' => 'https://www.promelec.ru/search/?query=BAS521%2C115',
                'referer' => 'https://www.promelec.ru/',
                'cssSelector' => '.col-table-amount > div:nth-child(1) > div:nth-child(2) > span:nth-child(1)',
                'dynamicHtml' => false,
            ],
            [
                'url' => 'https://www.chipdip.ru/search?searchtext=BAS521%2C115',
                'referer' => 'https://www.chipdip.ru/',
                'cssSelector' => '#item9000034139 > td:nth-child(3) > div:nth-child(1) > span:nth-child(1)',
                'dynamicHtml' => false,
            ],
            [
                'url' => 'https://www.chip1stop.com/USA/en/view/searchResult/SearchResultTop?keyword=BAS521%2C115&partSameFlg=false',
                'referer' => 'https://www.chip1stop.com/',
                'cssSelector' => '#tableSearchResult_1_0_0 > td:nth-child(1) > div:nth-child(4) > p:nth-child(3)',
                'dynamicHtml' => true,
            ],
        ];

        $partNumber = "BAS521,115";

        $partAmountsList = [];

        foreach ($data as $item) {
            $partAmount = $this->getPartAmount($item);
            $partAmountsList[] = [
                'url' => $item['url'],
                'partAmount' => $partAmount === null ? 'N/A' : $partAmount,
            ];
        }

        // Сортировка массива по ключу partAmount
        usort($partAmountsList, function($a, $b) {
            // Преобразуем значения в числа, чтобы корректно сравнивать
            $aValue = is_numeric($a['partAmount']) ? (int)$a['partAmount'] : PHP_INT_MIN;
            $bValue = is_numeric($b['partAmount']) ? (int)$b['partAmount'] : PHP_INT_MIN;

            return $bValue <=> $aValue;
        });

        return [
            'task' => 2,
            'partAmountsList' => $partAmountsList,
            'partNumber' => $partNumber,
        ];
    }

    // метод получает html заданного url, парсит и возвращает количество деталей
    private function getPartAmount(array $partValueLocation): ?int
    {
        if ($partValueLocation['dynamicHtml']) {
            $html = $this->scrapeDynamicHtmlService->getHtml($partValueLocation['url']);
        } else {
            $html = $this->guzzleHttpService->sendRequest($partValueLocation['url'], [], [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                'Accept-Language' => 'en-US,en;q=0.9',
                'Accept-Encoding' => 'gzip, deflate, br',
                'Connection' => 'keep-alive',
                'Referer' => $partValueLocation['referer'],
            ]);
        }

        if ($html === null) {
            return null;
        }

        $crawler = new Crawler($html);
        $nodes = $crawler->filter($partValueLocation['cssSelector']);

        if ($nodes->count() === 0) {
            return null;
        }

        $partValue = 0;
        foreach ($nodes as $node) {
            $partValue = $node->textContent;
            break;
        }

        $partValue = preg_replace('/\D/', '', $partValue);

        return (int)$partValue;
    }
}
