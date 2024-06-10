<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ProductController;


class SalesController extends Controller
{
  public function purchase(Request $request)
  {
      // バリデーション（省略）

      $productId = $request->input('product_id');
      $quantity = $request->input('quantity');

      // トランザクションを開始
      DB::beginTransaction();

      try {
          // 在庫チェック
          $product = Product::find($productId);

          if ($product->stock < $quantity) {
              return response()->json(['error' => '在庫が不足しています。'], 400);
          }

          // salesテーブルに登録
          $sale = new Sale();
          $sale->product_id = $productId;
          $sale->quantity = $quantity;
          $sale->save();

          // 在庫を減算
          $product->stock -= $quantity;
          $product->save();

          // トランザクションをコミット
          DB::commit();

          return response()->json(['success' => '購入が完了しました。']);

      } catch (\Exception $e) {
          // エラーが発生した場合はトランザクションをロールバック
          DB::rollBack();
          return response()->json(['error' => '購入処理中にエラーが発生しました。'], 500);
      }
      return redirect()->route('products.index');
  }
}