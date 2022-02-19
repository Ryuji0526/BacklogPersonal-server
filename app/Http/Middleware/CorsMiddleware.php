<?php

namespace App\Http\Middleware;

use Closure;

/**
 * @param $request
 * @param Closure $next
 * @return \Illuminate\Http\JsonResponse\mixed
 */
class CorsMiddleware
{
  public function handle($request, Closure $next)
  {
    $methods = implode(',', config('cors.allowed_methods'));
    $headers = implode(','. config('cors.allowed_headers'));

    $headers = [
      'Access-Control-Allow-Credentials' => 'true',
      'Access-Control-Allow-Origin' => env('ORIGIN_NAME', 'http://localhost:3000'),
      'Access-Control-Allow-Methods' => $methods,
      'Access-Control-Allow-Headers' => $headers,
    ];
    if ($request->getMethod() === "OPTIONS") {
      return response()->json('OK', 200, $headers);
    }
    $response = $next($request);
    foreach ($headers as $key => $value) {
      $response->header($key, $value);
    }
    return $response;
  }
}