<?php

namespace App\Http\Controllers;

use App\Models\Carts;
use App\Models\Invoices;
use App\Models\Transports;
use Illuminate\Http\Request;

class CartsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($codeProduct ,$codeCustomer , Request $request)
    {
        try {

            Carts::create([

               'codeProduct' => $codeProduct,

               'codeCustomer' => $codeCustomer,

               'QuanitityOfProduct' => $request->QuanitityOfProduct,

               'Price' => $request->Price,

            ]);

            return response()->json([
                'status' => 'create Cart sucessFully!'
            ], 200);


        } catch (\Exception $e) {
            return response()->json(['status' => 'An error occurred', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Carts  $carts
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        try {
            $codeCustomer = 'đâsdasdasdad';

            // Lấy dữ liệu giỏ hàng của khách hàng
            $dataCart = Carts::where('codeCustomer', $codeCustomer)->get();

            // Kiểm tra nếu giỏ hàng trống
            if ($dataCart->isEmpty()) {
                return response()->json([
                    'status' => 'No cart items found for this customer!'
                ], 404);
            }

            // Trả về dữ liệu giỏ hàng
            return response()->json([
                'dataCart' => $dataCart
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => 'An error occurred', 'message' => $e->getMessage()], 500);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Carts  $carts
     * @return \Illuminate\Http\Response
     */
    public function edit(Carts $carts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Carts  $carts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Carts $carts)
    {
        //
    }



    public function updateNumber($id, Request $request)
    {
        try {
            $cart = Carts::find($id);

            if (!$cart) {
                return response()->json([
                    'status' => "Cart maybe haven't been created or not found!"
                ], 404);
            }

            // Cập nhật số lượng sản phẩm trong giỏ hàng
            $cart->QuanitityOfProduct += $request->QuanitityOfProduct;
            $cart->save();

            // Lấy mã hóa đơn từ giỏ hàng đã cập nhật
            $codeInvoice = $cart->codeInvoice;

            if ($codeInvoice) {
                // Lấy tất cả các mặt hàng giỏ hàng liên quan đến hóa đơn này
                $cartItems = Carts::join('products', 'products.codeProduct', '=', 'carts.codeProduct')
                    ->select('products.price', 'products.promotionalPrice', 'carts.QuanitityOfProduct')
                    ->where('carts.codeInvoice', $codeInvoice)
                    ->get();

                // Lấy thông tin vận chuyển liên quan đến hóa đơn này
                $invoice = Invoices::where('codeInvoices', $codeInvoice)->first();
                $dataTransport = Transports::where('UnitCode', $invoice->UnitCode)
                    ->select('price', 'PerCentPrice')
                    ->first();

                // Tính toán lại tổng số tiền và thực tế phải trả
                $totalPrice = 0;
                foreach ($cartItems as $item) {
                    $price = ($item->price - $item->promotionalPrice) * $item->QuanitityOfProduct;
                    $totalPrice += $price;
                }

                $transportPrice = $dataTransport->price * $dataTransport->PerCentPrice;

                $PriceInvoices = $totalPrice + $transportPrice;
                $RelityPriceInvoice = $totalPrice + $transportPrice;

                // Cập nhật hóa đơn với các giá trị mới
                $invoice->update([
                    'totalPay' => $PriceInvoices,
                    'relityPay' => $RelityPriceInvoice,
                ]);
            }

            return response()->json([
                'status' => "Update cart successfully!"
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => 'An error occurred', 'message' => $e->getMessage()], 500);
        }
    }


    public function IsConFirmCart($id){

        try {
            $Cart = Carts::find($id);

            if(!$Cart){
                return response()->json([
                    'status' => "Cart maybe haven't been created or not found!"
                ], 404);
            }

            $Cart->status = !$Cart->status;
            $Cart->save();  // Don't forget to save the changes

            return response()->json([
                'status' => "Confirm cart  successfully!"
            ], 200);


        } catch (\Exception $e) {
            return response()->json(['status' => 'An error occurred', 'message' => $e->getMessage()], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Carts  $carts
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $Cart = Carts::find($id);

            if(!$Cart){
                return response()->json([
                    'status' => "Cart maybe haven't been created or not found!"
                ], 404);
            }

            $Cart->delete();

            return response()->json([
                'status' => "Confirm cart  successfully!"
            ], 200);


        } catch (\Exception $e) {
            return response()->json(['status' => 'An error occurred', 'message' => $e->getMessage()], 500);
        }
    }



}
