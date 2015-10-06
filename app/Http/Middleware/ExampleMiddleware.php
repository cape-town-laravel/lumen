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
        /**
         * Before
         */
        if ($request->has('foo')) {
            $beforeResponse = response($request->get('foo'));
        }

        /**
         * Process
         */
        $response = isset($beforeResponse) ? $beforeResponse : $next($request);

        /**
         * After
         */
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
