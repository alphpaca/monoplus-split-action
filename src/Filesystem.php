<?php

declare(strict_types=1);

namespace Alphpaca\MonoplusSplit;

use Symfony\Component\Filesystem\Filesystem as BaseFilesystem;

class Filesystem extends BaseFilesystem
{
    public static function new(): self
    {
        return new self();
    }

    public function changeDir(string $path): void
    {
        chdir($path);
    }
}
