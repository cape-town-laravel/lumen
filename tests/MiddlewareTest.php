<?php

class MiddlewareTest extends \TestCase
{
    public function testExampleFilter()
    {
        /**
         * No filter
         */
        $this->visit('/example')
            ->seeStatusCode(200)
            ->see("NoFilter");

        /**
         * Filter Active
         */
        $this->visit('/example?foo=BeforeFilter')
            ->see("BeforeFilter");
    }

    public function testExampleAfterProcessor()
    {
        /**
         * ETag
         */
        $responseNoEtag = $this->call('GET', '/example');
        $this->seeStatusCode(200);

        // Get ETag (MD5 of the response content)
        $server = ['HTTP_IF_NONE_MATCH' => $responseNoEtag->getEtag()];

        $responseWithEtag = $this->call('GET', '/example', [], [], [], $server);
        $this->seeStatusCode(304);

    }
}