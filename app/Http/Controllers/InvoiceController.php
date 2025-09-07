<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_invoice')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = Invoice::with('product', 'user');

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('amount', function ($row) {
                    return number_format($row->amount, 0, ',', '.');
                })
                ->addColumn('user', fn($row) => $row->user->name ?? '-')
                ->addColumn('product', fn($row) => $row->product->name ?? '-')
                ->addColumn('status', fn($row) => $row->is_paid ? '<span class="badge bg-success">Paid</span>' : '<span class="badge bg-warning">Unpaid</span>')
                ->addColumn('action', function ($row) {
                    $buttons = '<div class="btn-group" role="group">';
                    if (Auth()->user()->role->akses_edit_invoice) {
                        $editUrl = route('invoices.edit', $row->id);
                        $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>';
                    }
                    if (Auth()->user()->role->akses_hapus_invoice) {
                        $deleteUrl = route('invoices.destroy', $row->id);
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
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('invoices.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_tambah_invoice')) {
            return $response;
        }

        $products = Product::pluck('name', 'id');
        $users = User::where('role_id', 3)->pluck('name', 'id'); // ambil semua user
        return view('invoices.create', compact('products', 'users'));
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_tambah_invoice')) {
            return $response;
        }

        $request->validate([
            'user_id'    => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'amount'     => 'required|numeric|min:0',
            'due_date'   => 'required|date|after_or_equal:today',
            'is_paid'    => 'boolean',
            'paid_at'    => 'nullable|date',
        ]);

        Invoice::create([
            'user_id'    => $request->user_id,
            'product_id' => $request->product_id,
            'amount'     => $request->amount,
            'due_date'   => $request->due_date,
            'is_paid'    => $request->is_paid ?? 0,
            'paid_at'    => $request->is_paid ? ($request->paid_at ?? now()) : null,
        ]);

        return redirect()->route('invoices.index')->with('success', 'Invoice berhasil ditambahkan.');
    }

    public function edit(Invoice $invoice)
    {
        if ($response = $this->checkIzin('akses_edit_invoice')) {
            return $response;
        }

        $products = Product::pluck('name', 'id');
        $users = User::where('role_id', 3)->pluck('name', 'id');
        return view('invoices.edit', compact('invoice', 'products', 'users'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        if ($response = $this->checkIzin('akses_edit_invoice')) {
            return $response;
        }

        $request->validate([
            'user_id'    => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'amount'     => 'required|numeric|min:0',
            'due_date'   => 'required|date',
            'is_paid'    => 'boolean',
            'paid_at'    => 'nullable|date',
        ]);

        $data = $request->only(['user_id', 'product_id', 'amount', 'due_date', 'is_paid', 'paid_at']);

        // kalau invoice ditandai paid tapi belum ada paid_at, isi otomatis
        if ($request->is_paid && !$request->paid_at) {
            $data['paid_at'] = now();
        }

        $invoice->update($data);

        return redirect()->route('invoices.index')->with('success', 'Invoice berhasil diperbarui.');
    }

    public function destroy(Invoice $invoice)
    {
        if ($response = $this->checkIzin('akses_hapus_invoice')) {
            return $response;
        }

        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice berhasil dihapus.');
    }
}
