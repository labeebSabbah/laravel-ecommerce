<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index() {

        $cats = Category::with('subCategory')->get();
        return view('admin.categories', ['cats' => $cats]);

    }

    public function createCat(Request $r) {

        $r->validate([
            'name' => 'required|unique:categories,category_name|max:255'
        ]);

        $c = new Category;
        $c->category_name = $r->name;

        $c->save();

        return redirect('/admin/categories');

    }

    public function updateCat(Request $r) {

        $r->validate([
            'name' => 'required|unique:categories,category_name'
        ]);

        $c = Category::find($r->id);
        $c->category_name = $r->name;
        $c->save();

        return $c;
    }

    public function subCats(Request $r) {
        $subs = SubCategory::where('category_id', $r->id)->get();
        foreach ($subs as $s) {
            echo "<option value='{$s->id}'>{$s->sub_category_name}</option>";
        }
    }

    public function deleteCat(Request $r) {
        $c = Category::find($r->id);
        $c->delete();
        return $c;
    }

    public function createSub(Request $r) {
        $r->validate([
            'name' => [
                'required',
                Rule::unique('sub_categories','sub_category_name')->where('category_id', $r->category_id)
            ],
            'category_id' => 'required'
        ]);

        $s = new SubCategory;
        $s->sub_category_name = $r->name;
        $s->category_id = $r->category_id;
        $s->save();

        return redirect('/admin/categories');

    }

    public function updateSub(Request $r) {

        $r->validate([
            'name' => [
                'required',
                Rule::unique('sub_categories','sub_category_name')->where('category_id', $r->category_id)
            ]
        ]);

        $c = SubCategory::find($r->id);
        $c->sub_category_name = $r->name;
        $c->save();

        return $c;
    }

    public function deleteSub(Request $r) {
        $c = SubCategory::find($r->id);
        $c->delete();
        return $c;
    }
    
}
