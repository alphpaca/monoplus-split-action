<?php

declare(strict_types=1);

namespace Alphpaca\MonoplusSplit;

final class Git
{
    public static function new(ShellInterface $shell): self
    {
        return new self($shell);
    }

    public function __construct(
        private readonly ShellInterface $shell
    ) { }

    public function setup(string $username, string $email): void
    {
        $this->shell->exec(sprintf('git config --global user.name "%s"', $username));
        $this->shell->exec(sprintf('git config --global user.email "%s"', $email));
        $this->shell->exec('git config --global --add safe.directory /github/workspace');
    }
}
