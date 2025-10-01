# RedisCache – PHP Cache System with Redis
## Overview
This system provides a PHP class called `redisCache` that allows you to interact with Redis in a simple and secure way. Its main purpose is to offer a reusable cache layer that speeds up access to temporary data, such as API responses, configurations, or computational results.
Avoid repeated calls to external services or unnecessary calculations by storing data in temporary memory. This improves the performance of wdeb applications, reduces the load on external servers, and allows for a smoother experience for the end user.

This system is designed to be integrated as a backend component into any PHP application. In particular, it is being used as part of a **web application** I am developing.
Redis allows you to save those responses for a specified time, avoiding duplicate queries and speeding up the delivery of results.

### What technologies does it use?

1. `Pure PHP`: Language in which the system is written
2. `Redis`: `No-SQL` database engine
3. `Phpredis`: Official Redis extension for PHP

### Quick Start Guide:
+ Have `Redis` installed and running on your machine or server.
+ Have the `Redis` extension enabled in `PHP` `(phpredis)`.
+ `PHP` 7.4 or higher recommended.

**Instantiate the class**\
`$cache = new redisCache($port, $host);`
The `$port` and `$host` parameters are optional. If they are not passed to the function, the default values ​​will be `$port = 6379` and `$host = ‘127.0.0.1’`.

**Connect to the Redis server**\
`$cache->connect();`

**Save data**\
`$cache->set($key, $value, $seconds);`\
Examples

`$cache->set(‘task’, ‘PHP Programming’, 600);`
If `$value` is an object or an array, this function converts and saves `$value` to `.json` format.
```
$array = ['name' => 'Mike', 'age' => 20, 'country' => 'England'];
$cache->set('data', $array, 600);
```
If you try `$cache->set('task', 'Programming in PHP', 0);`, Redis will accept the request but will not apply an expiration. It is recommended to use values ​​greater than `0`.

**Retrieving data**

`$cache->get($key);`

Example

```
$cache->get('task');
$cache->get('data');
```
If the stored value was an object or array, the method will return it as an associative array.

All methods throw exceptions; use try/catch to handle them.
```
try {
$cache->connect();
$cache->set('task', 'PHP Programming', 600);
$data = $cache->get('task');
} catch (Exception $e) {
echo "Error: " . $e->getMessage();
}
```

### Technical Documentation

**Class Structure**

**Public Attributes**

- There are no public attributes in this class.

**Protected Attributes**

- There are no protected attributes in this class.

**Private Attributes**
1. `$host`
- Type: String
- Description: IP address of the Redis server
2. `$port`
- Type: Int
- Description: Connection port
3. `$redis`
- Type: Redis
- Description: Redis client instance (phpredis)

#### **Public Methods**

`__construct($port = 6379, $host = '127.0.0.1')`
Initializes the class with the connection parameters. If not specified, the default values ​​are used.

`connect()`
Establishes the connection to the Redis server.\
Exceptions:
- Throws an exception if the connection fails.

`set($key, $value, $expiration = 3600)`
Stores a value in Redis with a key and expiration time. If the value is an array or object, it is automatically converted to JSON.\
Exceptions:
- Exception if Redis is not connected
- The operation failed.
Returns true if the save was successful

`get($key)`
Retrieves the value associated with a key. If the value is valid .JSON, it is decoded as an associative array if the value was originally an object or array.\
Exceptions:\
• Exception if Redis is not connected.
• Exception if the key does not exist.
• Exception if an error occurs while retrieving the value.

#### **Private Methods**

`checkConnection()`
Checks if Redis is connected and responds to the ping.

Exceptions:
- Exception if there is no connection
- The ping fails.
Returns true if everything works correctly

`checkKey($key)`
Checks if a key exists in Redis.

Exceptions:
- Exception if an error occurs while querying the key.
Returns true if the key exists.

This project will be part of larger projects I'll be working on and likely publishing.
If you have ideas, suggestions, or find opportunities for improvement, I'd love to hear about them.

I'm open to technical feedback, feature proposals, or fixes that will help strengthen this system.


You can read more about my vision for this project, future plans, and how you can contribute in the CONTRIBUTING.md file.
