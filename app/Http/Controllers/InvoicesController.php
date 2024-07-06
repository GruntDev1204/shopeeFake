<?php

namespace App\Http\Controllers;

use App\Models\Carts;
use App\Models\Invoices;
use App\Models\Product;
use App\Models\Transports;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InvoicesController extends Controller
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
    public function create($codeCustomer ,$codeTransport)
    {
        try {

            $dataCart = Carts::join('products', 'products.codeProduct', '=', 'carts.codeProduct')
            ->select('products.name', 'products.price', 'products.promotionalPrice', 'products.UrlPhoto', 'products.Rate', 'carts.*')
            ->where('carts.codeCustomer', $codeCustomer)
            ->where('products.action', true)
            ->get();

            $dataTransport = Transports::where('UnitCode', $codeTransport)
            ->select('price', 'PerCentPrice', 'Name')
            ->first();

            if ($dataCart->isEmpty()) {
                return response()->json(['status' => 'Data not found'], 404);
            }

            // Kiểm tra sự tồn tại của dữ liệu vận chuyển
            if (!$dataTransport) {
                return response()->json(['status' => 'No suitable transport unit found'], 404);
            }


            $totalPrice = 0;
            foreach ($dataCart as $item) {
                $price = $item->price - $item->promotionalPrice;
                $totalPrice += $price;
            }
            $transportPrice = $dataTransport->price * $dataTransport->PerCentPrice;

            $PriceInvoices = $totalPrice + $transportPrice;
            $RelityPriceInvoice = $totalPrice + $transportPrice;

            $invoice =  Invoices::create([

                'codeInvoices' =>Str::uuid(),
                'totalPay' => $PriceInvoices,
                'relityPay' => $RelityPriceInvoice,

            ]);

            // Cập nhật tất cả bản ghi trong $dataCart với codeInvoice mới
            foreach ($dataCart as $item) {
                $cartItem = Carts::find($item->id);
                if ($cartItem) {
                    $cartItem->update([
                        'codeInvoice' => $invoice->codeInvoices,
                    ]);
                }
                
            }
            return response()->json([
                'status' => 'Invoice created updated successfully!',
            ], 200);

        } catch (\Exception  $e) {
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
     * @param  \App\Models\Invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function show(Invoices $invoices)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoices $invoices)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoices $invoices)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoices $invoices)
    {
        //
    }
}
