<?php

use App\Http\Controllers\CateGoryController;
use App\Http\Controllers\ProductController;
use App\Models\Transports;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*try {

} catch (error) {
    console.error('Error:', error.message);

}
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::get('/{code}', [CateGoryController::class, 'destroy']);


// Route::get('/test/{code}', function($codeTransport){
//     $dataTransport = Transports::where('UnitCode', $codeTransport)
//         ->select('price', 'PerCentPrice', 'Name')
//         ->first();
//         return response()->json([
//             'data' =>$dataTransport
//         ]);
// });

