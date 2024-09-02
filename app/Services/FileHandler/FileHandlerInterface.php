<?php

namespace App\Services\FileHandler;


use Illuminate\Support\Collection;

interface FileHandlerInterface
{
    public function parseFile(string $file): Collection;
}