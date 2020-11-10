<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;


    protected $fillable = ['name', 'description', 'ships_from', 'price'];

    /**
     * Get the reviews of the product.
     */
    public function reviews()
    {
        return $this->hasMany('App\Models\Review');
    }

    /**
     * Get the company that added the product.
     */
    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }

    /**
     * Get the user that added the product.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
