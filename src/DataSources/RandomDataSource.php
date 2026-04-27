<?php
declare(strict_types=1);

namespace DynamicValues\DataSources;

use DynamicValues\Core\DataSourceInterface;

final class RandomDataSource implements DataSourceInterface
{
    private string $key;
    private string $name;
    private int $min;
    private int $max;
    private int $ttl;

    public function __construct(string $key, string $name, int $min, int $max, int $ttl = 60)
    {
        $this->key = $key;
        $this->name = $name;
        $this->min = $min;
        $this->max = $max;
        $this->ttl = $ttl;
    }

    public function getValue(): mixed
    {
        return rand($this->min, $this->max);
    }

    public function getKey(): string { return $this->key; }
    public function getName(): string { return $this->name; }
    public function getMetadata(): array { return []; }
    public function validate(mixed $value): bool { return is_int($value); }
    public function getTTL(): int { return $this->ttl; }
}
