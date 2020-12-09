<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductGallery extends Model
{
    protected $fillable = [
        'photos', 'products_id'
    ];

    // untuk tidak menampilkan di data table, misal photo
    protected $hidden = [
        
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id', 'id');
    }
}