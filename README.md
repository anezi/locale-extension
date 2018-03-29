## Locale Extensions for Twig

[![pipeline status](https://gitlab.com/anezi/locale-extension/badges/master/pipeline.svg)](https://gitlab.com/anezi/locale-extension/commits/master)
[![coverage report](https://gitlab.com/anezi/locale-extension/badges/master/coverage.svg)](https://gitlab.com/anezi/locale-extension)

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

### Filters

#### Get country name

`{{ "be"|country_name }}`

#### Get locale name

`{{ "be-FR"|locale_name }}`

