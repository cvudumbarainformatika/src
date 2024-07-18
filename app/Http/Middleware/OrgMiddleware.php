<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OrgMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $xid = 'org';
        $xtimestamp = time();
        $secret_key = 'd4l4m';

        if (!$this->hasCorrectSignature($request) ) {
            return response()->json(['status' => 'signature is Invalid', 'message'=> 'Unauthorized.'], 401);
        }
        if ($request->header('X-id') !== $xid || !$request->headers->has('X-id')) {
            return response()->json(['status' => 'Token is Invalid', 'message'=> 'Unauthorized.'], 401);
        }
        

        return $next($request);
    }

    public function hasCorrectSignature($request)
    {
      $xid = 'org';
      $secret_key = 'd4l4m';
      
      $signature = hash_hmac('sha256', $xid, $secret_key);

      return hash_equals($signature, (string) $request->header('X-signature'));
    }

    public function getSignature()
    {
      $xid = 'org';
      $secret_key = 'd4l4m';

      $signature = hash_hmac('sha256', $xid, $secret_key);
      return $signature;
    }
}
