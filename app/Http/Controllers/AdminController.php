<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminController extends Controller
{

    public function index()
    {
        //
    }



    public function Create(Request $request)
    {
        try {
            $Login = Auth::guard('admins')->user();

            if (!$Login) {
                return response()->json(['status' => 'User not authenticated'], 401);
            }

            if ($Login->adMinRule == 0) {
                Admin::create([
                    'key' => Str::uuid(),
                    'userName' => $request->userName,
                    'passWord' => bcrypt($request->passWord),
                    'ContractInfomation' => $request->ContractInfomation,
                    'avatar' => $request->avatar,
                    'adMinRule' => 2,
                ]);

                return response()->json([
                    'status' => 'create Admin Data successfully!',
                    'userName' => $request->userName,
                    'ContractInfomation' => $request->ContractInfomation,
                ], 200);
            } else {
                return response()->json([
                    'status' => 'your Admin Rule is not enough to create another Admin!',
                ], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'An error occurred', 'message' => $e->getMessage()], 500);
        }
    }



    public function ShowAllAdmin()
    {
        try {
            $Login = Auth::guard('admins')->user();

            if (!$Login) {
                return response()->json(['status' => 'User not authenticated'], 401);
            }

            if ($Login->adMinRule == 0) {
                return response()->json(['dataAllAdmins' => Admin::all()], 200);
            } else {
                return response()->json([
                    'status' => 'your Admin Rule is not enough to watch all Admins!',
                ], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'An error occurred', 'message' => $e->getMessage()], 500);
        }
    }



    public function editRule($key, Request $request)
    {
        try {
            $Login = Auth::guard('admins')->user();

            if (!$Login) {
                return response()->json(['status' => 'User not authenticated'], 401);
            }

            if ($Login->adMinRule == 0) {
                $data = Admin::find($key);
                if (!$data) {
                    return response()->json(['status' => 'Admin not found'], 404);
                }

                $data->adMinRule = $request->adMinRule;
                $data->save();

                return response()->json(['status' => 'Edit Admin Rule Successfully!'], 200);
            } else {
                return response()->json([
                    'status' => 'your Admin Rule is not enough to edit any Admins!',
                ], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'An error occurred', 'message' => $e->getMessage()], 500);
        }
    }



    public function update(Request $request, Admin $admin)
    {
        //
    }


    public function destroy($key)
    {
        try {
            $Login = Auth::guard('admins')->user();

            if (!$Login) {
                return response()->json(['status' => 'User not authenticated'], 401);
            }

            if ($Login->adMinRule == 0) {
                $data = Admin::find($key);
                if (!$data) {
                    return response()->json(['status' => 'Admin not found'], 404);
                }

                $data->delete();
                return response()->json(['status' => 'Destroy Admin Data successfully!'], 200);
            } else {
                return response()->json([
                    'status' => 'your Admin Rule is not enough to delete any Admins!',
                ], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'An error occurred', 'message' => $e->getMessage()], 500);
        }
    }
}
