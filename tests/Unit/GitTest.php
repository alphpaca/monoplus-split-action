<?php

declare(strict_types=1);

use Alphpaca\MonoplusSplit\Git;
use Alphpaca\MonoplusSplit\ShellInterface;

it('setups a git configuration', function() {
    $shell = $this->prophesize(ShellInterface::class);

    $shell->exec('git config --global user.name "John Doe"')->shouldBeCalled();
    $shell->exec('git config --global user.email "john@doe.org"')->shouldBeCalled();
    $shell->exec('git config --global --add safe.directory /github/workspace')->shouldBeCalled();

    $git = Git::new($shell->reveal());
    $git->setup('John Doe', 'john@doe.org');
});
