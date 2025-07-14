<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Merek;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ProdukController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            // Fetch products with related kategori and merek
            $products = Produk::with(['kategori', 'merek'])->select('produks.*');

            // Apply custom filters
            $products->when($request->kategori, function ($query) use ($request) {
                return $query->whereHas('kategori', function ($q) use ($request) {
                    $q->where('id', $request->kategori); // Assuming kategori has an 'id' column
                });
            })->when($request->merek, function ($query) use ($request) {
                return $query->whereHas('merek', function ($q) use ($request) {
                    $q->where('id', $request->merek); // Assuming merek has an 'id' column
                });
            })->when($request->status !== null, function ($query) use ($request) {
                return $query->where('aktif', $request->status); // Assuming status is 'aktif' (0 or 1)
            })->when($request->stok !== null, function ($query) use ($request) {
                return $query->where('stok_minimum', '>=', $request->stok); // Filter by minimum stock
            })->when($request->harga_min, function ($query) use ($request) {
                return $query->where('harga_jual', '>=', $request->harga_min);
            })->when($request->harga_max, function ($query) use ($request) {
                return $query->where('harga_jual', '<=', $request->harga_max);
            })->when($request->barcode, function ($query) use ($request) {
                return $query->where('kode_barcode', $request->barcode); // Assuming 'barcode' is a column in produks table
            })->when($request->satuan, function ($query) use ($request) {
                return $query->where('satuan', $request->satuan); // Assuming 'satuan' is a column in produks table
            });

            return DataTables::of($products)
                ->addColumn('dimensi', function ($product) {
                    return number_format($product->panjang, 2) . ' x ' .
                        number_format($product->lebar, 2) . ' x ' .
                        number_format($product->tinggi, 2) . ' cm';
                })
                ->editColumn('harga_jual', function ($product) {
                    return $product->harga_jual;
                })
                ->editColumn('harga_modal', function ($product) {
                    return $product->harga_modal;
                })
                ->editColumn('berat', function ($product) {
                    return number_format($product->berat, 2);
                })
                ->editColumn('deskripsi', function ($product) {
                    return $product->deskripsi;
                })
                ->editColumn('aktif', function ($product) {
                    return $product->aktif ? 1 : 0;
                })
                ->editColumn('created_at', function ($product) {
                    return $product->created_at->toDateTimeString();
                })
                ->editColumn('updated_at', function ($product) {
                    return $product->updated_at->toDateTimeString();
                })
                ->make(true);
        }

        return response()->json(['error' => 'Invalid request'], 400);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all categories and brands
        $kategoris = Kategori::select('id', 'nama')->get();
        $mereks = Merek::select('id', 'nama')->get();

        // Pass data to the view
        return view('produk.index', compact('kategoris', 'mereks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (request()->ajax()) {
            $kategoris = Kategori::select(['id', 'nama'])->get();
            $mereks = Merek::select(['id', 'nama'])->get();

            return response()->json([
                'kategoris' => $kategoris,
                'mereks' => $mereks,
            ]);
        }

        return response()->json(['error' => 'Invalid request'], 400);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
                'kode_sku' => 'required|string|max:50|unique:produks,kode_sku',
                'kode_barcode' => 'nullable|string|max:100|unique:produks,kode_barcode',
                'satuan' => 'required|string|max:50',
                'id_kategori' => 'required|exists:kategoris,id',
                'id_merek' => 'required|exists:mereks,id',
                'harga_jual' => 'required|numeric|min:0',
                'harga_modal' => 'required|numeric|min:0',
                'panjang' => 'required|numeric|min:0',
                'lebar' => 'required|numeric|min:0',
                'tinggi' => 'required|numeric|min:0',
                'berat' => 'required|numeric|min:0',
                'jumlah_stok' => 'required|numeric|min:0',
                'stok_minimum' => 'required|numeric|min:0',
                'deskripsi' => 'nullable|string',
                'aktif' => 'boolean',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            try {
                DB::beginTransaction();

                $imagePath = null;
                if ($request->hasFile('gambar')) {
                    $image = $request->file('gambar');
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    // $imagePath = $image->storeAs('produk', $imageName, 'public');
                    $storagePath = $image->store('public/produk');
                    $imagePath = str_replace('public/', 'storage/', $storagePath); // Store relative path for consistency
                }

                $produk = Produk::create([
                    'nama' => $request->nama,
                    'slug' => $request->slug,
                    'kode_sku' => $request->kode_sku,
                    'kode_barcode' => $request->kode_barcode,
                    'satuan' => $request->satuan,
                    'id_kategori' => $request->id_kategori,
                    'id_merek' => $request->id_merek,
                    'harga_jual' => $request->harga_jual,
                    'harga_modal' => $request->harga_modal,
                    'panjang' => $request->panjang,
                    'lebar' => $request->lebar,
                    'tinggi' => $request->tinggi,
                    'berat' => $request->berat,
                    'deskripsi' => $request->deskripsi,
                    'jumlah_stok' => $request->jumlah_stok,
                    'stok_minimum' => $request->stok_minimum,
                    'aktif' => $request->aktif ?? true,
                    'gambar' => $imagePath,
                ]);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Product created successfully',
                    'data' => $produk->load(['kategori', 'merek'])
                ], 201);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'error' => 'Failed to create product',
                    'message' => $e->getMessage()
                ], 500);
            }
        }

        return response()->json(['error' => 'Invalid request'], 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (request()->ajax()) {
            $produk = Produk::with(['kategori', 'merek'])->find($id);

            if (!$produk) {
                return response()->json(['error' => 'Product not found'], 404);
            }

            return response()->json(['data' => $produk]);
        }

        return response()->json(['error' => 'Invalid request'], 400);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (request()->ajax()) {
            $produk = Produk::find($id);
            $kategoris = Kategori::select(['id', 'nama'])->get();
            $mereks = Merek::select(['id', 'nama'])->get();

            if (!$produk) {
                return response()->json(['error' => 'Product not found'], 404);
            }

            return response()->json([
                'data' => $produk,
                'kategoris' => $kategoris,
                'mereks' => $mereks,
            ]);
        }

        return response()->json(['error' => 'Invalid request'], 400);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if ($request->ajax()) {
            $produk = Produk::find($id);

            if (!$produk) {
                return response()->json(['error' => 'Product not found'], 404);
            }

            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
                'kode_sku' => 'required|string|max:50|unique:produks,kode_sku,' . $id,
                'kode_barcode' => 'nullable|string|max:100|unique:produks,kode_barcode,' . $id,
                'satuan' => 'required|string|max:50',
                'id_kategori' => 'required|exists:kategoris,id',
                'id_merek' => 'required|exists:mereks,id',
                'harga_jual' => 'required|numeric|min:0',
                'harga_modal' => 'required|numeric|min:0',
                'panjang' => 'required|numeric|min:0',
                'lebar' => 'required|numeric|min:0',
                'tinggi' => 'required|numeric|min:0',
                'berat' => 'required|numeric|min:0',
                'jumlah_stok' => 'required|numeric|min:0',
                'stok_minimum' => 'required|numeric|min:0',
                'deskripsi' => 'nullable|string',
                'aktif' => 'boolean',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            try {
                DB::beginTransaction();

                $produk->update([
                    'nama' => $request->nama,
                    'slug' => $request->slug,
                    'kode_sku' => $request->kode_sku,
                    'kode_barcode' => $request->kode_barcode,
                    'satuan' => $request->satuan,
                    'id_kategori' => $request->id_kategori,
                    'id_merek' => $request->id_merek,
                    'harga_jual' => $request->harga_jual,
                    'harga_modal' => $request->harga_modal,
                    'panjang' => $request->panjang,
                    'lebar' => $request->lebar,
                    'tinggi' => $request->tinggi,
                    'berat' => $request->berat,
                    'deskripsi' => $request->deskripsi,
                    'jumlah_stok' => $request->jumlah_stok,
                    'stok_minimum' => $request->stok_minimum,
                    'aktif' => $request->aktif ?? true,
                ]);

                // Handle image upload
                if ($request->hasFile('gambar')) {
                    // Delete old image if exists
                    if (file_exists($produk->gambar)) {
                        unlink($produk->gambar);
                        // return response()->json([
                        //     'success' => true,
                        //     'message' => 'Gambar tersedia ' . $produk->gambar,
                        // ]);
                    }

                    // Store new image
                    $imagePath = $request->file('gambar')->store('public/produk');
                    // Convert storage path to relative path
                    $updateData['gambar'] = str_replace('public/', 'storage/', $imagePath);
                }

                $produk->update($updateData);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Product updated successfully',
                    'data' => $produk->load(['kategori', 'merek'])
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'error' => 'Failed to update product',
                    'message' => $e->getMessage()
                ], 500);
            }
        }

        return response()->json(['error' => 'Invalid request'], 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (request()->ajax()) {
            $produk = Produk::find($id);

            if (!$produk) {
                return response()->json(['error' => 'Product not found'], 404);
            }

            try {
                // delete gambar
                if (file_exists($produk->gambar)) {
                    unlink($produk->gambar);
                    // return response()->json([
                    //     'success' => true,
                    //     'message' => 'Gambar tersedia ' . $produk->gambar,
                    // ]);
                }

                DB::beginTransaction();
                $produk->delete();
                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Product deleted successfully'
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'error' => 'Failed to delete product',
                    'message' => $e->getMessage()
                ], 500);
            }
        }

        return response()->json(['error' => 'Invalid request'], 400);
    }

    public function getCategoriesAndBrands()
    {
        $categories = Kategori::select('id', 'nama')->get();
        $brands = Merek::select('id', 'nama')->get();

        return response()->json([
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }
}
