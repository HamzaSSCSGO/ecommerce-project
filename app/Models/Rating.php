<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rating extends Model
{
    use HasFactory;
    public $guarded = [];

    public function user(){
        return $this->belongsToOne(User::class,'user_id');
    }

    public function product(){
        return $this->belongsToOne(Product::class,'product_id');
    }
}
