<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_images extends Model
{
    use HasFactory;

    public function images()
{
    return $this->hasMany(Pro::class, 'product_id');
}
}
