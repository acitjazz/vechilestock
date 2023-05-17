<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarResource;
use App\Models\Car;
use Carbon\Carbon;
use Facades\App\Http\Repositories\CarRepository;
use Illuminate\Support\Facades\Cache;

class CarController extends Controller
{
    /**
     * Display a listing of Data.
     **/
    public function index()
    {
        $cars = CarRepository::paginate((int)request('limit') ?? 12);
        $pagination = [
            'total' => $cars->total(),
            'count' => $cars->count(),
            'per_page' => $cars->perPage(),
            'current_page' => $cars->currentPage(),
            'total_pages' => $cars->lastPage()
        ];
        return response()->json(['data' => CarResource::collection($cars), 'pagination' => $pagination]);
    }


    public function show($id)
    {
        $car = CarRepository::find($id);
        if(is_null($car)){
            return response()->json('Car Not Found', 404);
        }
        return response()->json(new CarResource($car), 200);
    }



}
