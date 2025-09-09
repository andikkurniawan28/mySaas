@extends('template.master')

@section('users-active', 'active')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Edit User</strong></h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="role_id" class="form-label">Role</label>
                        <select name="role_id" id="role_id" class="form-select select2" required>
                            @foreach ($roles as $id => $name)
                                <option value="{{ $id }}" {{ $user->role_id == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" name="name" id="name" class="form-control"
                            value="{{ old('name', $user->name) }}" required>
                    </div>

                    {{-- Organization --}}
                    <div class="mb-3">
                        <label for="organization" class="form-label">Organisasi</label>
                        <input type="text" name="organization" id="organization" class="form-control"
                            value="{{ old('organization', $user->organization) }}" required>
                    </div>

                    {{-- WhatsApp --}}
                    <div class="mb-3">
                        <label for="whatsapp" class="form-label">WhatsApp</label>
                        <input type="text" name="whatsapp" id="whatsapp" class="form-control"
                            value="{{ old('whatsapp', $user->whatsapp) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" name="email" id="email" class="form-control"
                            value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru (Opsional)</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="is_active" class="form-label">Status</label>
                        <select name="is_active" id="is_active" class="form-select select2">
                            <option value="1" {{ $user->is_active ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ !$user->is_active ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>

                    @if($user->role_id == 3)
                    <div class="mb-3">
                        <label class="form-label">Akses Produk</label>

                        {{-- Check All --}}
                        <div class="form-check mb-2">
                            <input type="checkbox" class="form-check-input" id="checkAllProduk">
                            <label class="form-check-label fw-bold" for="checkAllProduk">Pilih Semua</label>
                        </div>

                        <div class="row">
                            @foreach ($user->akses_produk() as $akses)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input akses-produk-checkbox"
                                            id="{{ $akses['id'] }}" name="akses_produk[{{ $akses['id'] }}]"
                                            value="1"
                                            {{ old('akses_produk.' . $akses['id'], $user->{$akses['id']}) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="{{ $akses['id'] }}">
                                            {{ $akses['name'] }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.getElementById('checkAllProduk').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.akses-produk-checkbox');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
    </script>
@endsection
