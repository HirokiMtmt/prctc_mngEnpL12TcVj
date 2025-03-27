<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * 社員一覧を取得
     */
    public function index()
    {
        try {
            $employees = Employee::all();
            
            // データが空の場合はダミーデータを返す（デバッグ用）
            if ($employees->isEmpty()) {
                return response()->json([
                    [
                        'id' => 1,
                        'name' => '山田太郎（ダミー）',
                        'email' => 'dummy1@example.com',
                        'department' => '営業部',
                        'position' => '部長',
                        'hired_date' => '2010-04-01',
                        'address' => '東京都港区',
                        'phone' => '090-1234-5678',
                        'created_at' => now(),
                        'updated_at' => now()
                    ],
                    [
                        'id' => 2,
                        'name' => '佐藤花子（ダミー）',
                        'email' => 'dummy2@example.com',
                        'department' => '人事部',
                        'position' => '主任',
                        'hired_date' => '2015-04-01',
                        'address' => '東京都品川区',
                        'phone' => '090-2345-6789',
                        'created_at' => now(),
                        'updated_at' => now()
                    ]
                ]);
            }
            
            return response()->json($employees);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * 新しい社員を登録
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees',
            'department' => 'required|string|max:100',
            'position' => 'required|string|max:100',
            'hired_date' => 'nullable|date',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
        ]);

        $employee = Employee::create($validated);
        
        return response()->json($employee, 201);
    }

    /**
     * 指定した社員情報を取得
     */
    public function show(Employee $employee)
    {
        return response()->json($employee);
    }

    /**
     * 指定した社員情報を更新
     */
    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => [
                'sometimes', 
                'required', 
                'email', 
                Rule::unique('employees')->ignore($employee->id)
            ],
            'department' => 'sometimes|required|string|max:100',
            'position' => 'sometimes|required|string|max:100',
            'hired_date' => 'nullable|date',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
        ]);

        $employee->update($validated);
        
        return response()->json($employee);
    }

    /**
     * 指定した社員を削除
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        
        return response()->json(null, 204);
    }
    
    /**
     * CSVからの一括インポート
     */
    public function import(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'employees' => 'required|array',
                'employees.*.name' => 'required|string|max:255',
                'employees.*.email' => 'required|email',
                'employees.*.department' => 'required|string|max:100',
                'employees.*.position' => 'required|string|max:100',
                'employees.*.hired_date' => 'nullable|date',
                'employees.*.address' => 'nullable|string',
                'employees.*.phone' => 'nullable|string|max:20',
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'message' => 'データ形式が不正です',
                    'errors' => $validator->errors()
                ], 422);
            }
            
            $employees = $request->employees;
            $imported = 0;
            $errors = [];
            
            foreach ($employees as $index => $employeeData) {
                try {
                    // メールアドレスの重複チェック
                    $existingEmployee = Employee::where('email', $employeeData['email'])->first();
                    
                    if ($existingEmployee) {
                        // 既存データの更新
                        $existingEmployee->update($employeeData);
                        $imported++;
                    } else {
                        // 新規データの作成
                        Employee::create($employeeData);
                        $imported++;
                    }
                } catch (\Exception $e) {
                    $errors[] = [
                        'row' => $index + 1,
                        'message' => $e->getMessage(),
                        'data' => $employeeData
                    ];
                }
            }
            
            $result = [
                'success' => true,
                'imported' => $imported,
                'total' => count($employees)
            ];
            
            if (count($errors) > 0) {
                $result['errors'] = $errors;
                $result['error_count'] = count($errors);
            }
            
            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'インポート処理に失敗しました: ' . $e->getMessage()
            ], 500);
        }
    }
} 