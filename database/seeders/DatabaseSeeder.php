<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use App\Models\User;
use App\Models\Product;
use App\Models\ProfitLoss;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->dummyRole();

        User::insert([
            [
                'name' => 'Andik Kurniawan',
                'email' => 'andikkurniawan789456@gmail.com',
                'password' => bcrypt('qc_789456'),
                'role_id' => 1,
                'is_active' => 1,
                'organization' => 'PT Optima Teknologi Industri',
                'whatsapp' => '6285733465399',
                'app_key' => Str::random(8),
            ],
            [
                'name' => 'Rizky Pratama',
                'email' => 'admin@example.com',
                'password' => bcrypt('admin123'),
                'role_id' => 2,
                'is_active' => 1,
                'organization' => 'PT Optima Teknologi Industri',
                'whatsapp' => '628123456789',
                'app_key' => Str::random(8),
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti@example.com',
                'password' => bcrypt('tenant123'),
                'role_id' => 3,
                'is_active' => 1,
                'organization' => 'CV Demo Sejahtera',
                'whatsapp' => '628987654321',
                'app_key' => Str::random(8),
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'password' => bcrypt('tenant456'),
                'role_id' => 3,
                'is_active' => 1,
                'organization' => 'CV Sejahtera Jaya',
                'whatsapp' => '6281122334455',
                'app_key' => Str::random(8),
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi@example.com',
                'password' => bcrypt('tenant789'),
                'role_id' => 3,
                'is_active' => 1,
                'organization' => 'CV Maju Bersama',
                'whatsapp' => '6289988776655',
                'app_key' => Str::random(8),
            ],
        ]);

        $this->dummyProduct();
        $this->dummyProfitLoss();
    }

    public static function dummyRole()
    {
        Role::insert([
            ['name' => 'Director'],
            ['name' => 'Admin'],
            ['name' => 'Tenant'],
            ['name' => 'Prospect'],
        ]);
        $akses = Role::semua_akses();
        $updateData = [];
        foreach ($akses as $a) {
            $updateData[$a['id']] = 1;
        }
        Role::where('id', 1)->update($updateData);
    }

    public static function dummyProfitLoss()
    {
        $startDate = Carbon::create(2025, 1, 1);
        $endDate   = Carbon::now();

        $data = [];

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $revenue = rand(1000000, 5000000); // 1jt - 5jt
            $expense = rand(500000, 4000000);  // 500rb - 4jt
            $profitloss = $revenue - $expense;

            $data[] = [
                'user_id'    => rand(3, 5),
                'date'       => $date->format('Y-m-d'),
                'revenue'    => $revenue,
                'expense'    => $expense,
                'profitloss' => $profitloss,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        ProfitLoss::insert($data);
    }

    public static function dummyProduct()
    {
        Product::insert([
            [
                'name' => 'Dashboard Laba',
                'description' => 'Visualisasikan kinerja keuangan perusahaan Anda dengan wawasan yang jelas tentang pendapatan, biaya, dan profitabilitas secara keseluruhan.'
            ],
            [
                'name' => 'Dashboard Penjualan Multi-Outlet',
                'description' => 'Pantau dan bandingkan kinerja penjualan di berbagai outlet untuk mengidentifikasi lokasi dengan performa terbaik dan mengoptimalkan strategi.'
            ],
            [
                'name' => 'Dashboard Penjualan Regional',
                'description' => 'Analisis distribusi penjualan berdasarkan wilayah untuk memahami tren pasar, permintaan pelanggan, dan peluang pertumbuhan regional.'
            ],
            [
                'name' => 'Dashboard Hutang & Piutang',
                'description' => 'Pantau hutang dan piutang secara real-time untuk mengelola arus kas secara efisien dan menjaga catatan keuangan tetap akurat.'
            ],
        ]);

        foreach (Product::all() as $product) {
            $columnName = "access_to_product_{$product->id}";
            if (!Schema::hasColumn('users', $columnName)) {
                Schema::table('users', function (Blueprint $table) use ($columnName) {
                    $table->boolean($columnName)->default(false);
                });
            }
        }
    }
}
