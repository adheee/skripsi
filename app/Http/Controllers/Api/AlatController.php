<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Barang;
use App\TransaksiBarang;
use Auth;
use DB;
class AlatController extends Controller
{ 
    public function index(Request $request) //menampilkan daftar Alat (tanpa header)
	{
        if($request->sort == 'a-z') {
            $data = Barang::select('id', 'nama', 'harga', 'min_beli', 'stok', 'keterangan', 'gambar')
            ->where('jenis', 'alat')
            ->orderBy('nama', 'asc')
            ->paginate(8);
        } else if($request->sort == 'z-a') {
            $data = Barang::select('id', 'nama', 'harga', 'min_beli', 'stok', 'keterangan', 'gambar')
            ->where('jenis', 'alat')
            ->orderBy('nama', 'desc')
            ->paginate(8);
        } else if($request->sort == 'murah-mahal') {
            $data = Barang::select('id', 'nama', 'harga', 'min_beli', 'stok', 'keterangan', 'gambar')
            ->where('jenis', 'alat')
            ->orderBy('harga', 'asc')
            ->paginate(8);
        } else if($request->sort == 'mahal-murah') {
            $data = Barang::select('id', 'nama', 'harga', 'min_beli', 'stok', 'keterangan', 'gambar')
            ->where('jenis', 'alat')
            ->orderBy('harga', 'desc')
            ->paginate(8);
        } else {
            $data = Barang::select('id', 'nama', 'harga', 'min_beli', 'stok', 'keterangan', 'gambar')
            ->where('jenis', 'alat')
            ->orderBy('created_at', 'desc')
            ->paginate(8); 
        }

        return response()->json([
            'status' => true,
            'message' => 'data alat (per 8 data)',
            'data'  => $data->items(),
            'current_page' => $data->currentPage(),
            'first_page_url' => $data->url(1),
            'from' => $data->firstItem(),
            'last_page' => $data->lastPage(),

            'last_page_url' => $data->url($data->lastPage()) ,
            'next_page_url' => $data->nextPageUrl(),
            'path'  => $data->path(),
            'per_page' => $data->perPage(),
            'prev_page_url' => $data->previousPageUrl(),
            'to' => $data->count(),
            'total' => $data->total()
        ]);
	}

	// public function store(Request $request, $id) //proses pembelian alat
	// {
	// 	if(!$user = Auth::user()) {
 //                return response()->json([
 //                    'status'    => false,
 //                    'message'   => 'Invalid Token'
 //                ]);
 //        }

 //        if($user->petani_verified == '0') {
 //            return response()->json([
 //                'status' => false, 
 //                'message' => 'Akun petani belum diverifikasi'
 //            ]);
 //        }

 //        $validator = Validator::make($request->all(), [
 //                'jumlah' 		=> 'required|string',
 //                // 'waktu_jemput'  => 'date_format:Y-m-d H:i:s',
 //                'alamat_lengkap'=> 'required|string',
 //                'kecamatan' 	=> 'required|string',
 //                'kelurahan'		=> 'required|string',
 //            ]);

 //        if($validator->fails()) {
 //                $message = $validator->messages()->first();
 //                return response()->json([
 //                    'status' => false,
 //                    'messsage' => $message
 //                ]);
 //        }

 //        $alat = Barang::find($id);
 //        if ($alat == null) {
 //            return response()->json([
 //                'status' => false, 
 //                'message' => 'Id alat tidak ditemukan'
 //            ]);
 //        }

 //        if($alat->min_beli > $request->get('jumlah')) { //cek minimal pembelian
 //        	return response()->json([
 //                'status' => false, 
 //                'message' => 'Minimal pembelian '.$alat->min_beli.' kg'
 //            ]);
 //        }

 //        if($alat->stok < $request->get('jumlah')) { //cek stok
 //        	return response()->json([
 //                'status' => false, 
 //                'message' => 'Stok tidak cukup. stok tersedia '.$alat->stok.' kg'
 //            ]);
 //        }

 //        $data = TransaksiBarang::create([
 //                'jumlah' 	=> $request->get('jumlah'),
 //                'harga' 	=> $alat->harga,
 //                'alamat' 	=> $request->get('alamat_lengkap'),
 //                'kecamatan' => $request->get('kecamatan'),
 //                'kelurahan' => $request->get('kelurahan'),
 //                // 'waktu_jemput'  => $request->get('waktu_jemput'),
 //                'keterangan'=> $request->get('keterangan'),
 //                'status'	=> '0',
 //                'jenis_bayar' => 'cod',
 //                'barang_id'	=> $alat->id,
 //                'user_id'	=> $user->id,

 //            ]);

 //        return response()->json([
 //                    'status' => true,
 //                    'message' => 'Berhasil mengirim permintaan pembelian alat ! segera diproses.'
 //                ]);

	// }

	// public function transaksi() // sedang transaksi alat user
 //    {
 //        if(!$user = Auth::user()) {
 //                return response()->json([
 //                    'status'    => false,
 //                    'message'   => 'Invalid Token'
 //                ]);
 //        }

 //        if($user->petani_verified == '0') {
 //            return response()->json([
 //                'status' => false, 
 //                'message' => 'Akun petani belum diverifikasi'
 //            ]);
 //        }

 //        $data = DB::table('transaksi_barangs')
 //                ->select('transaksi_barangs.id', 'transaksi_barangs.jumlah', 'transaksi_barangs.harga', 'transaksi_barangs.alamat', 'transaksi_barangs.kecamatan', 'transaksi_barangs.kelurahan', 'transaksi_barangs.keterangan', 'barangs.nama as nama_alat', 'transaksi_barangs.created_at' )
 //                ->join('barangs', 'transaksi_barangs.barang_id', '=', 'barangs.id')
 //                ->where('transaksi_barangs.status', '0')
 //                ->where('transaksi_barangs.user_id', $user->id)
 //                ->orderBy('transaksi_barangs.created_at', 'desc')
 //                ->get();

 //        return response()->json([
 //                    'status'    => true,
 //                    'message'   => 'Sedang transaksi alat oleh user id '.$user->name,
 //                    'data'      => $data
 //                ]);
 //    }

 //    public function riwayat() // riwayat transaksi alat user
 //    {
 //        if(!$user = Auth::user()) {
 //                return response()->json([
 //                    'status'    => false,
 //                    'message'   => 'Invalid Token'
 //                ]);
 //        }

 //        if($user->petani_verified == '0') {
 //            return response()->json([
 //                'status' => false, 
 //                'message' => 'Akun petani belum diverifikasi'
 //            ]);
 //        }

 //        $data = DB::table('transaksi_barangs')
 //                ->select('transaksi_barangs.id', 'transaksi_barangs.jumlah', 'transaksi_barangs.harga', 'transaksi_barangs.alamat', 'transaksi_barangs.kecamatan', 'transaksi_barangs.kelurahan', 'transaksi_barangs.keterangan', 'barangs.nama as nama_alat', 'transaksi_barangs.created_at' )
 //                ->join('barangs', 'transaksi_barangs.barang_id', '=', 'barangs.id')
 //                ->where('transaksi_barangs.status', '1')
 //                ->where('transaksi_barangs.user_id', $user->id)
 //                ->orderBy('transaksi_barangs.created_at', 'desc')
 //                ->get();

 //        return response()->json([
 //                    'status'    => true,
 //                    'message'   => 'Riwayat transaksi alat oleh user id '.$user->name,
 //                    'data'      => $data
 //                ]);
 //    }

 //    public function batal() // transaksi alat user yang dibatalkan
 //    {
 //        if(!$user = Auth::user()) {
 //                return response()->json([
 //                    'status'    => false,
 //                    'message'   => 'Invalid Token'
 //                ]);
 //        }

 //        if($user->petani_verified == '0') {
 //            return response()->json([
 //                'status' => false, 
 //                'message' => 'Akun petani belum diverifikasi'
 //            ]);
 //        }

 //        $data = DB::table('transaksi_barangs')
 //                ->select('transaksi_barangs.id', 'transaksi_barangs.jumlah', 'transaksi_barangs.harga', 'transaksi_barangs.alamat', 'transaksi_barangs.kecamatan', 'transaksi_barangs.kelurahan', 'transaksi_barangs.keterangan', 'barangs.nama as nama_alat', 'transaksi_barangs.created_at' )
 //                ->join('barangs', 'transaksi_barangs.barang_id', '=', 'barangs.id')
 //                ->where('transaksi_barangs.status', 'batal')
 //                ->where('transaksi_barangs.user_id', $user->id)
 //                ->orderBy('transaksi_barangs.created_at', 'desc')
 //                ->get();

 //        return response()->json([
 //                    'status'    => true,
 //                    'message'   => 'Transaksi alat oleh user id '.$user->name. ' yang dibatalkan',
 //                    'data'      => $data
 //                ]);
 //    }
}
