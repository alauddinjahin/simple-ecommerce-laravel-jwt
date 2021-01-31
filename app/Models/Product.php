<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    
    protected $fillable = [ 'title','category_id','subcategory_id', 'description', 'unit_price', 'is_active', 'image', 'created_by', 'updated_by'];


    public $timestamps = true;


    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }


    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_id');
    }


    // public function pictures()
    // {
    //     return $this->morphMany(Image::class,'imageable');
    // }


}
