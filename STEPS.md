# STEPS.md — GotenbergBundle Contribution Setup

## References

- https://github.com/jprivet-dev/symfony-starter
- https://github.com/jprivet-dev/GotenbergBundle

---

## 1. Generate the Symfony app

```shell
git clone git@github.com:jprivet-dev/symfony-starter.git
cd symfony-starter
make contrib@6x BRANCH=gotenberg-bundle-app-sf6x
```

Enable aliases for the current shell session (project-specific shortcuts for
`symfony`, `php`, `composer`, etc.):

```shell
. aliases
# or
source aliases
```

## 2. Install dependencies

> `symfony/http-client` is not declared in the bundle's `require` (only the contracts are),
> but is needed by the Symfony framework configuration.

```shell
composer require symfony/http-client
composer require --dev symfony/maker-bundle
make require_asset_mapper
make require_bootstrap
composer require sensiolabs/gotenberg-bundle
```

## 3. Create the controller

```shell
symfony make:controller HomeController
```

## 4. Clone the fork (in another terminal)

```shell
git clone https://github.com/jprivet-dev/GotenbergBundle ../GotenbergBundle
```

## 5. Mount the fork and switch to local version

```shell
make contrib_volume d=GotenbergBundle
git commit -am "Add a Docker volume for GotenbergBundle"
make restart

make contrib_add_repo d=GotenbergBundle
composer require sensiolabs/gotenberg-bundle:1.x-dev
git commit -am "Add a repo for GotenbergBundle"
```

## 6. Install bundle dependencies and run tests

```shell
make gotenberg_install
make gotenberg_tests
# OK (754 tests, 1632 assertions)
```

## 7. Install Dagger

```shell
curl -fsSL https://dl.dagger.io/dagger/install.sh | sudo BIN_DIR=/usr/local/bin sh
dagger version
# dagger v0.20.6 (image://registry.dagger.io/engine:v0.20.6) linux/amd64
```

> All `make gotenberg_*` and `make dagger_*` commands are run from the `symfony-starter`
> directory — no need to navigate into the bundle directory manually.

```shell
make dagger_develop
make dagger_all
```
