<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Banner\BannerRequest;
use App\Http\Requests\Upload\AttachmentRequest;
use App\Http\Requests\Upload\UploadRequest;
use App\Http\Resources\Backend\MediaResource;
use App\Models\Media;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    //
    /**
     * Display the user's profile form.
     */
    public function attachment(Request $request)
    {
        try{
            $post = $request->post();


            $user = auth()->guard('web')->user();
            $res = apiPostUpload('/ticket/uploadAttachment?authToken='. $user->authtoken,'attachmentFile', $request->file('file') );
            if( $res ){
                Cache::tags('ticket')->flush();
                $return['status']  = true;
                $return['message'] = 'berhasil';
                $return['data']    = $res;

                return response()->json($return);
            }else{
                Cache::tags('ticket')->flush();
                $return['status']  = false;
                $return['message'] = 'gagal';
                $return['data']    = $res;

                return response()->json($return, 400);

            }

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
    public function upload(UploadRequest $request)
    {
        $post = $request->post();

        $user = auth()->user();
        $res = apiPostUpload('ticket/uploadImage?authToken='. $user->authtoken,'imageFile',  $request->file('file'));
        if( $res ){
            Cache::tags('ticket')->flush();
            $return['status']  = true;
            $return['message'] = 'berhasil';
            $return['data']    = $res;

            return response()->json($return);
        }else{
            Cache::tags('ticket')->flush();
            $return['status']  = false;
            $return['message'] = 'gagal';
            $return['data']    = $res;

            return response()->json($return, 400);

        }
        try{

        } catch (\Throwable $th) {

            $response = [
                'success' => false,
                'message' => 'mohon tunggu sebentar sedang ada maintenance',
                'error' => $th->getMessage(),
                'data'    => null,
            ];
            return response()->json($response, 400);
        }
    }
     /**
     * Display the user's profile form.
     */
    public function banner(Request $request)
    {
        try{
            $date = Carbon::now()->format('dmY-his');

            $folder = Str::snake($request->folder);
            $image = $request->file('file');
            $uploads = uploadLocal($image, $folder);
            if($uploads['status']==true){
                return response()->json(new MediaResource($uploads['data']));
            }else{
                return response()->json(false,400);
            }

        } catch (\Throwable $th) {

            $response = [
                'success' => false,
                'message' => 'mohon tunggu sebentar sedang ada maintenance',
                'data'    => null,
            ];
            return response()->json($response, 400);
        }
    }
    public function destroy(Media $media)
    {
        Storage::disk('local')->delete('uploads/'.$media->url);
        $media->forceDelete();
        Cache::tags(['medias'])->flush();
        return response()->json(true,200);
    }
}
