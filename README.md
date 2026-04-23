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
git checkout 63638-smime-signer-sf7.4
```

2. **Install the environment:**

```shell
make install
```

## Reproduction Steps

### 1. Generate test certificates

The certificates must be placed in the `build/` directory:

```shell
make php_command a="openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout build/key.pem -out build/cert.pem -subj '/CN=repro-bug'"
```

### 2. Run the reproduction commands

Generate both valid (text only) and buggy (with attachment) S/MIME messages:

```shell
# Valid signature (Simple Text)
make console c="app:valid" > build/valid.eml

# Buggy signature (Multipart with DataPart)
make console c="app:repro" > build/repro.eml
```

## Verification

### Automated check (OpenSSL)

Verify the integrity of the generated signatures:

```shell
# This should succeed
make php_command a="openssl smime -verify -in build/valid.eml -inform SMIME -CAfile build/cert.pem"

# This demonstrates the issue
make php_command a="openssl smime -verify -in build/repro.eml -inform SMIME -CAfile build/cert.pem"
```

### Manual check

Open the files in the `build/` folder using an email client (e.g., **Thunderbird**):

1. Import `build/cert.pem` as a trusted CA.
2. Open `build/repro.eml`.
3. Check for "Invalid Signature" or corrupted attachments.
