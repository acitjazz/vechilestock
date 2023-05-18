<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\VechileRequest;
use App\Http\Resources\SaleResource;
use App\Models\Vechile;
use Illuminate\Support\Carbon;
use Facades\App\Http\Repositories\SaleRepository;
use Illuminate\Support\Facades\Cache;

class SaleController extends Controller
{
    /**
     * Display a listing of Data.
     **/
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        try {
            $sales = SaleRepository::paginate((int)request('limit') ?? 12);
            $pagination = [
                'total' => $sales->total(),
                'count' => $sales->count(),
                'per_page' => $sales->perPage(),
                'current_page' => $sales->currentPage(),
                'total_pages' => $sales->lastPage()
            ];
            return response()->json(['data' => SaleResource::collection($sales), 'pagination' => $pagination],200);

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'status' => 500], 500);
        }
    }


    public function statistic()
    {

        try {
            $statistic = SaleRepository::statistic();
            return response()->json($statistic, 200);

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'status' => 500], 500);
        }
    }

    public function store(VechileRequest $request)
    {
        try {
            $vechile = Vechile::create($request->all());
            Cache::tags('sales')->flush();
            return response()->json([
                'success' => true,
                'data'=> new SaleResource($vechile),
            ], 200);

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'status' => 500], 500);
        }
    }

}
