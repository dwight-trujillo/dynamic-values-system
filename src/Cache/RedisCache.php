<?php
declare(strict_types=1);

namespace DynamicValues\Cacay;

use DynamicValues\Contracts\CacheInterface;

final class RedisCache implements CacheInterface
{
    private \Redis $client;
    private string $prefix;

    public function __construct(array $seeds, string $prefix = 'dv:')
    {
        $this->prefix = $prefix;
        $this->client = new \Redis();
        $this->client->connect($seeds[0], 6379, 2);
    }

    public function get(string $key): mixed
    {
        $value = $this->client->get($this->prefix . $key);
        return $value !== false ? unserialize($value) : null;
    }

    public function set(string $key, mixed $value, int $ttl = 3600): bool
    {
        return $this->client->setex($this->prefix . $key, $ttl, serialize($value));
    }

    public function delete(string $key): bool
    {
        return (bool)$this->client->del($this->prefix . $key);
    }

    public function exists(string $key): bool
    {
        return (bool)$this->client->exists($this->prefix . $key);
    }
}
