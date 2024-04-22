<?php

namespace App\Http\Controllers;

//使用するモデルを記載
use App\Models\Product;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //商品一覧画面
    //CRUD→Read(読み取り)
    //メゾット→index=データ一覧表示
    public function index(Request $request)
    {
        //Productモデルに基づいて操作要求(クリエ)を初期化
        //この行の後にクエリを逐次構築
        $query = Product::query();

        if($search = $request->search){
            $query->where('product_name','LIKE',"%{$search}%");
        }

        if($search = $request->search){
            $query->where('company_name',  'LIKE', "%{$search}%");
        }
    
        
        $products = $query->paginate(10);
    
        // 商品一覧ビューを表示し、取得した商品情報をビューに渡す
        return view('products.index', ['products' => $products]);
       
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    //Create(作成)
    //create=新規作成用フォーム表示
    public function create()
    {
        //商品新規登録画面
        //会社情報必要
        $companies = Company::all();
                
        return view('products.create', compact('companies'));
        
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //Create(作成)
     //store=データ新規保存
     public function store(Request $request) // フォームから送られたデータを　$requestに代入して引数として渡している
     {
         // リクエストされた情報を確認して、必要な情報が全て揃っているかチェックします。
         // ->validate()メソッドは送信されたリクエストデータが
         // 特定の条件を満たしていることを確認します。
         $request->validate([
             'product_name' => 'required', //requiredは必須という意味です
             'company_id' => 'required',
             'price' => 'required',
             'stock' => 'required',
             'comment' => 'nullable', //'nullable'はそのフィールドが未入力でもOKという意味です
             'img_path' => 'nullable|image|max:2048',
         ]);
         // '|'はパイプと呼ばれる記号で、バリデーションルールを複数指定するときに使います
         // 'image'はそのフィールドが画像ファイルであることを指定するルールです
         // max:2048'は最大2048KB（2メガバイト）までという意味です
         
         // フォームが一部空欄のまま送信ボタンを押しても、フォームの画面にリダイレクトされ
         // フォームの値が未入力である旨の警告メッセージが表示されます
 
 
         // 新しく商品を作ります。そのための情報はリクエストから取得します。
         $product = new Product([
             'product_name' => $request->get('product_name'),
             'company_id' => $request->get('company_id'),
             'price' => $request->get('price'),
             'stock' => $request->get('stock'),
             'comment' => $request->get('comment'),
         ]);
         //new Product([]) によって新しい「Product」（レコード）を作成しています。
         //new を使うことで新しいインスタンスを作成することができます
 
 
 
         // リクエストに画像が含まれている場合、その画像を保存します。
         if($request->hasFile('img_path')){ 
             $filename = $request->img_path->getClientOriginalName();
             $filePath = $request->img_path->storeAs('products', $filename, 'public');
             $product->img_path = '/storage/' . $filePath;
         }
         // $request->hasFile('img_path')は、ブラウザにアップロードされたファイルが存在しているかを確認
         // getClientOriginalName()はアップロードしたファイル名を取得するメソッドです。
        // storeAs('products', $filename, 'public')は
        //  アップロードされたファイルを特定の場所に特定の名前で保存するためのメソッドです
        //　今回はstorage/app/publicにproducts" ディレクトリが作られ保存されます
        //'products'：これはファイルを保存するディレクトリ（フォルダ）の名前を示しています。
        // この場合は 'products' という名前のディレクトリにファイルが保存されます。
     //$filename：これは保存するファイルの名前を示しています。
     // getClientOriginalName() メソッドで取得したオリジナルのファイル名がここに入ります。
     // 'public' ファイルのアクセス権限を示しています。'public' は公開設定で、誰でもこのファイルにアクセスすることができるようになります。
 
         // 作成したデータベースに新しいレコードとして保存します。
         $product->save();
 
         // 全ての処理が終わったら、商品一覧画面に戻ります。
         return redirect('products');
     }
 
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     //Read(読み取り)
     //show=データ個別表示
    public function show(Product $product)
    {
        //商品情報詳細画面
        //指定されたIDでデータベースから検索する

        return view('products.show', ['product' => $product]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //Update(更新)
    //edit=データ編集用フォーム表示
    public function edit(Product $product)
    {
        //商品情報編集画面

        $companies = Company::find($product->company_id);
        //→会社情報が必要

        return view('products.edit', compact('product', 'companies'));

    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //Update(更新)
    //update=データ更新
    public function update(Request $request, Product $product)
    {
        //更新ボタン
        DB::beginTransaction();

        try {
            $request->validate([
                'product_name' => 'required',
                'price' => 'required',
                'stock' => 'required',
            ]);
    
            //商品情報を更新
            //モデルの値を書き換える
            $product->product_name = $request->product_name;
            $product->price = $request->price;
            $product->stock = $request->stock;
    
            $product->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully');
        //→ビューにメッセージを送る(代入：success)
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //Delete(削除)
    //destroy=データ削除
    public function destroy(Product $product)
    {
        //削除ボタン
        DB:beginTransaction();

        try {
            $product->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }

        return redirect('/products');
        
    }
}