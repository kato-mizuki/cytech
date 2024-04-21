<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public function products() {
        return $this->hasMany('App\Models\Product');
    }

    public function getAllCompanies() {

        $companies = $this->all();

        return $companies;
    }
}