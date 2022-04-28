<?php
require __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Kevinrob\GuzzleCache\CacheMiddleware;
use Doctrine\Common\Cache\FilesystemCache;
use Kevinrob\GuzzleCache\Strategy\PrivateCacheStrategy;
use Kevinrob\GuzzleCache\Storage\DoctrineCacheStorage;

$stack = HandlerStack::create();
$stack->push(
    new CacheMiddleware(
        new PrivateCacheStrategy(
            new DoctrineCacheStorage(
                new FilesystemCache('/cache/')
            )
        )
    ),
    'cache'
);

$client = new Client(['handler' => $stack]);

$res = $client->request('GET', 'http://localhost:3000/posts');
echo $res->getBody()->getContents();
