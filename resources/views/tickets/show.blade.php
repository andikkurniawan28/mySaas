@extends('template.master')

@section('tickets-active', 'active')

@section('content')
<div class="container-fluid py-0 px-0">
    <h1 class="h3 mb-3"><strong>Detail Ticket</strong></h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9">{{ $ticket->id }}</dd>

                <dt class="col-sm-3">Tenant</dt>
                <dd class="col-sm-9">{{ $ticket->user->name ?? '-' }}</dd>

                <dt class="col-sm-3">Produk</dt>
                <dd class="col-sm-9">{{ $ticket->product->name ?? '-' }}</dd>

                <dt class="col-sm-3">Deskripsi</dt>
                <dd class="col-sm-9">{{ $ticket->description }}</dd>

                <dt class="col-sm-3">Status</dt>
                <dd class="col-sm-9">
                    @if($ticket->status == 'open')
                        <span class="badge bg-warning">Open</span>
                    @elseif($ticket->status == 'in_progress')
                        <span class="badge bg-info">In Progress</span>
                    @else
                        <span class="badge bg-success">Closed</span>
                    @endif
                </dd>

                <dt class="col-sm-3">Dibuat</dt>
                <dd class="col-sm-9">{{ $ticket->created_at->format('d-m-Y H:i') }}</dd>

                <dt class="col-sm-3">Diperbarui</dt>
                <dd class="col-sm-9">{{ $ticket->updated_at->format('d-m-Y H:i') }}</dd>
            </dl>

            <a href="{{ route('tickets.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            @if(auth()->user()->role->akses_edit_ticket)
                <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>
            @endif
        </div>
    </div>
</div>
@endsection
