<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_produk')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = Product::query();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $buttons = '<div class="btn-group" product="group">';
                    if (Auth()->user()->role->akses_edit_produk) {
                        $editUrl = route('products.edit', $row->id);
                        $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>';
                    }
                    if (Auth()->user()->role->akses_hapus_produk) {
                        $deleteUrl = route('products.destroy', $row->id);
                        $buttons .= '
                            <form action="' . $deleteUrl . '" method="POST" onsubmit="return confirm(\'Hapus data ini?\')" style="display:inline-block;">
                                ' . csrf_field() . method_field('DELETE') . '
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        ';
                    }
                    $buttons .= '</div>';
                    return $buttons;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('products.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_tambah_produk')) {
            return $response;
        }

        return view('products.create');
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_tambah_produk')) {
            return $response;
        }

        $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'required|string',
            'demo_link'     => 'nullable|url|max:255',
        ]);

        // Siapkan data insert
        $data = $request->only(['name']);

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }


    public function edit(Product $product)
    {
        if ($response = $this->checkIzin('akses_edit_produk')) {
            return $response;
        }

        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        if ($response = $this->checkIzin('akses_edit_produk')) {
            return $response;
        }

        $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'required|string',
            'demo_link'     => 'nullable|url|max:255',
        ]);

        // Siapkan data update
        $data = $request->only(['name']);

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        if ($response = $this->checkIzin('akses_hapus_produk')) {
            return $response;
        }

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
