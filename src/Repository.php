<?php

declare(strict_types=1);

namespace Alphpaca\MonoplusSplit;

final class Repository
{
    public static function new(ShellInterface $shell): self
    {
        return new self($shell);
    }

    public function __construct(
        private readonly ShellInterface $shell,
    ) { }

    public function addRemote(string $remoteName, string $remoteUrl): void
    {
        $this->shell->exec(sprintf('git remote add %s %s', $remoteName, $remoteUrl));
    }

    public function removeRemote(string $remoteName): void
    {
        $this->shell->exec(sprintf('git remote remove %s', $remoteName));
    }

    public function filterPackage(string $packageName): void
    {
        $this->shell->exec(sprintf('git filter-repo --subdirectory-filter %s --force', $packageName));
    }

    public function push(string $remoteName, string $targetBranch): void
    {
        $this->shell->exec(sprintf('git push %s %s:%s --force', $remoteName, $this->getCurrentBranchName(), $targetBranch));
    }

    public function addTag(string $tagName): void
    {
        $this->shell->exec(sprintf('git tag %s', $tagName));
    }

    public function removeAllTags(): void
    {
        $this->shell->exec('git tag -d $(git tag -l)');
    }

    public function pushTag(string $remoteName, string $tagName): void
    {
        $this->shell->exec(sprintf('git push %s %s', $remoteName, $tagName));
    }

    private function getCurrentBranchName(): string
    {
        return $this->shell->exec('git branch --show-current');
    }
}
