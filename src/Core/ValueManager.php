<?php
declare(strict_types=1);

namespace DynamicValues\Core;

use DynamicValues\Contracts\CacheInterface;

final class ValueManager
{
    private CacheInterface $cache;
    private array $sources = [];
    private array $metrics = ['hits' => 0, 'misses' => 0];

    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    public function registerSource(DataSourceInterface $source): void
    {
        $this->sources[$source->getKey()] = $source;
    }

    public function getValue(string $key): mixed
    {
        if (!isset($this->sources[$key])) {
            throw new \RuntimeException("DataSource not found");
        }

        $cacheKey = "dv:" . $key;
        $cached = $this->cache->get($cacheKey);
        
        if ($cached !== null) {
            $this->metrics['hits']++;
            return $cached;
        }

        $this->metrics['misses']++;
        $value = $this->sources[$key]->getValue();
        $ttl = $this->sources[$key]->getTTL();
        if ($ttl > 0) {
            $this->cache->set($cacheKey, $value, $ttl);
        }
        
        return $value;
    }

    public function getAllValues(): array
    {
        $result = [];
        foreach (array_keys($this->sources) as $key) {
            $result[$key] = $this->getValue($key);
        }
        return $result;
    }
}
