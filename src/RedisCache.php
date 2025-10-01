<?php
    class redisCache{
        private $port;
        private $host;
        private $redis;

        private function checkConection(){
            if (!$this->redis) {
                throw new Exception("Redis not connected.");
            }
        
            try {
                $response = $this->redis->ping();
            } catch (Exception $e) {
                throw new Exception("Redis not responding: " . $e->getMessage());
            }
        
            return true;
        }

        private function checkKey($key){
            try {
                if ($this->checkConection()) {
                    return $this->redis->exists($key);
                }
            } catch (Exception $e) {
                throw new Exception("Redis key check error: " . $e->getMessage());
            }
        }

        public function __construct($port = 6379,$host = '127.0.0.1'){
            $this->port = $port;
            $this->host = $host;
        }

        public function connect(){
            $this->redis = new Redis();
            try {
                $this->redis->connect($this->host, $this->port);
                return $this->redis;
            } catch (Exception $e) {
                throw new Exception("Redis connection error: " . $e->getMessage());
            }
        }


        public function set($key, $value, $expiration = 3600){

            try {
                if ($this->checkConection()){

                    if (is_array($value) or is_object($value)) {
                        $value = json_encode($value);
                    }

                    $this->redis->set($key, $value, $expiration);

                    return true;
                } else {
                    throw new Exception ("Cannot set key, Redis not connected.");
                }
            } catch (Exception $e) {
                throw new Exception("Redis set error: " . $e->getMessage());
            }
        }

        public function get($key){
            try {
                $this->checkConection();
            
                if (!$this->checkKey($key)) {
                    throw new Exception("Key '$key' does not exist.");
                }
            
                $value = $this->redis->get($key);
                $json = json_decode($value, true);
            
                if (json_last_error() === JSON_ERROR_NONE) {
                    return $json;
                } else {
                    return $value;
                }
            
            } catch (Exception $e) {
                throw new Exception("Redis get error: " . $e->getMessage());
            }
        }

    }
?>