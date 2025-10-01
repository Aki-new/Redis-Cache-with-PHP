<?php

    include_once '../src/RedisCache.php';

    $cache = new redisCache();

    try {
        $redis = $cache->connect();
        echo "Connected to Redis server successfully.<br>";

        // Set a key-value pair
        $cache->set("example_key", ["name" => "John", "age" => 30], 600);
        echo "Key 'example_key' set successfully.<br>";

        // Retrieve the value
        $value = $redis->get("example_key");
        echo "Retrieved value: " . $value . "<br>";

    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "<br>";
    }