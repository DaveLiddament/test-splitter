# PHPUnit test case splitter

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