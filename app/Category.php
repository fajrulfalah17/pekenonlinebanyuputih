<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name','photo', 'slug'
    ];

    // untuk tidak menampilkan di data table, misal photo
    protected $hidden = [
        
    ];
}