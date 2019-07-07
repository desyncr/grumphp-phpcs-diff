# GrumPHP phpcs-diff task

This package extends [GrumPHP](https://github.com/phpro/grumphp) with a task to run phpcs-diff.

## Installation

    composer require desyncr/grumphp-phpcs-diff --dev

Add the extension loader to your `grumphp.yml`

```yaml
parameters:
    extensions:
        - Desyncr\GrumPHP\Extension
```

## Usage

```yaml
parameters:
    tasks:
        phpcs-diff:
            standard: PSR12
            branch: master
```

