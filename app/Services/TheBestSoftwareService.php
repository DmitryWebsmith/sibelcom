<?php

namespace App\Services;

use Parsedown;

class TheBestSoftwareService
{
    public function getDescriptionOfTheBestSoftware(): ?array
    {
        $filePath = dirname(__DIR__, 2) . '/storage/task3.txt';
        $content = file_get_contents($filePath);

        if ($content === false) {
            return null;
        }

        $parsedown = new Parsedown();
        $html = $parsedown->text($content);

        return [
            'task' => 3,
            'description' => $html,
        ];
    }
}
