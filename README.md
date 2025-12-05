# PHPUnit test case splitter

[![PHP versions: 8.1|8.2|8.3|8.4|8.5](https://img.shields.io/badge/php-8.1|8.2|8.3|8.4|8.5-blue.svg)](https://packagist.org/packages/dave-liddament/test-splitter)
[![Latest Stable Version](https://poser.pugx.org/dave-liddament/test-splitter/v/stable)](https://packagist.org/packages/dave-liddament/test-splitter)
[![License](https://poser.pugx.org/dave-liddament/test-splitter/license)](https://github.com/DaveLiddament/test-splitter/blob/master/LICENSE.md)
[![Total Downloads](https://poser.pugx.org/dave-liddament/test-splitter/downloads)](https://packagist.org/packages/dave-liddament/test-splitter/stats)

[![Continuous Integration](https://github.com/DaveLiddament/test-splitter/workflows/Checks/badge.svg)](https://github.com/DaveLiddament/test-splitter/actions)
[![PHPStan max](https://img.shields.io/badge/PHPStan-max%20level-brightgreen.svg)](https://github.com/DaveLiddament/sarb/blob/master/phpstan.neon)


Have you got a slow running PHPUnit test suite?

Do you want to split your tests over separate instances? If so, PHPUnit test case splitter might help.
It splits tests into batches in a deterministic way.
Each batch of tests can run in separate instances (e.g. by using a matrix in GitHub actions).

## Usage

Install via [Composer](https://getcomposer.org):

```shell
composer require --dev dave-liddament/test-splitter
```

This package provides an executable under `vendor/bin/tsplit` that takes two arguments: batch, and number of batches.
It accepts a list of tests piped into `stdin` and outputs the tests for the specified batch to `stdout`.

To split the tests into 4 batches and run the first batch you can do:

```shell
vendor/bin/phpunit --filter `vendor/bin/phpunit --list-tests | vendor/bin/tsplit 1 4`
```

To run the second batch out of 4 you'd use:

```shell
vendor/bin/phpunit --filter `vendor/bin/phpunit --list-tests | vendor/bin/tsplit 2 4`
```

## CI/CD Usage

### GitHub Actions

Add this to your GitHub actions:

```yaml
jobs:
  tests:
  
    strategy:
      fail-fast: false
      matrix: 
        test-batch: [1, 2, 3, 4]

    steps: 
      # Steps to checkout code, setup environment, etc.

      - name: "Tests batch ${{ matrix.test--batch }}"
        run: vendor/bin/phpunit --filter `vendor/bin/phpunit --list-tests | vendor/bin/tsplit ${{ matrix.test-batch }} 4`
```

This will split the tests over 4 different jobs.

### GitLab CI/CD

```yaml
test:
  stage: test
  parallel: 4
  script:
    - vendor/bin/phpunit --filter `vendor/bin/phpunit --list-tests | vendor/bin/tsplit ${CI_NODE_INDEX} ${CI_NODE_TOTAL}`

```

This will split the tests over 4 different jobs. [GitLabs predefined variables](https://docs.gitlab.com/ci/variables/predefined_variables/) `CI_NODE_INDEX` and `CI_NODE_TOTAL` are used to automatically specify the batch number and total number of batches.

## Additional documentation

- [Code of Conduct](docs/CodeOfConduct.md)
- [Contributing](docs/Contributing.md)

## Alternative tools

Test splitter is a very simple tool. It was created in 2021, at the time no other tools did something similar. 
It solved a problem I had on a couple of client projects. 

Since 2021 other tools that do similar things have been developed. If you want more mature or more feature rich tools then try these:

- [Paratest](https://github.com/paratestphp/paratest) - You'll need to use the [shard functionality](https://github.com/paratestphp/paratest/pull/1013) introduced in September 2025.
- [Shipmonk's PHPUnit parallel job balancer](https://github.com/shipmonk-rnd/phpunit-parallel-job-balancer) created in December 2025.