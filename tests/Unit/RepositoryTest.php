<?php

declare(strict_types=1);

use Alphpaca\MonoplusSplit\Repository;
use Alphpaca\MonoplusSplit\ShellInterface;

it('adds a remote', function () {
    $shell = $this->prophesize(ShellInterface::class);

    $shell->exec('git remote add some-origin git@github.com:rand/random.git')->shouldBeCalled();

    $repository = new Repository($shell->reveal());
    $repository->addRemote('some-origin', 'git@github.com:rand/random.git');
});

it('removes a remote', function () {
    $shell = $this->prophesize(ShellInterface::class);

    $shell->exec('git remote remove some-origin')->shouldBeCalled();

    $repository = new Repository($shell->reveal());
    $repository->removeRemote('some-origin');
});

it('filters package', function () {
    $shell = $this->prophesize(ShellInterface::class);

    $shell->exec('git tag -l')->willReturn('not an empty string');
    $shell->exec('pipx run -- git-filter-repo --subdirectory-filter some-package --refs some-branch $(git tag -l) --force --no-ff')->shouldBeCalled();

    $repository = new Repository($shell->reveal());
    $repository->filterPackage('some-package', 'some-branch');
});

it('pushes to a remote', function () {
    $shell = $this->prophesize(ShellInterface::class);

    $shell->exec('git branch --show-current')->willReturn('current-branch');
    $shell->exec('git push remote-name current-branch:target-branch --tags --force')->shouldBeCalled();

    $repository = new Repository($shell->reveal());
    $repository->push('remote-name', 'current-branch', 'target-branch');
});
