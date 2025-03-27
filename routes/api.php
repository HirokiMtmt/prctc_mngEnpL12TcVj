<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\EmployeeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// テスト用の簡易APIエンドポイント
Route::get('test', function () {
    return response()->json(['message' => 'API is working!']);
});

// CSVインポート用のエンドポイント
Route::post('employees/import', [EmployeeController::class, 'import']);

// 社員情報のAPIルート - コントローラーを使用
Route::apiResource('employees', EmployeeController::class);

// 以下の簡易版と個別ルートは削除（apiResourceに統合）
// 社員情報のAPI - 簡易版（クロージャベース）
// Route::get('employees', function () { ... });

// 社員情報のAPI - フルパスで指定
// Route::post('/employees', [App\Http\Controllers\API\EmployeeController::class, 'store']);
// Route::get('/employees/{employee}', [App\Http\Controllers\API\EmployeeController::class, 'show']);
// Route::put('/employees/{employee}', [App\Http\Controllers\API\EmployeeController::class, 'update']);
// Route::delete('/employees/{employee}', [App\Http\Controllers\API\EmployeeController::class, 'destroy']); 