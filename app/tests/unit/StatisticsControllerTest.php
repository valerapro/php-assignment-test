<?php

declare(strict_types=1);

namespace Tests\unit;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

/**
 * Class ATestTest
 *
 * @package Tests\unit
 */
class StatisticsControllerTest extends TestCase
{
    private Client|null $http;

    protected function setUp(): void
    {
        $this->http = new Client([
            'base_uri' => 'http://sm-assignment-app-web:80',
            'headers' => [
                'Accept' => 'application/json; charset=utf-8'
            ]]);
    }

    /**
     * @test
     */
    public function testSuccessIndexAction(): void
    {
        $requestUri = '/statistics?start_date=1682164521&end_date=1682164521';
        $response = $this->http->request("POST", $requestUri);

        $contentResponse = json_decode($response->getBody()->getContents(), true);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotNull($contentResponse['stats']['children'][0]['value'], 'average-character-length is NULL');
        $this->assertNotNull($contentResponse['stats']['children'][1]['value'], 'max-character-length is NULL');
        $this->assertIsArray($contentResponse['stats']['children'][2]['children'], 'total-posts-per-week is NULL');
        $this->assertIsArray($contentResponse['stats']['children'][3]['children'], 'average-posts-per-user is NULL');

    }

    public function tearDown(): void
    {
        $this->http = null;
    }
}
