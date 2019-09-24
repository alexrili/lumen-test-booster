<?php


use AspectMock\Kernel;

trait EasyAspectMock
{

    /**
     * setup before class function
     *
     * @return void
     */
    public static function setUpBeforeClass(): void
    {

        self::initAspectMock();
        parent::setUpBeforeClass();
    }


    /**
     * @param array $options
     */
    public static function initAspectMock(array $options = [])
    {
        $default_options = self::getDefaultOption();
        self::loadAspectMock(array_merge($default_options, $options));
    }

    /**
     * @return array
     */
    protected static function getDefaultOption()
    {
        return [
            'appDir' => '/',
            'debug' => true,
            'includePaths' => ['/api/app', '/common'],
            'cacheDir' => self::getPhpEasyTestPath()
        ];
    }

    /**
     * @param array $options
     */
    protected static function loadAspectMock(array $options): void
    {
        $kernel = Kernel::getInstance();
        $kernel->init($options);
    }

    /**
     * @return string
     */
    public static function getPhpEasyTestPath()
    {
        $temp_path = "/api/storage/cache/_easy_";
        if (!is_dir($temp_path)) {
            mkdir($temp_path, 0777, true);
        }
        return $temp_path;
    }

}
