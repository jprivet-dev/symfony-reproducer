# GotenbergBundle — Contribution App

A Dockerized Symfony 6 application dedicated to contributing to [sensiolabs/GotenbergBundle](https://github.com/sensiolabs/GotenbergBundle).

Generated with [jprivet-dev/symfony-starter](https://github.com/jprivet-dev/symfony-starter). Built on top of [dunglas/symfony-docker](https://github.com/dunglas/symfony-docker).

## Quick start

1. Be sure to install the latest version of [Docker Engine](https://docs.docker.com/engine/install/).

2. Clone this repository and the bundle fork side-by-side:

```shell
git clone git@github.com:jprivet-dev/symfony-starter.git
git clone https://github.com/jprivet-dev/GotenbergBundle
```

3. Install and start the app:

```shell
cd symfony-starter
make install
```

4. Install bundle dependencies:

```shell
make gotenberg_install
```

5. Install [Dagger](https://docs.dagger.io/install) (on host machine):

```shell
curl -fsSL https://dl.dagger.io/dagger/install.sh | sudo BIN_DIR=/usr/local/bin sh
make dagger_develop
```

## Daily usage

```shell
cd symfony-starter
make start            # Start the project
make gotenberg_tests  # Run PHPUnit tests
make dagger_all       # Run all Dagger tests (phpunit, phpstan, cs-fixer, deps, docs)
```

> All `make gotenberg_*` and `make dagger_*` commands are run from this directory —
> no need to navigate into the bundle directory manually.

## References

- [STEPS.md](STEPS.md) — detailed setup steps
- [.starter/docs/README.md](.starter/docs/README.md) — full Symfony Starter documentation
- https://github.com/jprivet-dev/GotenbergBundle
- https://github.com/sensiolabs/GotenbergBundle
- https://github.com/jprivet-dev/symfony-starter
