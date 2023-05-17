<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VechileResource;
use App\Models\Vechile;
use Illuminate\Support\Carbon;
use Facades\App\Http\Repositories\VechileRepository;
use Illuminate\Support\Facades\Cache;

class VechileController extends Controller
{
    /**
     * Display a listing of Data.
     **/
    public function index()
    {
        $vechiles = VechileRepository::paginate((int)request('limit') ?? 12);
        dd($vechiles);
        $pagination = [
            'total' => $vechiles->total(),
            'count' => $vechiles->count(),
            'per_page' => $vechiles->perPage(),
            'current_page' => $vechiles->currentPage(),
            'total_pages' => $vechiles->lastPage()
        ];
        return response()->json(['data' => VechileResource::collection($vechiles), 'pagination' => $pagination]);
    }


    public function show($id)
    {
        $vechile = VechileRepository::find($id);
        if(is_null($vechile)){
            return response()->json('Vechile Not Found', 404);
        }
        return response()->json(new VechileResource($vechile), 200);
    }



}
