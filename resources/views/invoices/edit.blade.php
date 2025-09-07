@extends('template.master')

@section('invoices-active', 'active')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Edit Invoice</strong></h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('invoices.update', $invoice->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Tenant --}}
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Tenant</label>
                        <select name="user_id" id="user_id" class="form-select select2" required>
                            <option value="">-- Pilih Tenant --</option>
                            @foreach ($users as $id => $name)
                                <option value="{{ $id }}"
                                    {{ (old('user_id', $invoice->user_id) == $id) ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Produk --}}
                    <div class="mb-3">
                        <label for="product_id" class="form-label">Produk</label>
                        <select name="product_id" id="product_id" class="form-select select2" required>
                            <option value="">-- Pilih Produk --</option>
                            @foreach ($products as $id => $name)
                                <option value="{{ $id }}"
                                    {{ (old('product_id', $invoice->product_id) == $id) ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Amount --}}
                    <div class="mb-3">
                        <label for="amount" class="form-label">Jumlah (Rp)</label>
                        <input type="number" step="0.01" name="amount" id="amount" class="form-control"
                               value="{{ old('amount', $invoice->amount) }}" required>
                    </div>

                    {{-- Due Date --}}
                    <div class="mb-3">
                        <label for="due_date" class="form-label">Jatuh Tempo</label>
                        <input type="date" name="due_date" id="due_date" class="form-control"
                               value="{{ old('due_date', $invoice->due_date) }}" required>
                    </div>

                    {{-- Status Pembayaran --}}
                    <div class="mb-3">
                        <label for="is_paid" class="form-label">Status Pembayaran</label>
                        <select name="is_paid" id="is_paid" class="form-select">
                            <option value="0" {{ old('is_paid', $invoice->is_paid) == 0 ? 'selected' : '' }}>Belum Dibayar</option>
                            <option value="1" {{ old('is_paid', $invoice->is_paid) == 1 ? 'selected' : '' }}>Sudah Dibayar</option>
                        </select>
                    </div>

                    {{-- Paid At --}}
                    <div class="mb-3">
                        <label for="paid_at" class="form-label">Tanggal Bayar</label>
                        <input type="date" name="paid_at" id="paid_at" class="form-control"
                               value="{{ old('paid_at', $invoice->paid_at) }}">
                    </div>

                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-save"></i> Update
                    </button>
                    <a href="{{ route('invoices.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Batal
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
