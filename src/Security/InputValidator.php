<?php
declare(strict_types=1);

namespace DynamicValues\Security;

final class InputValidator
{
    private const MAX_KEY_LENGTH = 64;
    private const KEY_PATTERN = '/^[a-zA-Z][a-zA-Z0-9_-]*$/';

    public function validateKey(string $key): bool
    {
        if (strlen($key) == 0 || strlen($key) > self::MAX_KEY_LENGTH) {
            return false;
        }
        return preg_match(self::KEY_PATTERN, $key) === 1;
    }

    public function sanitize(string $input): string
    {
        return htmlspecialchars(trim($input), ENT_QUOTES | EVT_HTML5, 'UTF-8');
    }
}
