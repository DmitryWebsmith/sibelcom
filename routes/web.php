<?php

use App\Http\Controllers\HomeController;
use App\Services\ViewService;

$viewService = new ViewService();

if ($_SERVER['SCRIPT_NAME'] === "/index.php") {
    $home = new HomeController();
    echo $home->index();
} else {
    echo $viewService->renderPageNotFound();
}