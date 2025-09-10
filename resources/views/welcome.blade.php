@extends('template.master')

@section('dashboard-active', 'active')

@section('content')
<div class="container-fluid py-0 px-0">

    <h1 class="h3 mb-4"><strong>Dashboard</strong></h1>

    {{-- Statistik dalam card --}}
    <div class="row" id="dashboard-cards">
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm p-3 rounded-3">
                <h6 class="text-muted">Tiket Terbuka</h6>
                <h3 id="tiket_terbuka">0</h3>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm p-3 rounded-3">
                <h6 class="text-muted">Invoice Belum Lunas</h6>
                <h3 id="invoice_belum_lunas">0</h3>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm p-3 rounded-3">
                <h6 class="text-muted">Tenant Baru Bulan Ini</h6>
                <h3 id="tenant_baru_bulan_ini">0</h3>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm p-3 rounded-3">
                <h6 class="text-muted">Prospect Baru Bulan Ini</h6>
                <h3 id="prospect_baru_bulan_ini">0</h3>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm p-3 rounded-3">
                <h6 class="text-muted">Produk Terlaris</h6>
                <h3 id="produk_terlaris">-</h3>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm p-3 rounded-3">
                <h6 class="text-muted">Jumlah Tenant</h6>
                <h3 id="jumlah_tenant">0</h3>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm p-3 rounded-3">
                <h6 class="text-muted">Jumlah Prospect</h6>
                <h3 id="jumlah_prospect">0</h3>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm p-3 rounded-3">
                <h6 class="text-muted">Penjualan Bulan Ini</h6>
                <h3 id="penjualan_bulan_ini">Rp 0</h3>
            </div>
        </div>
    </div>

    {{-- Section Chart --}}
    <div class="row mt-4">
        <div class="col-md-6 mb-4">
            <div class="card p-3 shadow-sm">
                <h6>Invoice Status</h6>
                <canvas id="invoiceStatusChart"></canvas>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card p-3 shadow-sm">
                <h6>Tiket Status</h6>
                <canvas id="tiketStatusChart"></canvas>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card p-3 shadow-sm">
                <h6>Invoice Paid per Bulan</h6>
                <canvas id="invoicePerMonthChart"></canvas>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card p-3 shadow-sm">
                <h6>Penjualan per Bulan</h6>
                <canvas id="penjualanPerMonthChart"></canvas>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card p-3 shadow-sm">
                <h6>Pertumbuhan Tenant</h6>
                <canvas id="tenantGrowthChart"></canvas>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card p-3 shadow-sm">
                <h6>Pertumbuhan Prospect</h6>
                <canvas id="prospectGrowthChart"></canvas>
            </div>
        </div>

        <div class="col-md-12 mb-4">
            <div class="card p-3 shadow-sm">
                <h6>Produk Terlaris</h6>
                <canvas id="produkTerlarisChart"></canvas>
            </div>
        </div>
    </div>

</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    async function loadDashboardData() {
        try {
            let response = await fetch("{{ route('dashboard.data') }}");
            let result = await response.json();

            // === isi card ===
            const stat = result.statistik;
            document.getElementById("tiket_terbuka").innerText = stat.tiket_terbuka;
            document.getElementById("invoice_belum_lunas").innerText = "Rp " + new Intl.NumberFormat().format(stat.invoice_belum_lunas);
            document.getElementById("tenant_baru_bulan_ini").innerText = stat.tenant_baru_bulan_ini;
            document.getElementById("prospect_baru_bulan_ini").innerText = stat.prospect_baru_bulan_ini;
            document.getElementById("produk_terlaris").innerText = stat.produk_terlaris ?? '-';
            document.getElementById("jumlah_tenant").innerText = stat.jumlah_tenant;
            document.getElementById("jumlah_prospect").innerText = stat.jumlah_prospect;
            document.getElementById("penjualan_bulan_ini").innerText = "Rp " + new Intl.NumberFormat().format(stat.penjualan_bulan_ini);

            // === chart ===
            const charts = result.charts;

            // Invoice Status (Pie)
            new Chart(document.getElementById('invoiceStatusChart'), {
                type: 'pie',
                data: {
                    labels: Object.keys(charts.invoiceStatus),
                    datasets: [{
                        data: Object.values(charts.invoiceStatus),
                        backgroundColor: ['#28a745','#dc3545']
                    }]
                }
            });

            // Tiket Status (Pie)
            new Chart(document.getElementById('tiketStatusChart'), {
                type: 'pie',
                data: {
                    labels: Object.keys(charts.tiketStatus),
                    datasets: [{
                        data: Object.values(charts.tiketStatus),
                        backgroundColor: ['#007bff','#ffc107','#6c757d']
                    }]
                }
            });

            // Invoice Paid per Bulan (Line)
            new Chart(document.getElementById('invoicePerMonthChart'), {
                type: 'line',
                data: {
                    labels: Object.keys(charts.invoicePerMonth),
                    datasets: [{
                        label: 'Invoice Paid',
                        data: Object.values(charts.invoicePerMonth),
                        borderColor: '#007bff',
                        fill: false
                    }]
                }
            });

            // Penjualan per Bulan (Bar)
            new Chart(document.getElementById('penjualanPerMonthChart'), {
                type: 'bar',
                data: {
                    labels: Object.keys(charts.penjualanPerMonth),
                    datasets: [{
                        label: 'Total Penjualan',
                        data: Object.values(charts.penjualanPerMonth),
                        backgroundColor: '#28a745'
                    }]
                }
            });

            // Tenant Growth (Line)
            new Chart(document.getElementById('tenantGrowthChart'), {
                type: 'line',
                data: {
                    labels: Object.keys(charts.tenantGrowth),
                    datasets: [{
                        label: 'Tenant Baru',
                        data: Object.values(charts.tenantGrowth),
                        borderColor: '#17a2b8',
                        fill: false
                    }]
                }
            });

            // Prospect Growth (Line)
            new Chart(document.getElementById('prospectGrowthChart'), {
                type: 'line',
                data: {
                    labels: Object.keys(charts.prospectGrowth),
                    datasets: [{
                        label: 'Prospect Baru',
                        data: Object.values(charts.prospectGrowth),
                        borderColor: '#ffc107',
                        fill: false
                    }]
                }
            });

            // Produk Terlaris (Bar)
            new Chart(document.getElementById('produkTerlarisChart'), {
                type: 'bar',
                data: {
                    labels: charts.produkTerlaris.map(p => p.product),
                    datasets: [{
                        label: 'Jumlah Terjual',
                        data: charts.produkTerlaris.map(p => p.total),
                        backgroundColor: '#6f42c1'
                    }]
                }
            });

        } catch (error) {
            console.error("Gagal load dashboard:", error);
        }
    }

    document.addEventListener("DOMContentLoaded", loadDashboardData);
</script>
@endsection
