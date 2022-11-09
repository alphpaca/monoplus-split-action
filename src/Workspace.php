<?php

declare(strict_types=1);

namespace Alphpaca\MonoplusSplit;

final class Workspace
{
    public static function new(Filesystem $filesystem, string $workspaceId): self
    {
        $workspaceDir = sprintf('%s/%s', sys_get_temp_dir(), $workspaceId);

        $filesystem->mkdir($workspaceDir);

        return new self($filesystem, $workspaceId, $workspaceDir);
    }

    private function __construct(
        private readonly Filesystem $filesystem,
        public readonly string $workspaceId,
        public readonly string $path,
    ) { }

    public function getId(): string
    {
        return $this->workspaceId;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function copyFilesFrom(string $path): void
    {
        $this->filesystem->mirror($path, $this->path);
    }

    public function goTo(): void
    {
        $this->filesystem->changeDir($this->path);
    }
}
