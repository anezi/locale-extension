## Locale Extensions for Twig

[![pipeline status](https://gitlab.anezi.net/sf-comp/locale/badges/master/pipeline.svg)](https://gitlab.anezi.net/sf-comp/locale/commits/master)
[![coverage report](https://gitlab.anezi.net/sf-comp/locale/badges/master/coverage.svg)](https://symfony.anezi.net/locale/)

### Symfony service

```yaml
services:
    anezi_twig.locale_extension:
        class: Anezi\Locale\Twig\Extension\LocaleExtension
        public:    false
        arguments: ["%managed_locales%"]
        tags:
            - { name: twig.extension }

```