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

}
