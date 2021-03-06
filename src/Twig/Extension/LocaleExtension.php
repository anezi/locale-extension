<?php

/*
 * (c) Hassan Amouhzi <hassan@anezi.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Anezi\Locale\Twig\Extension;

use Symfony\Component\Intl\Countries;
use Symfony\Component\Intl\Intl;
use Symfony\Component\Intl\Locales;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * @author  Hassan Amouhzi <hassan@anezi.net>
 */
class LocaleExtension extends AbstractExtension
{
    private const RTL_LANGUAGES = ['ar', 'arc', 'dv', 'fa', 'ha', 'he', 'khw', 'ks', 'ku', 'ps', 'ur', 'yi'];

    /**
     * @var array
     */
    private $locales;

    /**
     * @param array $locales The locale.
     */
    public function __construct(array $locales)
    {
        $this->locales = $locales;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('locales', [$this, 'getLocales']),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('country_name', [$this, 'getCountryName']),
            new TwigFilter('locale_name', [$this, 'getLocaleName']),
            new TwigFilter('origin_locale_name', [$this, 'getOriginLocaleName']),
            new TwigFilter('locale_short_name', [$this, 'getLocaleShortName']),
            new TwigFilter('html_dir', [$this, 'getHtmlDir']),
        ];
    }

    /**
     * @return array
     */
    public function getLocales(): array
    {
        return $this->locales;
    }

    /**
     * @param string $countryCode The country code.
     *
     * @return string
     */
    public function getCountryName(string $countryCode): string
    {
        if (class_exists('Symfony\Component\Intl\Countries')) {
            return Countries::getName(\strtoupper($countryCode));
        }

        return Intl::getRegionBundle()->getCountryName(\strtoupper($countryCode));
    }

    /**
     * @param string $locale The locale.
     *
     * @return string
     */
    public function getLocaleName(string $locale): string
    {
        if (class_exists('\Symfony\Component\Intl\Locales')) {
            return Locales::getName($locale);
        }

        return Intl::getLocaleBundle()->getLocaleName($locale);
    }

    /**
     * @param string $locale The locale.
     *
     * @return string
     */
    public function getOriginLocaleName(string $locale): ?string
    {
        if (class_exists('\Symfony\Component\Intl\Locales')) {
            return Locales::getName($locale, $locale);
        }

        return Intl::getLocaleBundle()->getLocaleName($locale, $locale);
    }

    /**
     * @param string $locale The locale.
     *
     * @return string
     */
    public function getLocaleShortName(string $locale): string
    {
        return \Locale::getPrimaryLanguage($locale);
    }

    /**
     * @param string $locale The locale.
     *
     * @return string
     */
    public function getHtmlDir(string $locale): string
    {
        return \in_array($this->getLocaleShortName($locale), self::RTL_LANGUAGES, true) ? 'rtl' : 'ltr';
    }
}
