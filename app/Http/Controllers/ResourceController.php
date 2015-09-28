<?php
namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class ResourceController extends BaseController
{
    /**
     * Implement resources.index
     *
     * @return \Laravel\Lumen\Http\ResponseFactory
     */
    public function index()
    {
        // Listing...
        $data = [
            ['id' => 1, 'name' => 'one'],
            ['id' => 2, 'name' => 'two'],
        ];

        return response()->json($data);
    }

    /**
     * Implement resources.store
     *
     * @param \Illuminate\Http\Request $request Request sent
     *
     * @return \Laravel\Lumen\Http\ResponseFactory
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

        return response()->json(['created' => $created], 201, $headers);
    }

    /**
     * Implement resources.show
     *
     * @param int $resource Resource Id
     *
     * @return \Laravel\Lumen\Http\ResponseFactory
     */
    public function show($resource)
    {
        // Pre-Cond: Assert request has a resource id
        assert($resource > 0);

        // Retrieving...
        $data = ['id' => (int)$resource, 'name' => 'three'];

        return response()->json($data);
    }

    /**
     * Implement resources.replace
     *
     * @param \Illuminate\Http\Request $request  Request object
     * @param int                      $resource Resource id
     *
     * @return \Laravel\Lumen\Http\ResponseFactory
     */
    public function replace(\Illuminate\Http\Request $request, $resource)
    {
        $data = $request->input();

        // Pre-Cond: Assert request has a resource id
        assert($resource > 0);

        // Replacing...
        $doReplace = isset($data['name']);

        return response()->json(['replaced' => $doReplace], 200);
    }

    /**
     * Implement resources.update
     *
     * @param \Illuminate\Http\Request $request  Request object
     * @param int                      $resource Resource id
     *
     * @return \Laravel\Lumen\Http\ResponseFactory
     */
    public function update(\Illuminate\Http\Request $request, $resource)
    {
        $replace = $request->input('replace');
        $test = $request->input('test');

        // Pre-Cond: Assert request has a resource id
        assert($resource > 0);

        // Patching..
        $patched = ($test['id'] == $resource) && isset($replace['name']);

        return response()->json(['patched' => $patched]);
    }

    /**
     * Implement resources.destroy
     *
     * @param int $resource Resource id
     *
     * @return \Laravel\Lumen\Http\ResponseFactory
     */
    public function destroy($resource)
    {
        // Pre-Cond: Assert request has a resource id
        assert($resource > 0);

        //Deleting...
        $deleted = !empty($resource);

        return response()->json(['deleted' => $deleted]);
    }

    /**
     * Implement resources.options
     *
     * @return \Laravel\Lumen\Http\ResponseFactory
     */
    public function options()
    {
        $headers = ['allow' => implode(',', ['GET', 'POST', 'PATCH', 'DELETE', 'OPTIONS'])];

        return response(null, 200, $headers);
    }
}
