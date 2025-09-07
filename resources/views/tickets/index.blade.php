@extends('template.master')

@section('tickets-active', 'active')

@section('content')
<div class="container-fluid py-0 px-0">
    <h1 class="h3 mb-3"><strong>Daftar Ticket</strong></h1>

    @if(Auth()->user()->role->akses_tambah_ticket)
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('tickets.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah
        </a>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="ticketTable" class="table table-bordered table-hover table-striped table-sm w-100 text-center">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tenant</th>
                            <th>Produk</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(function() {
        $('#ticketTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('tickets.index') }}",
            order: [[0, 'desc']],
            columns: [
                { data: 'id', name: 'id' },
                { data: 'user', name: 'user.name' },
                { data: 'product', name: 'product.name' },
                { data: 'description', name: 'description' },
                { data: 'status', name: 'status', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endsection
