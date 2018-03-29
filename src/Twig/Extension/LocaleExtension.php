<?php

/*
 * (c) Hassan Amouhzi <hassan@anezi.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Anezi\Locale\Twig\Extension;

use Symfony\Component\Intl\Intl;
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
            new TwigFilter('short_name', [$this, 'getShortName']),
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
        return Intl::getRegionBundle()->getCountryName(\strtoupper($countryCode));
    }

    /**
     * @param string $locale The locale.
     *
     * @return string
     */
    public function getLocaleName(string $locale): string
    {
        return Intl::getLocaleBundle()->getLocaleName($locale);
    }

    /**
     * @param string $locale The locale.
     *
     * @return string
     */
    public function getOriginLocaleName(string $locale): ?string
    {
        return Intl::getLocaleBundle()->getLocaleName($locale, $locale);
    }

    /**
     * @param string $locale The locale.
     *
     * @return string
     */
    public function getShortName(string $locale): string
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
        return \in_array($this->getShortName($locale), self::RTL_LANGUAGES, true) ? 'rtl' : 'ltr';
    }
}
