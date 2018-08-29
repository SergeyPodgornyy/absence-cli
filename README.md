# Absence cli

[![Software License][ico-license]](LICENSE.md)

Console-based application to count employee vacation days for a given year.

## Install

```console
    cp .env.example .env
    composer install
    php absence-cli migrate
    php absence-cli db:seed
```

## Usage

To calculate employees vacation days, run the following command:

```console
    php absence-cli vacation:calculate
```

You can also provide optional parameter `year`:

```console
    php absence-cli vacation:calculate --year=2017
```

## License

It is an open-source software licensed under the [MIT license](LICENSE.md).

[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg
