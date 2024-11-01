<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Produk\AddProdukRequest;
use App\Http\Requests\Produk\UpdateProdukRequest;
use App\Models\Produk;
use App\Traits\JsonResponse;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    use JsonResponse;

    public function list(Request $request)
    {
        $data['list'] = Produk::all();
        return $this->successResponse($data);
    }

    public function detail(Produk $produk)
    {
        if (!$produk) {
            return $this->errorResponse('produk tidak ditemukan', 404);
        }

        return $this->successResponse($produk);
    }

    public function addAction(AddProdukRequest $request)
    {
        $payload = $request->validated();
        $payload['as'] = 'admin';
        $payload['status'] = 'active';
        produk::create($payload);
        return $this->successResponse();
    }

    public function updateAction(UpdateProdukRequest $request, produk $produk)
    {
        if (!$produk) {
            return $this->errorResponse('produk tidak ditemukan', 404);
        }

        $produk->update($request->validated());
        return $this->successResponse();
    }


    public function deleteAction(Produk $produk)
    {
        if (!$produk) {
            return $this->errorResponse('produk tidak ditemukan', 404);
        }

        $produk->delete();
        return $this->successResponse();
    }
}
