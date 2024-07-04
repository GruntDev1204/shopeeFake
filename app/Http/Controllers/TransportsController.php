<?php

namespace App\Http\Controllers;

use App\Models\Transports;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class TransportsController extends Controller
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
    public function store(Request $request)
    {
        try {

            $Login = Auth::guard('admins')->user();

            if (!$Login) {

                return response()->json(['status' => 'Admin not authenticated'], 401);

            }else{

                Transports::create([
                    'UnitCode' => Str::uuid(),
                    'price' => $request->price,
                    'PerCentPrice' => $request->PerCentPrice,
                    'deliveryTime' => $request->deliveryTime,
                    'AvatarPhoto' => $request->AvatarPhoto,
                ]);

                return response()->json([
                    'status' => 'create Transport sucessfully'
                ],200);
            }

        } catch (\Exception $e) {
            return response()->json(['status' => 'An error occurred', 'message' => $e->getMessage()], 500);
        }
    }




    public function show()
    {
        try {
            $Login = Auth::guard('admins')->user();

            if (!$Login) {

                return response()->json(['status' => 'Admin not authenticated'], 401);

            }else{

                return response()->json([
                    'dataTransport' => Transports::all()
                ], 200);
            }


        } catch (\Exception $e) {
            return response()->json(['status' => 'An error occurred', 'message' => $e->getMessage()], 500);
        }
    }


    public function rateTransport($id, Request $request)
    {
        try {
            $data = Transports::find($id);

            if (!$data) {
                return response()->json(['status' => 'Transport not found'], 404);
            }

            $newRating = $request->rate;
            $data->total_ratings += $newRating;
            $data->rating_count += 1;
            $data->Rate = $data->total_ratings / $data->rating_count;

            $data->save();

            return response()->json([
                'status' => 'Rating updated successfully',
                'average_rating' => $data->Rate
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'An error occurred', 'message' => $e->getMessage()], 500);
        }
    }



    public function update($id, Request $request)
    {
        try {
            $Login = Auth::guard('admins')->user();

            if (!$Login) {

                return response()->json(['status' => 'Admin not authenticated'], 401);

            }else{
                $data = Transports::find($id);

                if (!$data) {
                    return response()->json(['status' => 'Transport not found'], 404);
                }

                $data->update([

                    'Name' => $request->Name ?? $data->Name,
                    'price' => $request->price ?? $data->price,
                    'PerCentPrice' => $request->PerCentPrice ?? $data->PerCentPrice,
                    'action' => $request->action ?? $data->action,
                    'deliveryTime' => $request->deliveryTime ?? $data->deliveryTime,
                    'AvatarPhoto' => $request->AvatarPhoto ?? $data->AvatarPhoto,

                ]);

                return response()->json([
                    'status' =>'update Info Transport successfully!'
                ], 200);
            }


        } catch (\Exception $e) {
            return response()->json(['status' => 'An error occurred', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transports  $transports
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $Login = Auth::guard('admins')->user();

            if (!$Login) {

                return response()->json(['status' => 'Admin not authenticated'], 401);

            }else{

                $data = Transports::find($id);
                $data->delete();

                return response()->json([
                    'status' => 'delete data WareHouse successffully!'
                ], 200);
            }


        } catch (\Exception $e) {
            return response()->json(['status' => 'An error occurred', 'message' => $e->getMessage()], 500);
        }
    }


    public function FindbyValue(Request $request)
    {
        try {
            $Login = Auth::guard('admins')->user();

            if (!$Login) {

                return response()->json(['status' => 'Admin not authenticated'], 401);

            }else{

                $data = $request->value ?? null;

                if ($data) {
                    $dataValue = Transports::where('Name', 'like', '%' . $data . '%')->get();
                } else {
                    $dataValue = Transports::orderBy('created_at', 'desc')->take(5)->get();
                }

                return response()->json([
                    'dataValue' => $dataValue
                ], 200);

            }


        } catch (\Exception $e) {
            return response()->json(['status' => 'An error occurred', 'message' => $e->getMessage()], 500);
        }
    }
}
