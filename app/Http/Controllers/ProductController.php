<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    
    public function index() {
        $products = Product::with(['category','subCategory'])->get();
        $categories = Category::with('subCategory')->get();
        return view('admin.products', ['products' => $products, 'categories' => $categories]);
    }

    public function create(Request $r) {

        $r->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'category_id' => 'required|numeric|gt:0',
            'sub_category_id' => 'required|numeric|gt:0',
            'price' => 'required|numeric|gt:0',
            'quantity' => 'required|integer|gt:0',
            'size' => [
                'required',
                Rule::in(['S','M','L','XL','XXL'])
            ],
            'image' => 'required|url'
        ]);

        $p = new Product;
        $p->name = $r->name;
        $p->description = $r->description;
        $p->category_id = $r->category_id;
        $p->sub_category_id = $r->sub_category_id;
        $p->price = $r->price;
        $p->quantity = $r->quantity;
        $p->size = $r->size;
        $p->image = $r->image;

        $p->save();

        return redirect('/admin/products');

    }

}
