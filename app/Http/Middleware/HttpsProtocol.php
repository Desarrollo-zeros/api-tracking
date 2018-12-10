<?php
/**
 * Created by PhpStorm.
 * User: carlo
 * Date: 10/12/2018
 * Time: 9:55 AM
 */
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class HttpsProtocol {

    public function handle($request, Closure $next)
    {

        if (!$request->secure() && env('APP_ENV') === 'production' || env('APP_ENV') === 'dev') {
            return redirect()->secure($request->getRequestUri());
        }
        return $next($request);
    }
}
