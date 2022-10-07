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

it('filter package', function () {
    $shell = $this->prophesize(ShellInterface::class);

    $shell->exec('git filter-repo --subdirectory-filter some-package --force')->shouldBeCalled();

    $repository = new Repository($shell->reveal());
    $repository->filterPackage('some-package');
});

it('pushes to a remote', function () {
    $shell = $this->prophesize(ShellInterface::class);

    $shell->exec('git branch --show-current')->willReturn('current-branch');
    $shell->exec('git push remote-name current-branch:target-branch --force')->shouldBeCalled();

    $repository = new Repository($shell->reveal());
    $repository->push('remote-name', 'target-branch');
});

it('adds a tag', function () {
    $shell = $this->prophesize(ShellInterface::class);

    $shell->exec('git tag some-tag')->shouldBeCalled();

    $repository = new Repository($shell->reveal());
    $repository->addTag('some-tag');
});

it('removes all tags', function () {
    $shell = $this->prophesize(ShellInterface::class);

    $shell->exec('git tag -d $(git tag -l)')->shouldBeCalled();

    $repository = new Repository($shell->reveal());
    $repository->removeAllTags();
});

it('pushes a tag', function () {
    $shell = $this->prophesize(ShellInterface::class);

    $shell->exec('git push remote-name some-tag')->shouldBeCalled();

    $repository = new Repository($shell->reveal());
    $repository->pushTag('remote-name', 'some-tag');
});
