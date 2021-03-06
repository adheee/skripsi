<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Barang;

class BibitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request) //menampilkan hal. data bibit
    {
        //mengurutkan dari terbaru ke terlama (descending)
        if($request->get('search') != '') {
            $data = Barang::where('jenis', 'bibit')
            ->with('admins:id,name')
            ->where('nama', 'like', '%'.$request->get('search').'%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        } else {
            $data = Barang::where('jenis', 'bibit')
            ->with('admins:id,name')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        }
        
        $jml = Barang::where('jenis', 'bibit')
            ->count();
        // return $data; //uncomment ini untuk melihat api data

        return view('admin.page.bibit', ['data' => $data, 'jml' => $jml]); //struktur folder di folder views
    }

    public function store(Request $request) //menambah data bibit
    {
        $validasi = $this->validate($request, [
            'nama'      => 'required|string',
            'harga'     => 'required|numeric',
            'min_beli'  => 'required|numeric',
            'stok'      => 'required|numeric',
            'keterangan' => 'required|string',
            'gambar'    => 'image|mimes:jpeg,png,jpg|max:3072'
        ]);

        $data = new Barang;
        $data->nama         = $request->get('nama');
        $data->jenis        = 'bibit';
        $data->harga        = $request->get('harga');
        $data->min_beli     = $request->get('min_beli');
        $data->stok         = $request->get('stok');
        $data->keterangan   = $request->get('keterangan');
        $data->admin_id     = Auth::guard('admin')->user()->id;

        $gambar = $request->file('gambar');
        if ($gambar) {
            $gambar_path = $gambar->store('gambar', 'public');
            $data->gambar = $gambar_path;
        }
        $data->save();
        return redirect()->back()->with('success', 'Berhasil menghapus data pupuk');
    }

    public function update(Request $request, $id) //mengubah atau suplly data bibit
    {
        $validasi = $this->validate($request, [
            'nama'      => 'required|string',
            'harga'     => 'required|numeric',
            'min_beli'  => 'required|numeric',
            'stok'      => 'required|numeric',
            'keterangan' => 'required|string',
            'gambar'    => 'image|mimes:jpeg,png,jpg|max:3072'
        ]);

        $data = Barang::findOrFail($id);
        $data->nama         = $request->get('nama');
        $data->harga        = $request->get('harga');
        $data->min_beli     = $request->get('min_beli');
        $data->stok         = $request->get('stok');
        $data->keterangan   = $request->get('keterangan');
        $data->admin_id     = Auth::guard('admin')->user()->id;

        $gambar = $request->file('gambar');
        if ($gambar) {
            if ($data->gambar && file_exists(storage_path('app/public/' . $data->gambar))) {
                \Storage::delete('public/' . $data->gambar);
            }
            $gambar_path = $gambar->store('gambar', 'public');
            $data->gambar = $gambar_path;
        }
        $data->save();
        return redirect()->back()->with('success', 'Berhasil mengubah data bibit');
    }

    public function delete($id)
    {
        $data = Barang::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Berhasil menghapus data bibit');
    }
}
