<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit5d23b90d67417d6e0680f93f41f55c0d
{
    public static $files = array (
        '6e3fae29631ef280660b3cdad06f25a8' => __DIR__ . '/..' . '/symfony/deprecation-contracts/function.php',
        '320cde22f66dd4f5d3fd621d3e88b98f' => __DIR__ . '/..' . '/symfony/polyfill-ctype/bootstrap.php',
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
        '8825ede83f2f289127722d4e842cf7e8' => __DIR__ . '/..' . '/symfony/polyfill-intl-grapheme/bootstrap.php',
        'e69f7f6ee287b969198c3c9d6777bd38' => __DIR__ . '/..' . '/symfony/polyfill-intl-normalizer/bootstrap.php',
        'b6b991a57620e2fb6b2f66f03fe9ddc2' => __DIR__ . '/..' . '/symfony/string/Resources/functions.php',
        '6a47392539ca2329373e0d33e1dba053' => __DIR__ . '/..' . '/symfony/polyfill-intl-icu/bootstrap.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Polyfill\\Mbstring\\' => 26,
            'Symfony\\Polyfill\\Intl\\Normalizer\\' => 33,
            'Symfony\\Polyfill\\Intl\\Icu\\' => 26,
            'Symfony\\Polyfill\\Intl\\Grapheme\\' => 31,
            'Symfony\\Polyfill\\Ctype\\' => 23,
            'Symfony\\Contracts\\Service\\' => 26,
            'Symfony\\Contracts\\EventDispatcher\\' => 34,
            'Symfony\\Component\\TypeInfo\\' => 27,
            'Symfony\\Component\\String\\' => 25,
            'Symfony\\Component\\PropertyInfo\\' => 31,
            'Symfony\\Component\\PropertyAccess\\' => 33,
            'Symfony\\Component\\OptionsResolver\\' => 34,
            'Symfony\\Component\\Form\\' => 23,
            'Symfony\\Component\\EventDispatcher\\' => 34,
        ),
        'P' => 
        array (
            'Psr\\EventDispatcher\\' => 20,
            'Psr\\Container\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Polyfill\\Mbstring\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
        ),
        'Symfony\\Polyfill\\Intl\\Normalizer\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-intl-normalizer',
        ),
        'Symfony\\Polyfill\\Intl\\Icu\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-intl-icu',
        ),
        'Symfony\\Polyfill\\Intl\\Grapheme\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-intl-grapheme',
        ),
        'Symfony\\Polyfill\\Ctype\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-ctype',
        ),
        'Symfony\\Contracts\\Service\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/service-contracts',
        ),
        'Symfony\\Contracts\\EventDispatcher\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/event-dispatcher-contracts',
        ),
        'Symfony\\Component\\TypeInfo\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/type-info',
        ),
        'Symfony\\Component\\String\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/string',
        ),
        'Symfony\\Component\\PropertyInfo\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/property-info',
        ),
        'Symfony\\Component\\PropertyAccess\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/property-access',
        ),
        'Symfony\\Component\\OptionsResolver\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/options-resolver',
        ),
        'Symfony\\Component\\Form\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/form',
        ),
        'Symfony\\Component\\EventDispatcher\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/event-dispatcher',
        ),
        'Psr\\EventDispatcher\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/event-dispatcher/src',
        ),
        'Psr\\Container\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/container/src',
        ),
    );

    public static $classMap = array (
        'Collator' => __DIR__ . '/..' . '/symfony/polyfill-intl-icu/Resources/stubs/Collator.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'IntlDateFormatter' => __DIR__ . '/..' . '/symfony/polyfill-intl-icu/Resources/stubs/IntlDateFormatter.php',
        'Locale' => __DIR__ . '/..' . '/symfony/polyfill-intl-icu/Resources/stubs/Locale.php',
        'Normalizer' => __DIR__ . '/..' . '/symfony/polyfill-intl-normalizer/Resources/stubs/Normalizer.php',
        'NumberFormatter' => __DIR__ . '/..' . '/symfony/polyfill-intl-icu/Resources/stubs/NumberFormatter.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit5d23b90d67417d6e0680f93f41f55c0d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit5d23b90d67417d6e0680f93f41f55c0d::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit5d23b90d67417d6e0680f93f41f55c0d::$classMap;

        }, null, ClassLoader::class);
    }
}
