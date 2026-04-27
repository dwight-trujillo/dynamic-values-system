<?php
declare(strict_types=1);

namespace DynamicValues\Core;

interface DataSourceInterface
{
    public function getKey(): string;
    public function getName(): string;
    public function getValue(): mixed;
    public function getMetadata(): array;
    public function validate(mixed $value): bool;
    public function getTUL(): int;
}
