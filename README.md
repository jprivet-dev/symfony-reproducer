# GotenbergBundle — Contribution Reproducer

A Dockerized Symfony 6.x application dedicated to contributing to [sensiolabs/GotenbergBundle](https://github.com/sensiolabs/GotenbergBundle).

## Prerequisites

- [Docker Engine](https://docs.docker.com/engine/install/) (latest version)
- [Dagger](https://docs.dagger.io/install) (on the host machine, for full CI checks)

## Installation

### 1. Clone the project

Clone this repository and the bundle fork side-by-side:

```shell
git clone git@github.com:jprivet-dev/symfony-reproducer.git --branch gotenberg-bundle/reproducer-sf6.4
git clone https://github.com/<YOUR_USERNAME>/GotenbergBundle
```

> [!NOTE]
>
> Fork [sensiolabs/GotenbergBundle](https://github.com/sensiolabs/GotenbergBundle) first, then clone your own fork.

### 2. Install the app

```shell
cd symfony-reproducer
make install
```

### 3. Install bundle dependencies and initialize Dagger

```shell
make gotenberg_install
```

### 4. Go on the app

Go to https://symfony-reproducer.localhost:8442/ and accept [the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334) on first visit.

|                                                         |                                               |
|:--------------------------------------------------------|:----------------------------------------------|
| ![gotenberg-homepage.jpeg](doc/gotenberg-homepage.jpeg) | ![gotenberg-pdf.jpeg](doc/gotenberg-pdf.jpeg) |

> [!TIP]
>
> * Override default ports in `.env.local` (e.g. `HTTP_PORT=9090 HTTPS_PORT=9443`), or set `HTTP_PORTS_AUTO=true` to derive ports from the project name (avoids conflicts between projects).
> * Run `make info` to see the current URLs.

## Makefile daily usage

```shell
make start              # Start the project and show info (detached mode)
make stop               # Stop the project (down)
make info               # Show project access info (URLs, ports)
make gotenberg_tests    # Run PHPUnit tests
make gotenberg_coverage # Generate HTML coverage report
make dagger_all         # Run all Dagger checks (cs-fixer, phpstan, deps, docs, phpunit)
```

> [!TIP]
>
> Run `make` to see all available commands ([makefile.md](.starter/docs/makefile.md)).

## Documentation

Browse the [full Symfony Starter documentation](.starter/docs/STARTER.md).

## References

* Generated with [jprivet-dev/symfony-starter](https://github.com/jprivet-dev/symfony-starter).
* Built on top of [dunglas/symfony-docker](https://github.com/dunglas/symfony-docker).
* https://github.com/sensiolabs/GotenbergBundle

## Comments, suggestions?

Feel free to make comments/suggestions in the [Git issues section](https://github.com/jprivet-dev/symfony-reproducer/issues).

## License

This project is released under the [**MIT License**](https://github.com/jprivet-dev/symfony-reproducer/blob/main/LICENSE).
