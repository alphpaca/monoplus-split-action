<?php

declare(strict_types=1);

use Alphpaca\MonoplusSplit\Filesystem;
use Alphpaca\MonoplusSplit\Workspace;

it('creates a workspace dir while creating a new instance', function () {
    $filesystem = $this->prophesize(Filesystem::class);

    $filesystem->mkdir(sprintf('%s/%s', sys_get_temp_dir(), 'workspace-id'))->shouldBeCalled();

    expect(Workspace::new($filesystem->reveal(), 'workspace-id'))->toBeInstanceOf(Workspace::class);
});

it('copies files from a given path', function () {
    $filesystem = $this->prophesize(Filesystem::class);

    $filesystem->mkdir(sprintf('%s/%s', sys_get_temp_dir(), 'workspace-id'))->shouldBeCalled();
    $filesystem->mirror('/path/to/files', sprintf('%s/%s', sys_get_temp_dir(), 'workspace-id'))->shouldBeCalled();

    $workspace = Workspace::new($filesystem->reveal(), 'workspace-id');
    $workspace->copyFilesFrom('/path/to/files');
});

it('goes to folder', function () {
    $filesystem = $this->prophesize(Filesystem::class);

    $filesystem->mkdir(sprintf('%s/%s', sys_get_temp_dir(), 'workspace-id'))->shouldBeCalled();
    $filesystem->changeDir(sprintf('%s/%s', sys_get_temp_dir(), 'workspace-id'))->shouldBeCalled();

    $workspace = Workspace::new($filesystem->reveal(), 'workspace-id');
    $workspace->goTo();
});
