<?php

declare(strict_types=1);

namespace Alphpaca\MonoplusSplit;

interface ShellInterface
{
    public function exec(string $command): false|string;
}
