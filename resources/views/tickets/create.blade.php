@extends('template.master')

@section('tickets-active', 'active')

@section('content')
<div class="container-fluid py-0 px-0">
    <h1 class="h3 mb-3"><strong>Tambah Ticket</strong></h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('tickets.store') }}" method="POST">
                @csrf

                {{-- Tenant --}}
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

                {{-- Produk --}}
                <div class="mb-3">
                    <label for="product_id" class="form-label">Produk</label>
                    <select name="product_id" id="product_id" class="form-select select2" required>
                        <option value="">-- Pilih Produk --</option>
                        @foreach ($products as $id => $name)
                            <option value="{{ $id }}" {{ old('product_id') == $id ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Deskripsi --}}
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Simpan
                </button>
                <a href="{{ route('tickets.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Batal
                </a>
            </form>
        </div>
    </div>
</div>
@endsection
