# Symfony Reproducer

This repository provides standardized, Docker-based environments to reproduce and debug issues reported to the Symfony framework. Each reproduction case is isolated in its own branch to ensure a clean and consistent environment.

## Available reproducers

### Symfony

| Title/Issue ID                                            | Branch                                                                                                                      |
|:----------------------------------------------------------|:----------------------------------------------------------------------------------------------------------------------------|
| [#63638](https://github.com/symfony/symfony/issues/63638) | [symfony/63638-smime-signer-sf7.4](https://github.com/jprivet-dev/symfony-reproducer/tree/symfony/63638-smime-signer-sf7.4) |
| [#63638](https://github.com/symfony/symfony/issues/63638) | [symfony/63638-smime-signer-sf6.4](https://github.com/jprivet-dev/symfony-reproducer/tree/symfony/63638-smime-signer-sf6.4) |

### GotenberBundle

| Title/Issue ID  | Branch                                                                                                            |
|:----------------|:------------------------------------------------------------------------------------------------------------------|
| App Symfony 6.x | [gotenberg-bundle/symfony-6x](https://github.com/jprivet-dev/symfony-reproducer/tree/gotenberg-bundle/symfony-6x) |

## How to use a reproducer

1. **Switch** to the branch corresponding to the issue you want to test.
2. **Follow** the specific instructions provided in the branch's README or script.
