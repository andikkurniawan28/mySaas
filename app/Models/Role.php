<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function semua_akses()
    {
        return [
            ['id' => 'akses_daftar_jabatan', 'name' => ucwords(str_replace('_', ' ', 'akses_daftar_jabatan'))],
            ['id' => 'akses_tambah_jabatan', 'name' => ucwords(str_replace('_', ' ', 'akses_tambah_jabatan'))],
            ['id' => 'akses_edit_jabatan', 'name' => ucwords(str_replace('_', ' ', 'akses_edit_jabatan'))],
            ['id' => 'akses_hapus_jabatan', 'name' => ucwords(str_replace('_', ' ', 'akses_hapus_jabatan'))],
            ['id' => 'akses_daftar_user', 'name' => ucwords(str_replace('_', ' ', 'akses_daftar_user'))],
            ['id' => 'akses_tambah_user', 'name' => ucwords(str_replace('_', ' ', 'akses_tambah_user'))],
            ['id' => 'akses_edit_user', 'name' => ucwords(str_replace('_', ' ', 'akses_edit_user'))],
            ['id' => 'akses_hapus_user', 'name' => ucwords(str_replace('_', ' ', 'akses_hapus_user'))],
            ['id' => 'akses_daftar_produk', 'name' => ucwords(str_replace('_', ' ', 'akses_daftar_produk'))],
            ['id' => 'akses_tambah_produk', 'name' => ucwords(str_replace('_', ' ', 'akses_tambah_produk'))],
            ['id' => 'akses_edit_produk', 'name' => ucwords(str_replace('_', ' ', 'akses_edit_produk'))],
            ['id' => 'akses_hapus_produk', 'name' => ucwords(str_replace('_', ' ', 'akses_hapus_produk'))],
            ['id' => 'akses_daftar_invoice', 'name' => ucwords(str_replace('_', ' ', 'akses_daftar_invoice'))],
            ['id' => 'akses_tambah_invoice', 'name' => ucwords(str_replace('_', ' ', 'akses_tambah_invoice'))],
            ['id' => 'akses_edit_invoice', 'name' => ucwords(str_replace('_', ' ', 'akses_edit_invoice'))],
            ['id' => 'akses_hapus_invoice', 'name' => ucwords(str_replace('_', ' ', 'akses_hapus_invoice'))],
            ['id' => 'akses_daftar_ticket', 'name' => ucwords(str_replace('_', ' ', 'akses_daftar_ticket'))],
            ['id' => 'akses_tambah_ticket', 'name' => ucwords(str_replace('_', ' ', 'akses_tambah_ticket'))],
            ['id' => 'akses_edit_ticket', 'name' => ucwords(str_replace('_', ' ', 'akses_edit_ticket'))],
            ['id' => 'akses_hapus_ticket', 'name' => ucwords(str_replace('_', ' ', 'akses_hapus_ticket'))],
            ['id' => 'akses_daftar_profitloss', 'name' => ucwords(str_replace('_', ' ', 'akses_daftar_profitloss'))],
            ['id' => 'akses_tambah_profitloss', 'name' => ucwords(str_replace('_', ' ', 'akses_tambah_profitloss'))],
            ['id' => 'akses_edit_profitloss', 'name' => ucwords(str_replace('_', ' ', 'akses_edit_profitloss'))],
            ['id' => 'akses_hapus_profitloss', 'name' => ucwords(str_replace('_', ' ', 'akses_hapus_profitloss'))],
        ];
    }
}
