<?php

namespace App\Http\Controllers;

use App\Models\CateGory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CateGoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $Login = Auth::guard('admins')->user();

            if (!$Login) {
                return response()->json(['status' => 'Admin not authenticated'], 401);
            }

            CateGory::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'describe' => $request->describe,
                'action' => $request->action,
                'UrlPhoto' => $request->UrlPhoto,
            ]);

            return response()->json(['status' => 'Created New category successfully!'] , 200);

        } catch (\Exception $e) {
            return response()->json(['status' => 'An error occurred', 'message' => $e->getMessage()], 500);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CateGory  $cateGory
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        try {
            $Login = Auth::guard('admins')->user();

            if (!$Login) {
                return response()->json(['status' => 'Admin not authenticated'], 401);
            }

            return response()->json(['data' => CateGory::all()], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'An error occurred', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CateGory  $cateGory
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        try {
            $Login = Auth::guard('admins')->user();

            if (!$Login) {
                return response()->json(['status' => 'Admin not authenticated'], 401);
            }

            $data = CateGory::find($id);

            if (!$data) {
                return response()->json(['status' => 'CateGory not found!'], 404);
            }

            $data->update([
                'name' => $request->name ?? $data->name,
                'slug' => $request->slug ?? $data->slug,
                'describe' => $request->describe ?? $data->describe,
                'action' => $request->action ?? $data->action,
                'UrlPhoto' => $request->UrlPhoto ?? $data->UrlPhoto,
            ]);

            return response()->json(['status' => 'Updated CateGory successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'An error occurred', 'message' => $e->getMessage()], 500);
        }
    }


    public function destroy($id)
    {
        try {
            $data = CateGory::find($id);

            if (!$data) {
                return response()->json(['status' => 'CateGory not found!'], 404);
            }

            $data->delete();
            return response()->json(['status' => 'Deleted CateGory successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'An error occurred', 'message' => $e->getMessage()], 500);
        }
    }

    public function findCateGory(Request $request)
    {
        try {
            $Login = Auth::guard('admins')->user();

            if (!$Login) {
                return response()->json(['status' => 'Admin not authenticated'], 401);
            }

            $data = $request->value ?? null;

            if ($data) {
                $dataValue = CateGory::where('name', 'like', '%' . $data . '%')->get();
            } else {
                $dataValue = CateGory::orderBy('created_at', 'desc')->take(5)->get();
            }

            return response()->json(['data' => $dataValue], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'An error occurred', 'message' => $e->getMessage()], 500);
        }
    }
}
