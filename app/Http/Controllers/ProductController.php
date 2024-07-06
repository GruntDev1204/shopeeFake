<?php

namespace App\Http\Controllers;

use App\Models\CateGory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    public function FindValueProduct(Request $request){
        try {

            $data = $request->value ?? null;

            if (!Empty($data)) {
                // Nếu $data không phải là null, tìm kiếm theo điều kiện 'like'
                $dataValue = CateGory::where('name', 'like', '%' . $data . '%')->get();
            } else {
                // Nếu $data là null, lấy 5 bản ghi mới nhất
                $dataValue = CateGory::orderBy('created_at', 'desc')->take(5)->get();
            }

            return response()->json([
                'dataValue' => $dataValue
            ] , 200);


        } catch (\Exception $e) {
            return response()->json(['status' => 'An error occurred', 'message' => $e->getMessage()], 500);
        }
    }



    public function store(Request $request)
    {
        try {

            $Login = Auth::guard('admins')->user();

            if (!$Login) {

                return response()->json(['status' => 'Admin not authenticated'], 401);

            }else{
                Product::create([

                   'cateGoryKey' => $request->cateGoryKey,
                   'name' => $request->name,
                   'price' => $request->price,
                   'promotionalPrice' => $request->promotionalPrice,
                   'describe' => $request->describe,
                   'DetailedDescribe' => $request->DetailedDescribe,
                   'codeProduct' => Str::uuid(),
                   'action' => $request->action,

                ]);

                return response()->json(['status' => 'create ProductSuccessfully'], 200);

            }

        }catch(\Exception $e){
            return response()->json(['status' => 'An error occurred', 'message' => $e->getMessage()], 500);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        try{

            $dataCateGory = CateGory::all()->map(function ($category) {
                return [
                    'id' => $category->id,
                    'cateGoryName' => $category->name,
                ];
            });

            $dataProduct = Product::join('cate_gories',  'cate_gories.id' , '='  , 'products.cateGoryKey')->select('cate_gories.name as categoryName' , 'products.*')->get();

            return response()->json([
                'dataProduct' =>$dataProduct ,
                'dataCateGory' => $dataCateGory
            ], 200);

        }catch(\Exception $e){
            return response()->json(['status' => 'An error occurred', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function findByCodeProduct($code)
    {
        try {
            // Tìm sản phẩm theo codeProduct
            $dataProduct = Product::where('codeProduct', $code)->first();

            // Khởi tạo biến $dataCateGory là null
            $dataCateGory = null;

            // Nếu tìm thấy sản phẩm, tìm tên của CateGory tương ứng
            if ($dataProduct) {
                $dataCateGory = CateGory::where('id', $dataProduct->cateGoryKey)->value('name');
            }

            return response()->json([
                'dataProduct' => $dataProduct ?? 'Product not found!',
                'dataCateGory' => $dataCateGory ?? 'CateGory not found!',
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => 'An error occurred', 'message' => $e->getMessage()], 500);
        }
    }

    public function RatingProduct ($id , $newRating ){
        try {

            $data = Product::find($id);

            $data->total_ratings += $newRating;
            $data->rating_count += 1;
            $data->Rate = $data->total_ratings / $data->rating_count;
            $data->save();


            return response()->json([
                'status' => 'Rating Product successfully',
                'average_rating' => $data->Rate
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => 'An error occurred', 'message' => $e->getMessage()], 500);
        }

    }
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = Product::find($id);
            $data->delete();


            return response()->json([
                'status' => 'deleted Product successfully',
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => 'An error occurred', 'message' => $e->getMessage()], 500);
        }

    }
}
