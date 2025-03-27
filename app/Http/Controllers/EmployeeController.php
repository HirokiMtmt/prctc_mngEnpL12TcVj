<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    //社員情報一覧表示
    public function index()
    {
        //ビュー"employees.index"を返す
        return view('employees.index');
    }
}
