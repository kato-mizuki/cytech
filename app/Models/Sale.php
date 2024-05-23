<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sale extends Model{
    //リレーション
    public function product(){
        return $this->belongsTo(Product::class);
      }//6/20
    
      public function detail($id) {
        $products = DB::table('products')
            ->where('id', $id)
            ->first();
        return $products;
    }

    public function purchase($quantity, $id) {
        $product = DB::table('products')
            ->where('id', $id)
            ->first();
        if($product->stock >= $quantity) {
            $product->stock -= $quantity;

            DB::table('products')
                ->where('id', $id)
                ->update([
                    'stock' => $product->stock
                ]);

            DB::table('sales')
                ->insert([
                    'product_id' => $id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);  
             return 'success';

        } else {
            return 'out of order';
        }
   
    }
}