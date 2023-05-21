<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Listing;

class Product_images extends Model
{
    use HasFactory;
    
    public function product()
    {
        return $this->belongsTo(Listing::class, 'product_id');
    }
}
