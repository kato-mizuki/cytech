<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sale extends Model
{
    public function products()
    {
        return $this->belongsTo('App\Models\Product');
    }
    /*
    public static function purchase($productId){ //$productsは仮。controllerで記述した変数を入れる
        // dd($productId);

        try{
            DB::beginTransaction();

                $product = Product::find($productId); //リクエストから商品IDを取得

                if(!$product) {
                    DB::rollBack();
                    return response()->json(['error' => '商品が存在しません']);
                }

                if($product->stock <= 0) {
                    DB::rollBack();
                    return response()->json(['error' => '在庫が不足しています']);
                }
                //Productsテーブルの在庫数を減らす
                $product->stock -= 1;
                $product->save();

                $sale = new Sale();
                $sale->product_id = $product->id;
                $sale->save();

            DB::commit();
            return ['success' => true];
        
        } catch (\Exception $e) {
            DB::rollBack();
            return ['error' => '購入処理に失敗しました'];
        }
    }
    */
}