<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index() {
        $products = Product::with(['category','subCategory'])->where('quantity', '>', 0)->get();
        return view('index', ['products' => $products]);
    }
}
