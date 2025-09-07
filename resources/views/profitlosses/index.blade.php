@extends('template.master')

@section('profitlosses-active', 'active')

@section('content')
<div class="container-fluid py-0 px-0">
    <h1 class="h3 mb-3"><strong>Profit & Loss</strong></h1>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('profitlosses.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="profitLossTable" class="table table-bordered table-hover table-striped table-sm w-100 text-center">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tenant</th>
                            <th>Tanggal</th>
                            <th>Revenue</th>
                            <th>Expense</th>
                            <th>Profit/Loss</th>
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
        $('#profitLossTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('profitlosses.index') }}",
            order: [[0, 'desc']],
            columns: [
                { data: 'id', name: 'id' },
                { data: 'user', name: 'user.name' },
                { data: 'date', name: 'date' },
                { data: 'revenue', name: 'revenue' },
                { data: 'expense', name: 'expense' },
                { data: 'profitloss', name: 'profitloss' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endsection
