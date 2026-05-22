<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['category_name'];

    /**
     * Category has many pets.
     */
    public function pets()
    {
        return $this->hasMany(Pet::class);
    }
}
