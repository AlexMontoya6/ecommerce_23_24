<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;

    //he borrado 'image,' del $fillable
    protected $fillable = ['name', 'slug', 'category_id', 'color', 'size'];
    //protected $guarded = ['id', 'created_at', 'updated_at'];

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

}
