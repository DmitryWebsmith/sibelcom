<?php

namespace App\Services;

use eftec\bladeone\BladeOne;

class ViewService
{
    private BladeOne $blade;

    public function __construct()
    {
        $this->blade = new BladeOne(
            dirname(__DIR__, 2) . '/resources/views',
            dirname(__DIR__, 2) . '/resources/cache' ,
            BladeOne::MODE_DEBUG);
    }

    public function render(string $view, array $data = []): string
    {
        return $this->blade->run($view, $data);
    }

    public function renderPageNotFound(): string
    {
        return $this->blade->run('page-not-found', []);
    }
}
