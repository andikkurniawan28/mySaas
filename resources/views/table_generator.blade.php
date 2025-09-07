@extends('template.master')

@section('table_generator-active', 'active')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Table Generator</strong></h1>

        <div class="card shadow-sm">
            <div class="card-body">

                <form action="{{ route('table_generator.run') }}" method="POST">
                    @csrf

                    {{-- Migration --}}
                    <div class="mb-3">
                        <label for="migration_script" class="form-label">Migration Script</label>
                        <textarea name="migration_script" id="migration_script" class="form-control" rows="8"
                            placeholder="Masukkan CREATE TABLE ... atau Schema::create(...)">{{ old('migration_script') }}</textarea>
                        <small class="text-muted">Kosongkan jika hanya ingin menjalankan seeder.</small>
                    </div>

                    {{-- Seeder --}}
                    <div class="mb-3">
                        <label for="seeder_script" class="form-label">Seeder Script</label>
                        <textarea name="seeder_script" id="seeder_script" class="form-control" rows="8"
                            placeholder="Masukkan INSERT INTO ... atau DB::table(...)->insert(...)">{{ old('seeder_script') }}</textarea>
                        <small class="text-muted">Kosongkan jika hanya ingin menjalankan migration.</small>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-play-fill"></i> Jalankan
                    </button>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Batal
                    </a>
                </form>
            </div>
        </div>
    </div>

    {{-- Optional: preview simple JS alert jika kedua field kosong --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const migration = document.getElementById('migration_script');
            const seeder = document.getElementById('seeder_script');

            form.addEventListener('submit', function(e) {
                if (!migration.value.trim() && !seeder.value.trim()) {
                    e.preventDefault();
                    alert('❌ Migration dan Seeder tidak boleh keduanya kosong!');
                }
            });
        });
    </script>
@endsection
