<?php

namespace SaKanjo\EasyEnum\Tests;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Lang;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function defineEnvironment($app): void
    {
        $this->loadLangFiles();
    }

    private function loadLangFiles(): void
    {
        // EN
        $enums = require __DIR__.'/lang/en/enums.php';
        $lines = Arr::mapWithKeys($enums, fn ($value, $key) => [
            'enums.'.$key => $value,
        ]);

        Lang::addLines($lines, 'en');

        // TR
        $enums = require __DIR__.'/lang/tr/enums.php';
        $lines = Arr::mapWithKeys($enums, fn ($value, $key) => [
            'enums.'.$key => $value,
        ]);

        Lang::addLines($lines, 'tr');
    }
}
