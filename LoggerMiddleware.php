<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

final class LoggerMiddleware
{

  private $startTime;

  /**
  * Handle an incoming request.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \Closure  $next
  * @return mixed
  */

  public function handle($request, Closure $next)
  {
    $this->startTime = microtime(true);
    return $next($request);
  }

  public function terminate($request, $response)
  {
    $endTime = microtime(true);
    $dataToLog  = 'Time: ' . gmdate("F j, Y, g:i a") . "\n";
    $dataToLog .= 'Duration: ' . number_format($endTime - LARAVEL_START, 3) . "\n";

    $dataToLog .= 'IP Address: ' . $request->ip() . "\n";
    $dataToLog .= 'URL: ' . $request->fullUrl() . "\n";
    $dataToLog .= 'Method: ' . $request->method() . "\n";
    $dataToLog .= 'Input: '  . $request->getContent() . "\n";
    $dataToLog .= 'Output: ' . $response->getContent() . "\n";
    Log::debug("\n\n" . $dataToLog);
  }

}
