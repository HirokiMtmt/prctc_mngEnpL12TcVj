<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    //社員情報一覧表示
    public function index()
    {
        // ビューに渡す社員データ
        $employees = [
            [
                'id' => 1,
                'name' => '山田太郎',
                'email' => 'yamada@example.com',
                'department' => '営業部',
                'position' => '部長',
                'hired_date' => '2010-04-01'
            ],
            [
                'id' => 2,
                'name' => '佐藤花子',
                'email' => 'sato@example.com',
                'department' => '人事部',
                'position' => '主任',
                'hired_date' => '2015-04-01'
            ],
            [
                'id' => 3,
                'name' => '鈴木一郎',
                'email' => 'suzuki@example.com',
                'department' => '開発部',
                'position' => 'リーダー',
                'hired_date' => '2018-10-01'
            ]
        ];
        
        // JSON形式でデータを返す方法（APIの代わり）
        if (request()->wantsJson()) {
            return response()->json($employees);
        }
        
        // 通常のビュー表示
        return view('employees.index', compact('employees'));
    }
}
