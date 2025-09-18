# Contributing to test-splitter

Contributions are welcome. 


## Requirements for code created

test-splitter MUST support all PHP versions that are either in [active or security](https://www.php.net/supported-versions.php) support. 

The maintainer will aim to add support for new PHP versions within 6 weeks of the official release. 


## Code checks

After writing your code run code style fixer, this will automatically format the code to the project style:

```
composer cs-fix
```


Check all the CI tasks would run. 
```
composer ci
```


## Docker 

A docker file has been provided to help with development. 

#### Build
Build the image: 

```shell
docker compose build
```

#### Run the services

Start the services 
```shell
docker compose up -d
```

You can run composer command. E.g. To run `composer cs-fix` on PHP 8.2

```shell
docker compose exec php82 composer cs-fix 
```

See the composer scripts section for all scripts available.

You can also get shell access. E.g. to get shell access on PHP 8.3:

```shell
docker compose exec php82 bash 
```

