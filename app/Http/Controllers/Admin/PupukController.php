<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Barang;

class PupukController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index() //menampilkan hal. data pupuk
    {
        //mengurutkan dari terbaru ke terlama (descending)
        $data = Barang::where('jenis', 'pupuk')
                ->with('admins:id,name')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        $jml = Barang::where('jenis', 'pupuk')
                ->count();
        // return $data; //uncomment ini untuk melihat api data

        return view('', ['data' => $data, 'jml' => $jml]); //struktur folder di folder views
    }

    public function store(Request $request) //menambah data pupuk
    {
        $validasi = $this->validate($request, [
            'nama'      => 'required|string',
            'harga'     => 'required|numeric',
            'min_beli'  => 'required|numeric',
            'stok'      => 'required|numeric',
            'keterangan'=> 'required|string',
            'gambar'    => 'image|mimes:jpeg,png,jpg|max:3072'
        ]);

        $data = new Barang;
        $data->nama         = $request->get('nama');
        $data->jenis        = 'pupuk';
        $data->harga        = $request->get('harga');
        $data->min_beli     = $request->get('min_beli');
        $data->stok         = $request->get('stok');
        $data->deskripsi    = $request->get('keterangan');
        $data->admin_by     = Auth::guard('admin')->user()->id;

        $gambar = $request->file('gambar');
        if ($gambar) {
            $gambar_path = $gambar->store('gambar', 'public');
            $data->gambar = $gambar_path;
        }
        $data->save();
        return redirect()->back()->with('success', 'Berhasil menghapus data pupuk');
    }

    public function update(Request $request, $id) //mengubah atau suplly data pupuk
    {
        $validasi = $this->validate($request, [
            'nama'      => 'required|string',
            'harga'     => 'required|numeric',
            'min_beli'  => 'required|numeric',
            'stok'      => 'required|numeric',
            'keterangan'=> 'required|string',
            'gambar'    => 'image|mimes:jpeg,png,jpg|max:3072'
        ]);

        $data = Barang::findOrFail($id);
        $data->nama         = $request->get('nama');
        $data->harga        = $request->get('harga');
        $data->min_beli     = $request->get('min_beli');
        $data->stok         = $request->get('stok');
        $data->keterangan   = $request->get('keterangan');
        $data->admin_by     = Auth::guard('admin')->user()->id;

        $gambar = $request->file('gambar');
        if ($gambar) {
            if ($data->gambar && file_exists(storage_path('app/public/' . $data->gambar))) {
                \Storage::delete('public/' . $data->gambar);
            }
            $gambar_path = $gambar->store('gambar', 'public');
            $data->gambar = $gambar_path;
        }
        $data->save();
        return redirect()->back()->with('success', 'Berhasil mengubah data pupuk');
    }

    public function delete($id)
    {
        $data = Barang::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Berhasil menghapus data pupuk');
    }
}
