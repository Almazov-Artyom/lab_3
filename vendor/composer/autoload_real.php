<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit8994a5c2e1cab6463b9c8207dcb719cd
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInit8994a5c2e1cab6463b9c8207dcb719cd', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit8994a5c2e1cab6463b9c8207dcb719cd', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit8994a5c2e1cab6463b9c8207dcb719cd::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
