<?php

use Illuminate\Support\Facades\Route;
//社員情報操作用のコントローラー
use App\Http\Controllers\EmployeeController;

Route::get('/', function () {
    return view('welcome');
});

//社員情報一覧ページへのルーティング
Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');



