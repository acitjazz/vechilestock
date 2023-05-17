<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MotorcycleResource;
use App\Models\Motorcycle;
use Illuminate\Support\Carbon;
use Facades\App\Http\Repositories\MotorcycleRepository;
use Illuminate\Support\Facades\Cache;

class MotorcycleController extends Controller
{
    /**
     * Display a listing of Data.
     **/
    public function index()
    {
        $motorcycles = MotorcycleRepository::paginate((int)request('limit') ?? 12);
        $pagination = [
            'total' => $motorcycles->total(),
            'count' => $motorcycles->count(),
            'per_page' => $motorcycles->perPage(),
            'current_page' => $motorcycles->currentPage(),
            'total_pages' => $motorcycles->lastPage()
        ];
        return response()->json(['data' => MotorcycleResource::collection($motorcycles), 'pagination' => $pagination]);
    }


    public function show($id)
    {
        $motorcycle = MotorcycleRepository::find($id);
        if(is_null($motorcycle)){
            return response()->json('Motorcycle Not Found', 404);
        }
        return response()->json(new MotorcycleResource($motorcycle), 200);
    }



}
