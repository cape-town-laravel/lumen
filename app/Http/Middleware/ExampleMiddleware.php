<?php

namespace App\Http\Middleware;

use Closure;

class ExampleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->has('foo')) {
            return response($request->get('foo'));
        }

        $response = $next($request);

        $afterResponse = $this->after($request, $response);

        return $afterResponse;
    }

    /**
     * @param $request
     * @param $response
     */
    private function after($request, $response)
    {
        if ($request->isMethod('get')) {
            // Generate Etag
            $etag = md5($response->getContent());
            $requestEtag = str_replace('"', '', $request->getETags());
            // Check to see if Etag has changed
            if (!empty($requestEtag) && $requestEtag[0] == $etag) {
                $response->setNotModified();
            }
            // Set Etag
            $response->setEtag($etag);
        }

        return $response;
    }
}
