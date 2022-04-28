<?php
require __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Client;

$cache = new Sarahman\SimpleCache\FileSystemCache("./cache/");

$client = new Client();

if ($cache->has('posts')) {
    $posts = json_decode($cache->get('posts'));
} else {
    $response = $client->request('GET', 'http://localhost:3000/posts');
    $posts = json_decode($response->getBody()->getContents());
    $cache->set('posts', json_encode($posts), 90);
}

var_dump($posts);
