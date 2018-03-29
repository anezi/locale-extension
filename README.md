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

### Functions

#### Get locales

`{% for locale in locales() %}{{ locale }} - {% endfor %}`

shows:

**ar - en - fr -** 

### Filters

#### Get country name

`{{ "be"|country_name }}`

shows:

**Belgium**

#### Get locale name

`{{ "fr_BE"|locale_name }}`

shows:

**French (Belgium)**

#### Get locale name in that locale

`{{ "fr_BE"|origin_locale_name }}`

shows:

**français (Belgique)**
