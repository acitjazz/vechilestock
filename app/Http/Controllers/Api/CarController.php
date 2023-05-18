<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CarRequest;
use App\Http\Resources\CarDetailResource;
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
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        try {
            $cars = CarRepository::paginate((int)request('limit') ?? 12);
            $pagination = [
                'total' => $cars->total(),
                'count' => $cars->count(),
                'per_page' => $cars->perPage(),
                'current_page' => $cars->currentPage(),
                'total_pages' => $cars->lastPage()
            ];
            return response()->json(['data' => CarResource::collection($cars), 'pagination' => $pagination],200);

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'status' => 500], 500);
        }
    }


    public function show($id)
    {
        try {
            $car = CarRepository::find($id);
            if(is_null($car)){
                return response()->json(['message'=> 'Car Not Found', 'status'=>404], 404);
            }
            return response()->json(new CarDetailResource($car), 200);

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'status' => 500], 500);
        }
    }

    public function store(CarRequest $request)
    {
        try {
            $car = Car::create($request->all());
            Cache::tags('cars')->flush();
            return response()->json([
                'success' => true,
                'data'=> new CarResource($car),
            ], 200);

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'status' => 500], 500);
        }
    }

    public function update($car, CarRequest $request)
    {
        try {
            $car = Car::find($car);
            if(is_null($car)){
                return response()->json(['message'=> 'Car Not Found', 'status'=>404], 404);
            }
            $car->update($request->all());

            Cache::tags('cars')->flush();
            return response()->json([
                'success' => true,
                'data'=> new CarResource($car),
            ], 200);

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'status' => 500], 500);
        }
    }

    public function delete($car)
    {
        try {
            $car = Car::find($car);
            if(is_null($car)){
                return response()->json(['message'=> 'Car Not Found', 'status'=>404], 404);
            }
            $car->delete();
            Cache::tags('cars')->flush();
            return response()->json([
                'success' => true,
                'data'=> new CarResource($car),
            ], 200);

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'status' => 500], 500);
        }
    }

    public function restore($car)
    {
        try {
            $car = Car::onlyTrashed()->find($car);
            if(is_null($car)){
                return response()->json(['message'=> 'Car Not Found', 'status'=>404], 404);
            }
            $car->restore();

            Cache::tags('cars')->flush();
            return response()->json([
                'success' => true,
                'data'=> new CarResource($car),
            ], 200);

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'status' => 500], 500);
        }
    }

    public function destroy($car)
    {
        try {
            $car = Car::onlyTrashed()->find($car);
            if(is_null($car)){
                return response()->json(['message'=> 'Car Not Found', 'status'=>404], 404);
            }
            $car->forceDelete();

            Cache::tags('cars')->flush();
            return response()->json([
                'success' => true,
                'data'=> new CarResource($car),
            ], 200);

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'status' => 500], 500);
        }
    }


}
