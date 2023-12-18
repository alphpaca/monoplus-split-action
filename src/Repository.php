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

    public function removeExtraHeader(string $url): void
    {
        $this->shell->exec(sprintf('git config --local --unset-all http.%s.extraheader', $url));
    }

    public function filterPackage(string $packagePath, string $branchName): void
    {
        if ('' === $this->shell->exec('git tag -l')) {
            $this->shell->exec(sprintf('pipx run -- git-filter-repo --subdirectory-filter %s --force --no-ff', $packagePath));
            return;
        }

        $this->shell->exec(
            sprintf(
                'pipx run -- git-filter-repo --subdirectory-filter %s --refs %s $(git tag -l) --force --no-ff',
                $packagePath,
                $branchName
            )
        );
    }

    public function push(string $remoteName, string $currentBranchName, string $targetBranch): void
    {
        $this->shell->exec(sprintf('git push %s %s:%s --tags --force', $remoteName, $currentBranchName, $targetBranch));
    }
}
