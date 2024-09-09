<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductListController extends Controller
{
    public function index()
    {

        return inertia('ProductList/Index');     

    }
}