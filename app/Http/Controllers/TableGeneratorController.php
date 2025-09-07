<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TableGeneratorController extends Controller
{
    public function index()
    {
        return view('table_generator');
    }

    public function run(Request $request) {
        $migrationScript = trim($request->input('migration_script'));
        $seederScript = trim($request->input('seeder_script'));

        // Jika keduanya kosong
        if (empty($migrationScript) && empty($seederScript)) {
            return back()->with('error', '❌ Migration dan Seeder tidak boleh keduanya kosong!');
        }

        try {
            // Jalankan migration jika ada
            if (!empty($migrationScript)) {
                DB::statement($migrationScript);
            }

            // Jalankan seeder jika ada
            if (!empty($seederScript)) {
                DB::statement($seederScript);
            }

            return back()->with('success', '✅ Script berhasil dijalankan!');
        } catch (\Exception $e) {
            return back()->with('error', '❌ Error: ' . $e->getMessage());
        }
    }
}
