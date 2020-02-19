<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RESTControllerTest extends WebTestCase
{
    public function testEncode()
    {
        $client = static::createClient();

        $validRequests = [
            'https://gurgen.com',
            'http://google.com/q?asdahsdgahgd',
            'http://upwork.com/test',
            'http://spotify.com/?song=lalala',
            'http://youtube.com?v=asdsdsds'
        ];

        $inValidRequests = [
            '',
            'aaaaaaaa',
            'asd3------___asd.com.234234234',
            'google.com',
            '<><><><><" >"<>>',
            '"; DROP database Users"'
        ];

        foreach ($validRequests as $validRequest) {
            $client->request('POST', '/encode', [
                'url' => $validRequest,
            ]);
            $this->assertEquals(200, $client->getResponse()->getStatusCode());
        }

        foreach ($inValidRequests as $inValidRequest) {
            $client->request('POST', '/encode', [
                'url' => $inValidRequest,
            ]);
            $this->assertEquals(400, $client->getResponse()->getStatusCode());
        }

    }

    public function testDecode()
    {
        $client = static::createClient();

        $urls = [
            'http://heisenberg.com/I%20am%20the%20one%20who%20knocks',
            'https://test1.com',
            'https://test2.com',
            'https://test3.com',
            'https://test4.com'
        ];

        foreach ($urls as $url) {
            $client->request('POST', '/encode', [
                'url' => $url,
            ]);

            $shortUrl = json_decode($client->getResponse()->getContent())->message;

            $client->request('POST', '/decode', [
                'url' => $shortUrl,
            ]);
            $this->assertEquals($url, json_decode($client->getResponse()->getContent())->message);

        }

    }
}