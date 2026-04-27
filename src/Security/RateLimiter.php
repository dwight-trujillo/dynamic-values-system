<?php
declare(strict_types=1);

namespace DynamicValues\Security;

use DynamicValues\Contracts\CacheInterface;

final class RateLimiter
{
    private CacheInterface $cache;
    private int $maxRequests;
    private int $windowSeconds;

    public function __construct(CacheInterface $cache, int $maxRequests = 100, int $windowSeconds = 60)
    {
        $this->cache = $cache;
        $this->maxRequests = $maxRequests;
        $this->windowSeconds = $windowSeconds;
    }

    public function checkLimit(string $identifier): bool
    {
        $key = "ratelimit:" . $identifier;
        $current = $this->cache->get($key) ?? 0;
        
        if ($current >= $this->maxRequests) {
            return false;
        }
        
        $this->cache->set($key, $current + 1, $this->windowSeconds);
        return true;
    }
}
