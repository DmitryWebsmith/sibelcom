<?php

namespace App\Http\Controllers;

use App\Services\DetermineRelevanceService;
use App\Services\PartAmountService;
use App\Services\TheBestSoftwareService;
use App\Services\ViewService;

class HomeController
{
    private ViewService $viewService;
    private DetermineRelevanceService $determineRelevanceService;
    private PartAmountService $partAmountService;
    private TheBestSoftwareService $bestSoftwareService;

    public function __construct()
    {
        $this->viewService = new ViewService();
        $this->determineRelevanceService  = new DetermineRelevanceService();
        $this->partAmountService  = new PartAmountService();
        $this->bestSoftwareService = new TheBestSoftwareService();
    }

    public function index(): string
    {
        $task = $_GET['task'] ?? 1;

        if ($task == 1) {
            return $this->viewService->render(
                'task1',
                $this->determineRelevanceService->getRelevanceResults()
            );
        } elseif ($task == 2) {
            return $this->viewService->render(
                'task2',
                $this->partAmountService->getPartAmounts()
            );
        } elseif ($task == 3) {
            return $this->viewService->render(
                'task3',
                $this->bestSoftwareService->getDescriptionOfTheBestSoftware()
            );
        }

        return $this->viewService->renderPageNotFound();
    }
}