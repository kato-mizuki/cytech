<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Company;
use Kyslik\ColumnSortable\Sortable;

class Product extends Model
{
    use Sortable;

    protected $table = 'products';

    //登録・変更可能なカラムを設定
    protected $fillable = [
        'name',
        'price',
        'stock',
        'comment',
        'image_path',
        'company_id'
    ];
    //ソートするカラムを記入
    public $sortable = ['id', 'name', 'price', 'stock'];

    public function company() {
        return $this->belongsTo('App\Models\Company');
    }

    public function sale() {
        return $this->hasMany('App\Models\Sale');
    }
    
    public function getList($input) {

        // $companies = Company::all();
        //50行目・58行目で存在しない変数を探そうとしているため、事前に定義しておく
        $keyword = '';
        $companyId = '';
        $minPrice = '';
        $maxPrice = '';
        $minStock = '';
        $maxStock = '';
        //検索フォーム 入力内容処理
        if(array_key_exists('keyword', $input)) {
          $keyword = $input['keyword'];
        }     
        if(array_key_exists('companyId', $input)) {
          $companyId = $input['companyId'];
        }
        if(array_key_exists('minPrice', $input)) {
            $minPrice = $input['minPrice'];
        }
        if(array_key_exists('maxPrice', $input)) {
            $maxPrice =$input['maxPrice'];
        }
        if(array_key_exists('minStock', $input)) {
            $minStock =$input['minStock'];
        }
        if(array_key_exists('maxStock', $input)) {
            $maxStock =$input['maxStock'];
        }

        $query = Product::query();

        if(!empty($keyword)) {
            $query->where('name', 'LIKE', "%{$keyword}%");
        }
        if(!empty($companyId)) {
            $query->where('company_id', 'LIKE', "$companyId");
        }

        if((isset($minPrice)) && (isset($maxPrice))) {
            $query->whereBetween('price',[$minPrice, $maxPrice]);
        } elseif(isset($minPrice)) {
            $query->where('price', '>=', $minPrice);
        } elseif(isset($maxPrice)) {
            $query->where('price', '<=', $maxPrice);
        }
        // $query->where('price', '>=', 200);

        if((isset($minStock)) && (isset($maxStock))) {
            $query->whereBetween('stock',[$minStock, $maxStock]);
        } elseif(isset($minStock)) {
            $query->where('stock', '>=', $minStock);
        } elseif(isset($maxStock)) {
            $query->where('stock', '<=', $maxStock);
        }

        if(empty($keyword) && empty($companyId) && empty($minPrice) && empty($maxPrice) && empty($minStock) && empty($maxStock)) {
         $products = Product::sortable()->get();
        }else{
         $products = $query->sortable()->get();
        }
        // dd($products);
        return $products; //controllerで呼び出した$productsに処理した結果を返している
    }

    //controller記載のstoreメソッド移行
    public function createNewProduct($request) {
        //if文でファイルが選択されなかった場合は$img = nullとする
        //$filename = $request->image_path->getClientOriginalName();
        //$img = $request->image_path->storeAs('public', $filename);
        if ($request->hasFile('image_path')) {
            $filename = $request->image_path->getClientOriginalName();
            $img = $request->image_path->storeAs('public', $filename);
        } else {
            $img = '';
        }

        $product = new Product();
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');
        $product->comment = $request->input('comment');
        $product->image_path = $img;
        $product->company_id = $request->input('company_id');
        $product->save();

        return $product;
    }

    public function updateProduct($data) {

        $product = Product::findOrFail($data['id']);
        $product->name = $data['name'];
        $product->price = $data['price'];
        $product->stock = $data['stock'];
        $product->comment =$data['comment'];
        $product->company_id = $data['company_id'];

        if(isset($data['image_path'])) {
            Storage::delete('public', $product->image_path);
            $filename = $data['image_path']->getClientOriginalName();
            $img = $data['image_path']->storeAs('public', $filename);
            $product->image_path = $img;
        }

        $product->save();
        /*
        if ($request->hasFile('image_path')) {
            Storage::delete('public', $product->image_path);
            $filename = $request->image_path->getClientOriginalName();
            $img = $request->image_path->storeAs('public', $filename);
            $product->image_path = $img;
            //$product->save();
        }
        //dd($product);
        //$product->save($request->except('image_path'));
        $product->save();
        */
        return $product;
    }
    

/*
    public function user() {
        return $this->belongsTo('App\User');
    }
*/    
}