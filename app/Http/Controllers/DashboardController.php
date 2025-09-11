<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function data()
    {
        // === Tiket terbuka ===
        $tiketTerbuka = Ticket::where('status', 'open')->count('id');

        // === Invoice belum lunas ===
        $invoiceBelumLunas = Invoice::where('is_paid', 0)->sum('amount');

        // === Tenant baru bulan ini ===
        $tenantBaruBulanIni = User::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('role_id', 3)
            ->whereNotIn('id', [3, 4, 5, 8]) // exclude dummy id
            ->count();


        // === Prospect baru bulan ini ===
        $prospectBaruBulanIni = User::where('role_id', 4)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // === Produk terlaris ===
        $produkTerlaris = Invoice::select('product_id', DB::raw('COUNT(*) as total'))
            ->where('is_paid', 1)
            ->groupBy('product_id')
            ->orderByDesc('total')
            ->with('product') // kalau ada relasi ke Product
            ->first();

        // === Jumlah tenant ===
        $jumlahTenant = User::where('role_id', 3)->count();

        // === Jumlah prospect ===
        $jumlahProspect = User::where('role_id', 4)->count();

        // === Penjualan bulan ini ===
        $penjualanBulanIni = Invoice::where('is_paid', 1)
            ->whereMonth('paid_at', now()->month)
            ->whereYear('paid_at', now()->year)
            ->sum('amount');

        // =========================
        // === CHART DATA ==========
        // =========================

        // Invoice Paid vs Unpaid (Pie)
        $invoiceStatus = [
            'paid'   => Invoice::where('is_paid', 1)->count(),
            'unpaid' => Invoice::where('is_paid', 0)->count(),
        ];

        // Invoice Paid per Bulan (Line)
        $invoicePerMonth = Invoice::selectRaw('MONTH(paid_at) as bulan, COUNT(*) as total')
            ->where('is_paid', 1)
            ->whereYear('paid_at', now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        // Penjualan per Bulan (Bar)
        $penjualanPerMonth = Invoice::selectRaw('MONTH(paid_at) as bulan, SUM(amount) as total')
            ->where('is_paid', 1)
            ->whereYear('paid_at', now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        // Tenant Growth per Bulan (Line)
        $tenantGrowth = User::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->where('role_id', 3)
            ->whereYear('created_at', now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        // Prospect Growth per Bulan (Line)
        $prospectGrowth = User::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->where('role_id', 4)
            ->whereYear('created_at', now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        // Produk Terlaris (Bar)
        $produkTerlarisChart = Invoice::select('product_id', DB::raw('COUNT(*) as total'))
            ->where('is_paid', 1)
            ->groupBy('product_id')
            ->orderByDesc('total')
            ->with('product')
            ->limit(5)
            ->get()
            ->map(function($row) {
                return [
                    'product' => $row->product ? $row->product->name : 'Unknown',
                    'total'   => $row->total,
                ];
            });

        // Tiket Status Distribution
        $tiketStatus = Ticket::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        return response()->json([
            'statistik' => [
                'tiket_terbuka'          => $tiketTerbuka,
                'invoice_belum_lunas'    => $invoiceBelumLunas,
                'tenant_baru_bulan_ini'  => $tenantBaruBulanIni,
                'prospect_baru_bulan_ini'=> $prospectBaruBulanIni,
                'produk_terlaris'        => $produkTerlaris ? $produkTerlaris->product->name : null,
                'jumlah_tenant'          => $jumlahTenant,
                'jumlah_prospect'        => $jumlahProspect,
                'penjualan_bulan_ini'    => $penjualanBulanIni,
            ],
            'charts' => [
                'invoiceStatus'      => $invoiceStatus,
                'invoicePerMonth'    => $invoicePerMonth,
                'penjualanPerMonth'  => $penjualanPerMonth,
                'tenantGrowth'       => $tenantGrowth,
                'prospectGrowth'     => $prospectGrowth,
                'produkTerlaris'     => $produkTerlarisChart,
                'tiketStatus'        => $tiketStatus,
            ]
        ]);
    }


}
