<?php
namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class ResourceController extends BaseController
{
    /**
     * Implement resources.index
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Listing...
        $data = [
            ['id' => 1, 'name' => 'one'],
            ['id' => 2, 'name' => 'two'],
        ];

        return new \Illuminate\Http\JsonResponse($data);
    }

    /**
     * Implement resources.store
     *
     * @param \Illuminate\Http\Request $request Request sent
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(\Illuminate\Http\Request $request)
    {
        $data = $request->input();

        // Pre-Cond: Assert request has create data
        assert(!empty($data));

        // Creating...
        $created = isset($data['name']);

        // Location of created resource
        $headers = ['location' => route('resources.show', ['resource' => 4])];

        return new \Illuminate\Http\JsonResponse(['created' => $created], 201, $headers);
    }

    /**
     * Implement resources.show
     *
     * @param int $resource Resource Id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($resource)
    {
        // Pre-Cond: Assert request has a resource id
        assert($resource > 0);

        // Retrieving...
        $data = ['id' => (int)$resource, 'name' => 'three'];

        return new \Illuminate\Http\JsonResponse($data);
    }

    /**
     * Implement resources.replace
     *
     * @param \Illuminate\Http\Request $request  Request object
     * @param int                      $resource Resource id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function replace(\Illuminate\Http\Request $request, $resource)
    {
        $data = $request->input();

        // Pre-Cond: Assert request has a resource id
        assert($resource > 0);

        // Replacing...
        $doReplace = isset($data['name']);

        return new \Illuminate\Http\JsonResponse(['replaced' => $doReplace], 200);
    }

    /**
     * Implement resources.update
     *
     * @param \Illuminate\Http\Request $request  Request object
     * @param int                      $resource Resource id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(\Illuminate\Http\Request $request, $resource)
    {
        $replace = $request->input('replace');
        $test = $request->input('test');

        // Pre-Cond: Assert request has a resource id
        assert($resource > 0);

        // Patching..
        $patched = ($test['id'] == $resource) && isset($replace['name']);

        return new \Illuminate\Http\JsonResponse(['patched' => $patched]);
    }

    /**
     * Implement resources.destroy
     *
     * @param int $resource Resource id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($resource)
    {
        // Pre-Cond: Assert request has a resource id
        assert($resource > 0);

        //Deleting...
        $deleted = !empty($resource);

        return new \Illuminate\Http\JsonResponse(['deleted' => $deleted]);
    }

    /**
     * Implement resources.options
     *
     * @return \Illuminate\Http\Response
     */
    public function options()
    {
        $headers = ['allow' => implode(',', ['GET', 'POST', 'PATCH', 'DELETE', 'OPTIONS'])];

        return  new \Illuminate\Http\Response(null, 200, $headers);
    }
}
