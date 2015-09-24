<?php

class ResourceTest extends \TestCase
{
    public function testGetResourceIndex()
    {
        $expectedData = [
            ['id' => 1, 'name' => 'one'],
            ['id' => 2, 'name' => 'two'],
        ];

        $this->get('/resources')
            ->seeStatusCode(200)
            ->seeJsonEquals($expectedData);
    }

    public function testPostResourceStore()
    {
        $this->post('/resources', ['name' => 'four'])
            ->seeStatusCode(201)
            ->seeJsonEquals(['created' => true]);

        $expectedLocation = route('resources.show', ['resource' => 4]);
        $responseLocation = $this->response->headers->get('location');
        $this->assertEquals($expectedLocation, $responseLocation);
    }

    public function testGetResourceShow()
    {
        $expectedData = ['id' => 3, 'name' => 'three'];

        $this->get('/resources/3')
            ->seeStatusCode(200)
            ->seeJsonEquals($expectedData);
    }

    public function testPutResourceReplace()
    {
        $data = ['id' => 4, 'name' => 'four'];

        $this->put('/resources/4', $data)
            ->seeStatusCode(200)
            ->seeJsonEquals(['replaced' => true]);
    }

    public function testPatchResourceUpdate()
    {
        $data = ['test' => ['id' => 5], 'replace' => ['name' => 'five']];

        $this->patch('/resources/5', $data)
            ->seeStatusCode(200)
            ->seeJsonEquals(['patched' => true]);
    }

    public function testDeleteResourceDestory()
    {
        $this->delete('/resources/6')
            ->seeStatusCode(200)
            ->seeJsonEquals(['deleted' => true]);
    }

    public function testOptionsResourceOptions()
    {
        $this->call('OPTIONS', '/resources');
        $this->seeStatusCode(200);

        $expectedAccept = implode(',', ['GET', 'POST', 'PATCH', 'DELETE', 'OPTIONS']);

        $responseAccept = $this->response->headers->get('allow');
        $this->assertEquals($expectedAccept, $responseAccept);
    }
}
