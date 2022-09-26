<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['category_name'];

    public $timestamps = false;

    protected function categoryName() : Attribute {
        return Attribute::make(
            get: fn ($value) => ucwords(html_entity_decode($value)),
            set: fn ($value) => strtolower($value)
        );
    }

    public function subCategory() {
        return $this->hasMany(SubCategory::class);
    }

    public function product() {
        return $this->hasMany(Product::class,'category_id','id');
    }
}
