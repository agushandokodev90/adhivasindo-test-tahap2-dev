<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Traits\JsonResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    use JsonResponse;

    public function list(Request $request)
    {
        $startDate = Carbon::parse($request->from);
        $endDate = Carbon::parse($request->to);

        $data['list'] = Transaksi::whereBetween('created_at', [$startDate, $endDate])->get();
        return $this->successResponse($data);
    }
}
