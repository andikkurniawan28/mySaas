@extends('template.master')

@section('profitlosses-active', 'active')

@section('content')
<div class="container-fluid py-0 px-0">
    <h1 class="h3 mb-3"><strong>Edit Profit & Loss</strong></h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('profitlosses.update', $profitloss->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="user_id" class="form-label">Tenant</label>
                    <select name="user_id" id="user_id" class="form-select select2" required>
                        <option value="">-- Pilih Tenant --</option>
                        @foreach ($users as $id => $name)
                            <option value="{{ $id }}" {{ $profitloss->user_id == $id ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="date" class="form-label">Tanggal</label>
                    <input type="date" name="date" id="date" class="form-control" value="{{ $profitloss->date }}" required>
                </div>

                <div class="mb-3">
                    <label for="revenue" class="form-label">Revenue</label>
                    <input type="number" step="0.01" name="revenue" id="revenue" class="form-control" value="{{ $profitloss->revenue }}" required>
                </div>

                <div class="mb-3">
                    <label for="expense" class="form-label">Expense</label>
                    <input type="number" step="0.01" name="expense" id="expense" class="form-control" value="{{ $profitloss->expense }}" required>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Update
                </button>
                <a href="{{ route('profitlosses.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Batal
                </a>
            </form>
        </div>
    </div>
</div>
@endsection
