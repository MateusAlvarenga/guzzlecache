<?php
require __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Client;
use Sarahman\SimpleCache\FileSystemCache;

class httpRequest
{

    private $cache;
    private $client;
    private $baseUrl;

    public function __construct($baseUrl)
    {
        $this->baseUrl = $baseUrl;
        $this->client = new Client();
        $this->cache = new FileSystemCache(__DIR__ . "/cache/");
    }


    public function get($url, $lifetime)
    {
        $cacheKey = str_replace('/', '', $url);

        if ($this->cache->has($cacheKey)) {
            $posts = json_decode($this->cache->get($cacheKey));
            echo "value cached ";
        } else {
            $response = $this->client->request('GET', $this->baseUrl . $url);
            $posts = json_decode($response->getBody()->getContents());
            $this->cache->set($cacheKey, json_encode($posts), $lifetime);
            echo "set cache ";
        }

        return $posts;
    }
}


$http = new httpRequest('http://localhost:3000');
$posts = $http->get('/posts/3', 30);
var_dump(json_encode($posts));
