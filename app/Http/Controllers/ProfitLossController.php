<?php

namespace App\Http\Controllers;

use App\Models\ProfitLoss;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProfitLossController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = ProfitLoss::with('user')->select('profit_losses.*');

            return DataTables::of($query)
                ->addColumn('user', fn($row) => $row->user->name ?? '-')

                ->addColumn('action', function ($row) {
                    $buttons = '<div class="btn-group" role="group">';
                    if (Auth()->user()->role->akses_edit_profitloss) {
                        $editUrl = route('profitlosses.edit', $row->id);
                        $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>';
                    }
                    if (Auth()->user()->role->akses_hapus_profitloss) {
                        $deleteUrl = route('profitlosses.destroy', $row->id);
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

        return view('profitlosses.index');
    }

    public function create()
    {
        $users = User::where('role_id', 3)->pluck('name', 'id'); // ambil semua user
        return view('profitlosses.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'   => 'required|exists:profit_losses,id',
            'date'      => 'required|date',
            'revenue'   => 'required|numeric|min:0',
            'expense'   => 'required|numeric|min:0',
        ]);

        $profitloss = $request->revenue - $request->expense;

        ProfitLoss::create([
            'user_id'   => $request->user_id,
            'date'      => $request->date,
            'revenue'   => $request->revenue,
            'expense'   => $request->expense,
            'profitloss'=> $profitloss,
        ]);

        return redirect()->route('profitlosses.index')->with('success', 'Data Profit & Loss berhasil ditambahkan.');
    }

    public function edit(ProfitLoss $profitloss)
    {
        $users = User::where('role_id', 3)->pluck('name', 'id'); // ambil semua user
        return view('profitlosses.edit', compact('profitloss', 'users'));
    }

    public function update(Request $request, ProfitLoss $profitloss)
    {
        $request->validate([
            'user_id'   => 'required|exists:profit_losses,id',
            'date'      => 'required|date',
            'revenue'   => 'required|numeric|min:0',
            'expense'   => 'required|numeric|min:0',
        ]);

        $profitloss->update([
            'user_id'   => $request->user_id,
            'date'      => $request->date,
            'revenue'   => $request->revenue,
            'expense'   => $request->expense,
            'profitloss'=> $request->revenue - $request->expense,
        ]);

        return redirect()->route('profitlosses.index')->with('success', 'Data Profit & Loss berhasil diperbarui.');
    }
}
