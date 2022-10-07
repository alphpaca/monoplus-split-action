<?php

declare(strict_types=1);

use Alphpaca\MonoplusSplit\ShellInterface;
use Alphpaca\MonoplusSplit\Ssh;

it('setups SSH', function () {
    $shell = $this->prophesize(ShellInterface::class);

    $shell->exec('mkdir -p /root/.ssh')->shouldBeCalled();

    $ssh = Ssh::new($shell->reveal());
    $ssh->setup();
});

it('adds a host to known hosts', function () {
    $shell = $this->prophesize(ShellInterface::class);

    $shell->exec('ssh-keyscan github.com >> /root/.ssh/known_hosts')->shouldBeCalled();

    $ssh = Ssh::new($shell->reveal());
    $ssh->addToKnownHosts('github.com');
});

it('adds a private key', function () {
    $shell = $this->prophesize(ShellInterface::class);

    $shell->exec('echo "some-private-key" > /root/.ssh/id_rsa')->shouldBeCalled();
    $shell->exec('chmod 600 /root/.ssh/id_rsa')->shouldBeCalled();

    $ssh = Ssh::new($shell->reveal());
    $ssh->addPrivateKey('some-private-key');
});
