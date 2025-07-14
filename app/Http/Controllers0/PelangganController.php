<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class PelangganController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pelanggan.index');
    }

    /**
     * Get data for DataTables.
     */
    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $data = Pelanggan::query()->select(["*"]);
            
            if ($request->has('nama')) {
                $data->where('nama', 'like', '%' . $request->input('nama') . '%');
            }

            if ($request->has('email')) {
                $data->where('email', 'like', '%' . $request->input('email') . '%');
            }

            if ($request->has('status_aktif') && $request->input('status_aktif') !== null) {
                $data->where('status_aktif', $request->input('status_aktif'));
            }

            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $editUrl = route('pelanggans.edit', $row->id);
                    $deleteUrl = route('pelanggans.destroy', $row->id);
                    return '
                        <a href="' . $editUrl . '" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                        <form action="' . $deleteUrl . '" method="POST" style="display:inline;" onsubmit="return confirm(\'Are you sure?\');">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    ';
                })
                ->editColumn('status_aktif', function ($row) {
                    return $row->status_aktif;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pelanggan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'email' => 'nullable|email|max:100|unique:pelanggans,email',
            'telepon' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
            'jenis_kelamin' => 'nullable|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'pekerjaan' => 'nullable|string|max:50',
            'no_ktp' => 'nullable|string|max:20|unique:pelanggans,no_ktp',
            'status_aktif' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Pelanggan::create($request->all());

        return redirect()->route('pelanggans.index')->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return view('pelanggan.show', compact('pelanggan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return view('pelanggan.edit', compact('pelanggan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'email' => 'nullable|email|max:100|unique:pelanggans,email,' . $id,
            'telepon' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
            'jenis_kelamin' => 'nullable|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'pekerjaan' => 'nullable|string|max:50',
            'no_ktp' => 'nullable|string|max:20|unique:pelanggans,no_ktp,' . $id,
            'status_aktif' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $pelanggan->update($request->all());

        return redirect()->route('pelanggans.index')->with('success', 'Pelanggan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();

        return redirect()->route('pelanggans.index')->with('success', 'Pelanggan berhasil dihapus.');
    }
}
