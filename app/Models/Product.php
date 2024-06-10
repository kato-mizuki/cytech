<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable; 

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['product_name', 'price', 'stock','company_id','comment'];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function company()
    {
        return $this->belongsToMany(Company::class, 'id', 'company_name');
    }

    use Sortable; 
    
}