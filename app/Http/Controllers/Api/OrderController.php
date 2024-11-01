<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transaksi\AddTransaksiRequest;
use App\Http\Requests\Transaksi\UpdateTransaksiRequest;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Traits\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    use JsonResponse;

    use JsonResponse;

    public function list(Request $request)
    {
        $data['list'] = Transaksi::where('produk_id',$request->get('produk_id'))
            ->get();


        return $this->successResponse($data);
    }

    public function detail(Transaksi $transaksi)
    {
        if (!$transaksi) {
            return $this->errorResponse('Transaksi tidak ditemukan', 404);
        }

        return $this->successResponse($transaksi);
    }

    public function addAction(AddTransaksiRequest $request)
    {

        DB::beginTransaction();
        try {
            $payload = $request->validated();
            foreach ($payload['item'] as $item_order) {
                $produk = Produk::find($item_order['produk_id']);
                if($produk->stok == 0)
                {
                    return $this->errorResponse('Stok '.$produk->nama.' habis',400);
                }

                if ($item_order['qty'] > $produk->stok) {
                    return $this->errorResponse('Jumlah melebihi stok barang '.$produk->nama.', stok hanya tersedia '.$produk->stok,400);
                }
                $item_order['harga'] = $produk->harga;
                $item_order['total_harga'] = $produk->harga * $item_order['qty'];
                Transaksi::create($item_order);

                $produk->stok -= $item_order['qty'];
                $produk->save();
            }

            DB::commit();
            return $this->successResponse();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function deleteAction(Transaksi $transaksi)
    {
        if (!$transaksi) {
            return $this->errorResponse('Transaksi tidak ditemukan', 404);
        }

        if($transaksi->status =='lunas'){
            return $this->errorResponse('Transaksi tidak bisa dihapus, dikarenakan sudah LUNAS',400);
        }

        $transaksi->delete();
        return $this->successResponse();
    }
}
