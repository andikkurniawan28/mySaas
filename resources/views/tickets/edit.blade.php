@extends('template.master')

@section('tickets-active', 'active')

@section('content')
<div class="container-fluid py-0 px-0">
    <h1 class="h3 mb-3"><strong>Edit Ticket</strong></h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('tickets.update', $ticket->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Tenant --}}
                <div class="mb-3">
                    <label for="user_id" class="form-label">Tenant</label>
                    <select name="user_id" id="user_id" class="form-select select2" required>
                        @foreach ($users as $id => $name)
                            <option value="{{ $id }}" {{ $ticket->user_id == $id ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Produk --}}
                <div class="mb-3">
                    <label for="product_id" class="form-label">Produk</label>
                    <select name="product_id" id="product_id" class="form-select select2" required>
                        @foreach ($products as $id => $name)
                            <option value="{{ $id }}" {{ $ticket->product_id == $id ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Deskripsi --}}
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea name="description" id="description" class="form-control" rows="4" required>{{ $ticket->description }}</textarea>
                </div>

                {{-- Status --}}
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select select2">
                        <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>Open</option>
                        <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Update
                </button>
                <a href="{{ route('tickets.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Batal
                </a>
            </form>
        </div>
    </div>
</div>
@endsection
