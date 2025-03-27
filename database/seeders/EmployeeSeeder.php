<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // サンプル社員データ
        $employees = [
            [
                'name' => '山田太郎',
                'email' => 'yamada@example.com',
                'department' => '営業部',
                'position' => '部長',
                'hired_date' => '2010-04-01',
                'address' => '東京都港区芝浦1-1-1',
                'phone' => '090-1234-5678'
            ],
            [
                'name' => '佐藤花子',
                'email' => 'sato@example.com',
                'department' => '人事部',
                'position' => '主任',
                'hired_date' => '2015-04-01',
                'address' => '東京都品川区大崎2-2-2',
                'phone' => '090-2345-6789'
            ],
            [
                'name' => '鈴木一郎',
                'email' => 'suzuki@example.com',
                'department' => '開発部',
                'position' => 'リーダー',
                'hired_date' => '2018-10-01',
                'address' => '東京都渋谷区恵比寿3-3-3',
                'phone' => '090-3456-7890'
            ],
            [
                'name' => '田中幸子',
                'email' => 'tanaka@example.com',
                'department' => '経理部',
                'position' => '係長',
                'hired_date' => '2012-07-01',
                'address' => '神奈川県横浜市中区4-4-4',
                'phone' => '090-4567-8901'
            ],
            [
                'name' => '伊藤健太',
                'email' => 'ito@example.com',
                'department' => '開発部',
                'position' => 'エンジニア',
                'hired_date' => '2020-04-01',
                'address' => '埼玉県さいたま市5-5-5',
                'phone' => '090-5678-9012'
            ],
        ];

        foreach ($employees as $employeeData) {
            Employee::create($employeeData);
        }
    }
} 