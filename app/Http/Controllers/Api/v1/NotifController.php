<?php

namespace App\Http\Controllers\Api\v1;

use App\Events\NotifEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\NotifRequest;
use App\Models\Notif;
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
        
        event(new NotifEvent('coba'));

        return response()->json(
          ['status'=>'success',
          'message' => 'Data tersimpan'], 200);
      } else {
          return response()->json(
              ['status'=>'failed',
              'message' => 'Registration failed'], 500);
      }
    }
    
}
