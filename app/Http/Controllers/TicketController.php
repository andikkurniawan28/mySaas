<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ticket;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_ticket')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = Ticket::with('product', 'user');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user', fn($row) => $row->user->name ?? '-')
                ->addColumn('product', fn($row) => $row->product->name ?? '-')
                ->addColumn('status', function ($row) {
                    return match ($row->status) {
                        'open'        => '<span class="badge bg-warning">Open</span>',
                        'in_progress' => '<span class="badge bg-info text-dark">In Progress</span>',
                        'closed'      => '<span class="badge bg-success">Closed</span>',
                    };
                })

                ->addColumn('action', function ($row) {
                    $buttons = '<div class="btn-group" role="group">';
                    if (Auth()->user()->role->akses_daftar_ticket) {
                        $editUrl = route('tickets.show', $row->id);
                        $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-info">Detail</a>';
                    }
                    if (Auth()->user()->role->akses_edit_ticket) {
                        $editUrl = route('tickets.edit', $row->id);
                        $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>';
                    }
                    if (Auth()->user()->role->akses_hapus_ticket) {
                        $deleteUrl = route('tickets.destroy', $row->id);
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

        return view('tickets.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_tambah_ticket')) {
            return $response;
        }

        $products = Product::pluck('name', 'id');
        $users = User::where('role_id', 3)->pluck('name', 'id'); // ambil semua user
        return view('tickets.create', compact('products', 'users'));
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_tambah_ticket')) {
            return $response;
        }

        $request->validate([
            'user_id'    => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'description'=> 'required|string',
        ]);

        Ticket::create([
            'user_id'    => $request->user_id,
            'product_id' => $request->product_id,
            'description'=> $request->description,
            'status'     => $request->status ?? 'open',
        ]);

        return redirect()->route('tickets.index')->with('success', 'Ticket berhasil ditambahkan.');
    }

    public function edit(Ticket $ticket)
    {
        if ($response = $this->checkIzin('akses_edit_ticket')) {
            return $response;
        }

        $products = Product::pluck('name', 'id');
        $users = User::where('role_id', 3)->pluck('name', 'id');
        return view('tickets.edit', compact('ticket', 'products', 'users'));
    }

    public function show(Ticket $ticket)
    {
        if ($response = $this->checkIzin('akses_daftar_ticket')) {
            return $response;
        }

        $ticket->load(['user', 'product']);

        return view('tickets.show', compact('ticket'));
    }


    public function update(Request $request, Ticket $ticket)
    {
        if ($response = $this->checkIzin('akses_edit_ticket')) {
            return $response;
        }

        $request->validate([
            'user_id'    => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'description'=> 'required|string',
            'status'     => 'in:open,in_progress,closed',
        ]);

        $ticket->update([
            'user_id'    => $request->user_id,
            'product_id' => $request->product_id,
            'description'=> $request->description,
            'status'     => $request->status,
        ]);

        return redirect()->route('tickets.index')->with('success', 'Ticket berhasil diperbarui.');
    }

    public function destroy(Ticket $ticket)
    {
        if ($response = $this->checkIzin('akses_hapus_ticket')) {
            return $response;
        }

        $ticket->delete();
        return redirect()->route('tickets.index')->with('success', 'Ticket berhasil dihapus.');
    }
}
