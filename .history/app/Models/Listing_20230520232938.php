<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product_images;


class Listing extends Model
{
    use HasFactory;
    protected $fillable = ['id','product_id','path'];


}
