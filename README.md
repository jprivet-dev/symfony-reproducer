# Symfony Reproducer

This repository provides standardized, Docker-based environments to reproduce and debug issues reported to the Symfony framework. Each reproduction case is isolated in its own branch to ensure a clean and consistent environment.

## Available reproducers

| Title/Issue ID                                                                                                                                       | Branch                                                                                                        |
|:-----------------------------------------------------------------------------------------------------------------------------------------------------|:--------------------------------------------------------------------------------------------------------------|
| GotenbergBundle — Contribution App - Symfony 6.x                                                                                                     | [gotenberg-bundle-app-sf6x](https://github.com/jprivet-dev/symfony-reproducer/tree/gotenberg-bundle-app-sf6x) |
| [[Mime] Fix SMimeSigner removing HTML/Parts in multipart messages and corrupting boundaries #63638](https://github.com/symfony/symfony/issues/63638) | [63638-smime-signer-sf7.4](https://github.com/jprivet-dev/symfony-reproducer/tree/63638-smime-signer-sf7.4)   |
| [[Mime] Fix SMimeSigner removing HTML/Parts in multipart messages and corrupting boundaries #63638](https://github.com/symfony/symfony/issues/63638) | [63638-smime-signer-sf6.4](https://github.com/jprivet-dev/symfony-reproducer/tree/63638-smime-signer-sf6.4)   |

## How to use a reproducer

1. **Switch** to the branch corresponding to the issue you want to test.
2. **Follow** the specific instructions provided in the branch's README or script.
