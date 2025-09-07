@extends('template.master')

@section('profitlosses-active', 'active')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Tambah Profit & Loss</strong></h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('profitlosses.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="user_id" class="form-label">Tenant</label>
                        <select name="user_id" id="user_id" class="form-select select2" required>
                            <option value="">-- Pilih Tenant --</option>
                            @foreach ($users as $id => $name)
                                <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="date" class="form-label">Tanggal</label>
                        <input type="date" name="date" id="date" class="form-control" value="{{ date('Y-m-d') }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="revenue" class="form-label">Revenue</label>
                        <input type="text" name="revenue" id="revenue" class="form-control currency-input"
                            value="{{ old('revenue') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="expense" class="form-label">Expense</label>
                        <input type="text" name="expense" id="expense" class="form-control currency-input"
                            value="{{ old('expense') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="profitloss" class="form-label">Profit / Loss</label>
                        <input type="text" id="profitloss" class="form-control" readonly>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <a href="{{ route('profitlosses.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Batal
                    </a>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const revenueInput = document.getElementById('revenue');
            const expenseInput = document.getElementById('expense');
            const profitInput = document.getElementById('profitloss');

            const formatter = new Intl.NumberFormat('id-ID', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 2
            });

            const parseNumber = (value) => parseFloat((value || '').toString().replace(/\./g, '').replace(/,/g,
                '.')) || 0;

            const formatCurrency = (input) => {
                const value = parseNumber(input.value);
                input.value = value ? formatter.format(value) : '';
            };

            const hitungProfit = () => {
                const revenue = parseNumber(revenueInput.value);
                const expense = parseNumber(expenseInput.value);
                profitInput.value = formatter.format(revenue - expense);
            };

            [revenueInput, expenseInput].forEach(input => {
                input.addEventListener('input', hitungProfit);
                input.addEventListener('blur', () => formatCurrency(input));
            });

            // Pastikan profit awal dihitung jika ada value lama
            hitungProfit();

            // Submit → kirim angka asli ke backend
            document.querySelector('form').addEventListener('submit', () => {
                revenueInput.value = parseNumber(revenueInput.value);
                expenseInput.value = parseNumber(expenseInput.value);
            });
        });
    </script>
@endsection
