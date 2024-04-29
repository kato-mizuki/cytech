<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    public function products()
    {
        Company::factory()
        ->count(50)
        ->hasPosts(1)
        ->create();
        return $this->hasMany(Product::class);
    }
}