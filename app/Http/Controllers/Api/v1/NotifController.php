<?php

namespace App\Http\Controllers\Api\v1;

use App\Events\NotifEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\NotifRequest;
use App\Models\Notif;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotifController extends Controller
{
    /**
     * post notif
     */

    public function storeNotif(NotifRequest $request)
    {
      $notif = Notif::create($request->validated());
      if ($notif) {
        
        event(new NotifEvent($notif));

        return response()->json(
          ['status'=>'success',
          'message' => 'Data tersimpan'], 200);
      } else {
          return response()->json(
              ['status'=>'failed',
              'message' => 'Save Data failed'], 500);
      }
    }

    public function getNotif(Request $request)
    {
       $data = Notif::where('is_read', 0)
       ->where('receiver', $request->receiver) 
       ->get();

       return new JsonResponse($data, 200);
    }

    public function updateNotif(Request $request)
    {
       $notif = Notif::where('id', $request->id)->first();
       if (!$notif) {
        return response()->json(
          ['status'=>'failed',
          'message' => 'Data tidak ditemukan'], 500);
       }

       $notif->is_read = 1;
       $notif->save();

      //  event(new NotifEvent($notif));
       return new JsonResponse(['status'=>'success',
       'message' => 'Data berhasil diupdate', 'id'=> $notif->id], 200);
    }
    
}
