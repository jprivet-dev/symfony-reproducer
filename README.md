# Symfony Reproducer - Issue #63638

[[Mime] Fix SMimeSigner removing HTML/Parts in multipart messages and corrupting boundaries #63638](https://github.com/symfony/symfony/issues/63638)

## Prerequisites

* [Docker Engine](https://docs.docker.com/engine/install/)
* [Make](https://www.gnu.org/software/make/)

## Setup

1. **Clone and switch to the reproduction branch:**

```shell
git clone git@github.com:jprivet-dev/symfony-reproducer.git
cd symfony-reproducer
git checkout 63638-smime-signer-sf6.4
```

2. **Install the environment:**

```shell
make install
```

## Environment

| Component | Version |
|-----------|---------|
| Symfony   | 6.4.36  |
| PHP       | 8.5.5   |
| OpenSSL   | 3.5.5   |

```shell
docker compose exec php bin/console --version
docker compose exec php bash -c "php -r 'echo phpversion();'"
docker compose exec php bash -c "openssl version"
```

## Reproduction Steps

### 1. Generate test certificates

The certificates must be placed in the `build/` directory:

```shell
docker compose exec php bash -c "openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout build/key.pem -out build/cert.pem -subj '/CN=repro-bug'"
```

### 2. Run the reproduction commands

Generate S/MIME messages:

```shell
docker compose exec php bin/console app:repro > build/repro.eml
docker compose exec php bin/console app:repro-templated > build/repro-templated.eml
```

## Verification

### Automated check (OpenSSL)

Verify the integrity of the generated signatures:

```shell
docker compose exec php bash -c "openssl smime -verify -in build/repro.eml -inform SMIME -CAfile build/cert.pem --out build/verify-repro.txt"
grep -i "Hello\|text/html" build/verify-repro.txt

docker compose exec php bash -c "openssl smime -verify -in build/repro-templated.eml -inform SMIME -CAfile build/cert.pem --out build/verify-repro-templated.txt"
grep -i "Hello\|text/html" build/verify-repro-templated.txt
```

### Manual check

Open the files in the `build/` folder using an email client (e.g., **Thunderbird**):

1. Import `build/cert.pem` as a trusted CA.
2. Open `build/repro.eml` or `build/repro-templated.eml`.
3. Check for "Invalid Signature" or corrupted attachments.
