<?php

namespace App\Http\Controllers\Api\v1;

use App\Events\NotifEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReportRequest;
use App\Models\Report;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    //
    public function sendNotifGetReport()
    {
        $periode = request('periode');
        $from = request('from');
        $to = request('to');
        $message = [
            'type' => 'ambilLaporan',
            'tgl' => date('Y-m-d H:i:s'),
            'model' => date('YmdHis'),
            'content' => [
                'from' => $from,
                'to' => $to,
                'periode' => $periode,
            ]
        ];
        // $message = 'coba';
        event(new NotifEvent($message));
        // event(new NotifEvent(['message' => $message]));
        return new JsonResponse([
            'message' => 'notif dikirimkan',
            'data' => $message,
            'req' => request()->all()
        ]);
    }
    public function storeReport(Request $request)
    {
        // $notif = Report::create($request->validated());
        // return new JsonResponse($request->all());
        $data = Report::updateOrCreate(
            [
                'kodecabang' => $request->kodecabang,
                'norequest' => $request->norequest,
            ],
            [
                'tgl' => $request->tgl,
                'laporan' => $request->laporan,
            ],
        );
        $message = [
            'hit' => 'adaLaporan'
        ];
        event(new NotifEvent($message));
        return new JsonResponse([
            'data' => $data,
            'message' => 'Data laporan sudah di simpan',
        ]);
    }
    public function getSavedReport()
    {

        $ada = Report::where('tgl', 'LIKE', '%' . request('q') . '%')
            ->groupBy('norequest')
            ->limit(10)
            ->orderBy('id', 'DESC')
            ->pluck('norequest');

        $data = Report::with('cabang:kodecabang,namacabang')->whereIn('norequest', $ada)->orderBy('id', 'DESC')->get();

        return new JsonResponse($data);
    }
}
