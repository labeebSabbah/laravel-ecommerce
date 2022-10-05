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

    public function add(Request $r) {
        $p = Product::find($r->id);
        $arr = $_SESSION['cart'] ?? array();
        $mod = 0;
        if (count($arr) == 0) {} else {
            for ($i=0; $i < count($arr); $i++) { 
                if ($r->id == $arr[$i]['product']->id) {
                    $arr[$i]['quantity'] += 1;
                    $mod = 1;
                    break;
                }
        }
        }
        if (!$mod) {
            $arr[] = ['product' => $p, 'quantity' => 1];
        }
        $_SESSION['cart'] = $arr;
    } 

    public function delete(Request $r) {
        $arr = $_SESSION['cart'] ?? array();
        for ($i=0; $i < count($arr); $i++) { 
            if ($r->id == $arr[$i]['product']->id) {
                $arr[$i]['quantity'] -= 1;
                if ($arr[$i]['quantity'] == 0) {
                    unset($arr[$i]);
                    $arr = array_values($arr);
                    break;
                }
            }
        }
        $_SESSION['cart'] = $arr;
    }

    public function search(Request $r) {
        $products = Product::where('name', 'like' ,"%{$r->name}%")
        ->join('sub_categories', 'products.sub_category_id', '=', 'sub_categories.id')
        ->when($r->category, function ($q) use ($r) {
            return $q->where('products.category_id', $r->category);
        })->when($r->subCategory, function ($q) use ($r) {
            return $q->where('sub_categories.sub_category_name', $r->subCategory);
        })
        ->when($r->size, function ($q) use ($r) {
            return $q->where('size', $r->size);
        })
        ->when($r->min, function ($q) use ($r) {
            return $q->where('price', '>=', $r->min);
        })
        ->when($r->max, function ($q) use ($r) {
            return $q->where('price', '<=', $r->max);
        })->get();
        return view('products', ['products' => $products]);
    }

}
