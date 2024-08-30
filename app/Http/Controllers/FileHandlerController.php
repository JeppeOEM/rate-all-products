<?php

namespace App\Http\Controllers;

use App\Library\FileHandler;
use Illuminate\Http\Request;

class FileHandlerController extends Controller
{
    protected $fileHandler;

    public function __construct(FileHandler $fileHandler)
    {
        $this->fileHandler = $fileHandler;
    }

}