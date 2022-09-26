<?php

namespace App\Models;

use GuzzleHttp\Handler\Proxy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = ['sub_category_name','category_id'];

    public $timestamps = false;

    protected function subCategoryName() : Attribute {
        return Attribute::make(
            get: fn ($value) => ucwords(html_entity_decode($value)),
            set: fn ($value) => strtolower($value)
        );
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function product() {
        return $this->hasMany(Product::class,'sub_category_id','id');
    }
}
