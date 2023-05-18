<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\VechileRequest;
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
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        try {
            $vechiles = VechileRepository::paginate((int)request('limit') ?? 12);
            $pagination = [
                'total' => $vechiles->total(),
                'count' => $vechiles->count(),
                'per_page' => $vechiles->perPage(),
                'current_page' => $vechiles->currentPage(),
                'total_pages' => $vechiles->lastPage()
            ];
            return response()->json(['data' => VechileResource::collection($vechiles), 'pagination' => $pagination],200);

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'status' => 500], 500);
        }
    }


    public function show($id)
    {

        try {
            $vechile = VechileRepository::find($id);
            if(is_null($vechile)){
                return response()->json(['message'=> 'Vechile Not Found', 'status'=> 404], 404);
            }
            return response()->json(new VechileResource($vechile), 200);

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'status' => 500], 500);
        }
    }

    public function store(VechileRequest $request)
    {
        try {
            $vechile = Vechile::create($request->all());
            Cache::tags('vechiles')->flush();
            return response()->json([
                'success' => true,
                'data'=> new VechileResource($vechile),
            ], 200);

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'status' => 500], 500);
        }
    }

    public function update($vechile, VechileRequest $request)
    {
        try {
            $vechile = VechileRepository::find($vechile);
            if(is_null($vechile)){
                return response()->json(['message'=> 'Vechile Not Found', 'status'=> 404], 404);
            }
            $vechile->update($request->all());

            Cache::tags('vechiles')->flush();
            return response()->json([
                'success' => true,
                'data'=> new VechileResource($vechile),
            ], 200);

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'status' => 500], 500);
        }
    }

    public function delete($vechile)
    {
        try {
            $vechile = Vechile::find($vechile);
            if(is_null($vechile)){
                return response()->json(['message'=> 'Vechile Not Found', 'status'=> 404], 404);
            }
            $vechile->delete();
            Cache::tags('vechiles')->flush();
            return response()->json([
                'success' => true,
                'data'=> new VechileResource($vechile),
            ], 200);

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'status' => 500], 500);
        }
    }

    public function restore($vechile)
    {
        try {
            $vechile = Vechile::onlyTrashed()->find($vechile);
            if(is_null($vechile)){
                return response()->json(['message'=> 'Vechile Not Found', 'status'=> 404], 404);
            }
            $vechile->restore();

            Cache::tags('vechiles')->flush();
            return response()->json([
                'success' => true,
                'data'=> new VechileResource($vechile),
            ], 200);

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'status' => 500], 500);
        }
    }

    public function destroy($vechile)
    {
        try {
            $vechile = Vechile::onlyTrashed()->find($vechile);
            if(is_null($vechile)){
                return response()->json(['message'=> 'Vechile Not Found', 'status'=> 404], 404);
            }
            $vechile->forceDelete();

            Cache::tags('vechiles')->flush();
            return response()->json([
                'success' => true,
                'data'=> new VechileResource($vechile),
            ], 200);

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'status' => 500], 500);
        }
    }


}
