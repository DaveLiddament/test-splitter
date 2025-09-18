# PHPUnit test case splitter

[![PHP versions: 8.1|8.2|8.3|8.4](https://img.shields.io/badge/php-8.1|8.2|8.3|8.4-blue.svg)](https://packagist.org/packages/dave-liddament/test-splitter)
[![Latest Stable Version](https://poser.pugx.org/dave-liddament/test-splitter/v/stable)](https://packagist.org/packages/dave-liddament/test-splitter)
[![License](https://poser.pugx.org/dave-liddament/test-splitter/license)](https://github.com/DaveLiddament/test-splitter/blob/master/LICENSE.md)
[![Total Downloads](https://poser.pugx.org/dave-liddament/test-splitter/downloads)](https://packagist.org/packages/dave-liddament/test-splitter/stats)

[![Continuous Integration](https://github.com/DaveLiddament/test-splitter/workflows/Checks/badge.svg)](https://github.com/DaveLiddament/test-splitter/actions)
[![Psalm level 1](https://img.shields.io/badge/Psalm-%20level%201-brightgreen.svg)](https://github.com/DaveLiddament/test-splitter/blob/master/psalm.xml)



Have you got a slow running test suite? Are existing test parallelisation tools (e.g. [paratest](https://github.com/paratestphp/paratest)) not suitable as you need separate database instances?

If so PHPUnit test case splitter might help. This splits tests into batches in a deterministic way. Each batch of tests can run in separate instances (e.g. by using a matrix in github actions).

## Usage

To use. Install:

```bash
composer require --dev dave-liddament/test-splitter
```

Test splitter (`tsplit`) takes two arguments: batch, and number of batches. The list of tests is piped into `stdin`.

To split the tests into 4 batches and run the first batch you can do:

```
vendor/bin/phpunit --filter `vendor/bin/phpunit --list-tests | vendor/bin/tsplit 1 4`
```

To run the second batch you'd use:


```
vendor/bin/phpunit --filter `vendor/bin/phpunit --list-tests | vendor/bin/tsplit 2 4`
```


## Github actions

Add this to your github actions:

```yaml
jobs:
  tests:
  
    strategy:
      fail-fast: false
      matrix: 
        test-batch: [1, 2, 3, 4]

    steps: 
      # Steps to checkout code, setup environment, etc

      - name: "Tests batch ${{ matrix.test--batch }}"
        run: vendor/bin/phpunit --filter `vendor/bin/phpunit --list-tests | vendor/bin/tsplit ${{ matrix.test-batch }} 4`
```

This will split the tests over 4 different jobs.

## Additional documentation

- [Code of Conduct](docs/CodeOfConduct.md)
- [Contributing](docs/Contributing.md)