<?php

declare(strict_types=1);

namespace Alphpaca\MonoplusSplit;

use Webmozart\Assert\Assert;

final class Configuration
{
    const INPUT_PACKAGE_PATH = 'INPUT_PACKAGE_PATH';
    const INPUT_SSH_PRIVATE_KEY = 'INPUT_SSH_PRIVATE_KEY';
    const INPUT_GIT_USERNAME = 'INPUT_GIT_USERNAME';
    const INPUT_GIT_EMAIL = 'INPUT_GIT_EMAIL';
    const INPUT_REPOSITORY_HOST = 'INPUT_REPOSITORY_HOST';
    const INPUT_REPOSITORY_OWNER = 'INPUT_REPOSITORY_OWNER';
    const INPUT_REPOSITORY_NAME = 'INPUT_REPOSITORY_NAME';
    const INPUT_TARGET_BRANCH = 'INPUT_TARGET_BRANCH';
    const INPUT_TAG = 'INPUT_TAG';
    const YES = 'yes';
    const NO = 'no';

    public static function createFromEnv(array $environmentVariables): self
    {
        Assert::keyExists($environmentVariables, self::INPUT_PACKAGE_PATH);
        Assert::keyExists($environmentVariables, self::INPUT_SSH_PRIVATE_KEY);
        Assert::keyExists($environmentVariables, self::INPUT_GIT_USERNAME);
        Assert::keyExists($environmentVariables, self::INPUT_GIT_EMAIL);
        Assert::keyExists($environmentVariables, self::INPUT_REPOSITORY_HOST);
        Assert::keyExists($environmentVariables, self::INPUT_REPOSITORY_OWNER);
        Assert::keyExists($environmentVariables, self::INPUT_REPOSITORY_NAME);
        Assert::keyExists($environmentVariables, self::INPUT_TARGET_BRANCH);

        return new Configuration(
            $environmentVariables[self::INPUT_PACKAGE_PATH],
            $environmentVariables[self::INPUT_SSH_PRIVATE_KEY],
            $environmentVariables[self::INPUT_GIT_USERNAME],
            $environmentVariables[self::INPUT_GIT_EMAIL],
            $environmentVariables[self::INPUT_REPOSITORY_HOST],
            $environmentVariables[self::INPUT_REPOSITORY_OWNER],
            $environmentVariables[self::INPUT_REPOSITORY_NAME],
            $environmentVariables[self::INPUT_TARGET_BRANCH],
            $environmentVariables[self::INPUT_TAG] ?? null,
        );
    }

    private function __construct(
        public readonly string $packagePath,
        public readonly string $sshPrivateKey,
        public readonly string $gitUsername,
        public readonly string $gitEmail,
        public readonly string $repositoryHost,
        public readonly string $repositoryOwner,
        public readonly string $repositoryName,
        public readonly string $targetBranch,
        public readonly ?string $tag = null,
    ) {
    }

    public function sshRepositoryUrl(): string
    {
        return sprintf('git@%s:%s/%s.git', $this->repositoryHost, $this->repositoryOwner, $this->repositoryName);
    }
}
