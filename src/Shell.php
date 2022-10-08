<?php

declare(strict_types=1);

namespace Alphpaca\MonoplusSplit;

final class Shell implements ShellInterface
{
    public const HOME_DIR = '/root';

    public const GITHUB_WORKSPACE_DIR = '/github/workspace';

    public static function new(): self
    {
        return new self();
    }

    public function exec(string $command): false|string
    {
        return exec($command);
    }
}
