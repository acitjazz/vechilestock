<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class StatistikController extends Controller
{
    //
    /**
     * Display the user's profile form.
     */
    public function all(Request $request)
    {
        try{
            $post = $request->post();
            Cache::tags('ticket')->flush();
            $return['status']  = true;
            $return['message'] = 'berhasil';
            $return['data']    = [];
        
            return response()->json($return);
           
        } catch (\Throwable $th) {

            $response = [
                'success' => false,
                'message' => 'mohon tunggu sebentar sedang ada maintenance',
                'data'    => null,
            ];
            return response()->json($response, 400);
        }
    }
     /**
     * Display the user's profile form.
     */
    public function billingpayment(Request $request)
    {
        try{
            $post = $request->post();
            Cache::tags('ticket')->flush();
            $user = auth()->user();
            $return['status']  = true;
            $return['message'] = 'berhasil';
            $return['data']    = $user;
        
            return response()->json($return);
           
        } catch (\Throwable $th) {

            $response = [
                'success' => false,
                'message' => 'mohon tunggu sebentar sedang ada maintenance',
                'data'    => null,
            ];
            return response()->json($response, 400);
        }
    }
     /**
     * Display the user's profile form.
     */
    public function service(Request $request)
    {
        try{
            $post = $request->post();
            Cache::tags('ticket')->flush();
            $user = auth()->user();
            $return['status']  = true;
            $return['message'] = 'berhasil';
            $return['data']    = $user;
        
            return response()->json($return);
           
        } catch (\Throwable $th) {

            $response = [
                'success' => false,
                'message' => 'mohon tunggu sebentar sedang ada maintenance',
                'data'    => null,
            ];
            return response()->json($response, 400);
        }
    }
     /**
     * Display the user's profile form.
     */
    public function ticket(Request $request)
    {
        try{
            $post = $request->post();
            Cache::tags('ticket')->flush();
            $user = auth()->user();
            $return['status']  = true;
            $return['message'] = 'berhasil';
            $return['data']    = $user;
        
            return response()->json($return);
           
        } catch (\Throwable $th) {

            $response = [
                'success' => false,
                'message' => 'mohon tunggu sebentar sedang ada maintenance',
                'data'    => null,
            ];
            return response()->json($response, 400);
        }
    }
}
