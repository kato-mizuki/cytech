<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company;
use App\Http\Requests\ProductCreateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator; //追加

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        //viewで渡されたrequestの内容を一度、変数に入れて扱う
        $input = $request->all();

        //$companies = Company::all();
        $companies = (new Company())->getAllCompanies();
        $model = new Product();
        //メソッドに引数を入れて呼び出す
        $products = $model->getList($input);

        return view('products.index', compact('products', 'companies'));
    }

    public function search(Request $request) {
    //dd($request);
    //dd($request->all());
        $input = $request->all();
        $companies = (new Company())->getAllCompanies();
        $model = new Product();
        $products = $model->getList($input);

        return response()->json([
             'products' => $products,
             'companies' => $companies,
             'price' => $request->minPrice,
         ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //$companies = Company::all();
        $companies = (new Company())->getAllCompanies();

        return view('products.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCreateRequest $request) {

        DB::beginTransaction();

        try{
          $product = new Product();

          $product->createNewProduct($request);

          DB::commit();

          return redirect()->route('list');
      
        } catch (\Exception $e) {
            //dd($e->getMessage()); 
            DB::rollback();
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product) {

        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product) {
        //$companies = Company::all();
        $companies = (new Company())->getAllCompanies();
        
        return view('products.edit', compact('product', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductCreateRequest $request, Product $product) {

        DB::beginTransaction();

        try{
           $data = [
              'id' => $product->id,
              'name' => $request->input('name'),
              'price' => $request->input('price'),
              'stock' => $request->input('stock'),
              'comment' => $request->input('comment'),
              'company_id' => $request->input('company_id'),
              'image_path' => $request->file('image_path')
            ];

           $product->updateProduct($data);

           DB::commit();

           return redirect()->route('list');
        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request) {
    // dd($request);
    $input = $request->all();
    // dd($input);
        DB::beginTransaction();

        try {
          $product = Product::find($input['product']); 
          $product->delete();

          DB::commit();
          return response()->json(['success' => true]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => '削除に失敗しました']);
        }
    }
}