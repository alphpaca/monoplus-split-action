<?php

declare(strict_types=1);

namespace Alphpaca\MonoplusSplit;

final class Ssh
{
    public static function new(ShellInterface $shell): self
    {
        return new self($shell);
    }

    public function __construct(
        private readonly ShellInterface $shell
    ) { }

    public function setup(): void
    {
        $this->shell->exec(sprintf('mkdir -p %s/.ssh', Shell::HOME_DIR));
    }

    public function addToKnownHosts(string $host): void
    {
        $this->shell->exec(sprintf('ssh-keyscan %s >> %s/.ssh/known_hosts', $host, Shell::HOME_DIR));
    }

    public function addPrivateKey(string $privateKey): void
    {
        $this->shell->exec(sprintf('echo "%s" > %s/.ssh/id_rsa', $privateKey, Shell::HOME_DIR));
        $this->shell->exec(sprintf('chmod 600 %s/.ssh/id_rsa', Shell::HOME_DIR));
    }
}
