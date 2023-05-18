<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MotorCycleRequest;
use App\Http\Resources\MotorcycleDetailResource;
use App\Http\Resources\MotorcycleResource;
use App\Models\Motorcycle;
use Illuminate\Support\Motorcyclebon;
use Facades\App\Http\Repositories\MotorcycleRepository;
use Illuminate\Support\Facades\Cache;

class MotorcycleController extends Controller
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
            $motorcycles = MotorcycleRepository::paginate((int)request('limit') ?? 12);
            $pagination = [
                'total' => $motorcycles->total(),
                'count' => $motorcycles->count(),
                'per_page' => $motorcycles->perPage(),
                'current_page' => $motorcycles->currentPage(),
                'total_pages' => $motorcycles->lastPage()
            ];
            return response()->json(['data' => MotorcycleResource::collection($motorcycles), 'pagination' => $pagination],200);

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'status' => 500], 500);
        }
    }


    public function show($id)
    {
        try {
            $motorcycle = MotorcycleRepository::find($id);
            if(is_null($motorcycle)){
                return response()->json(['message'=> 'Motorcycle Not Found', 'status'=> 404], 404);
            }
            return response()->json(new MotorcycleDetailResource($motorcycle), 200);

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'status' => 500], 500);
        }
    }

    public function store(MotorCycleRequest $request)
    {
        try {
            $motorcycle = Motorcycle::create($request->all());
            Cache::tags('motorcycles')->flush();
            return response()->json([
                'success' => true,
                'data'=> new MotorcycleResource($motorcycle),
            ], 200);

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'status' => 500], 500);
        }
    }

    public function update($motorcycle, MotorcycleRequest $request)
    {
        try {
            $motorcycle = Motorcycle::find($motorcycle);
            if(is_null($motorcycle)){
                return response()->json(['message'=> 'Motorcycle Not Found', 'status'=> 404], 404);
            }
            $motorcycle->update($request->all());

            Cache::tags('motorcycles')->flush();
            return response()->json([
                'success' => true,
                'data'=> new MotorcycleResource($motorcycle),
            ], 200);

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'status' => 500], 500);
        }
    }

    public function delete($motorcycle)
    {
        try {
            $motorcycle = Motorcycle::find($motorcycle);
            if(is_null($motorcycle)){
                return response()->json(['message'=> 'Motorcycle Not Found', 'status'=> 404], 404);
            }
            $motorcycle->delete();
            Cache::tags('motorcycles')->flush();
            return response()->json([
                'success' => true,
                'data'=> new MotorcycleResource($motorcycle),
            ], 200);

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'status' => 500], 500);
        }
    }

    public function restore($motorcycle)
    {
        try {
            $motorcycle = Motorcycle::onlyTrashed()->find($motorcycle);
            if(is_null($motorcycle)){
                return response()->json(['message'=> 'Motorcycle Not Found', 'status'=> 404], 404);
            }
            $motorcycle->restore();

            Cache::tags('motorcycles')->flush();
            return response()->json([
                'success' => true,
                'data'=> new MotorcycleResource($motorcycle),
            ], 200);

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'status' => 500], 500);
        }
    }

    public function destroy($motorcycle)
    {
        try {
            $motorcycle = Motorcycle::onlyTrashed()->find($motorcycle);
            if(is_null($motorcycle)){
                return response()->json(['message'=> 'Motorcycle Not Found', 'status'=> 404], 404);
            }
            $motorcycle->forceDelete();

            Cache::tags('motorcycles')->flush();
            return response()->json([
                'success' => true,
                'data'=> new MotorcycleResource($motorcycle),
            ], 200);

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'status' => 500], 500);
        }
    }


}
