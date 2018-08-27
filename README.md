# Absence cli

[![Software License][ico-license]](LICENSE.md)

Console-based application to count employee vacation days for a given year.

## Install

```console
    cp .env.example .env
    composer install
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

## Support the development
**Do you like this project? Support it by donating**

- PayPal: [Donate][paypal-donate]

## License

It is an open-source software licensed under the [MIT license](LICENSE.md).

[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg
[paypal-donate]: https://www.paypal.me/SergeyPodgornyy/10 