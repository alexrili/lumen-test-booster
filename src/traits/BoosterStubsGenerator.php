<?php


use AspectMock\Test as test;
use Illuminate\Support\Arr;

trait BoosterStubsGenerator
{

    /**
     * @var string
     */
    public static $path_stub = "Tests\\Stubs";

    /**
     * class double variable
     *
     * @var string
     */
    protected $class_double;

    /**
     * method double variable
     *
     * @var string
     */
    protected $method_double;

    /**
     * @param string $class
     * @param string $method
     * @return object
     */
    public function doubleMethod(string $class, string $method): object
    {
        $this->class_double = $class;
        $this->method_double = $method;
        return $this;
    }

    /**
     * @param string $class
     * @param string|null $method
     * @throws \Exception
     */
    public function setReturn(string $class, ?string $method = null): void
    {
        test::double($this->class_double, [$this->method_double => function (...$parameters) use ($class, $method) {
            if ($method !== null) {
                return (new $class())->$method(...$parameters);
            }
            return new $class();
        }]);
    }

    /**
     * @param string $return
     * @throws \Exception
     */
    public function setStaticReturn($return): void
    {
        test::double($this->class_double, [$this->method_double => $return]);
    }

    /**
     * Undocumented function
     *
     * @param array $class_names
     * @return void
     */
    public function stubClasses(array $class_names = [])
    {
        foreach ($class_names as $class) {
            $methods = get_class_methods($class);
            foreach ($methods as $method_name) {
                $class_name = Arr::last(explode("\\", $class));
                $mock_class = self::$path_stub . "\\{$class_name}Stub";
                if (method_exists((new $mock_class), $method_name)) {
                    $this->doubleMethod($class, $method_name)
                        ->setReturn($mock_class, $method_name);
                }
            }
        }
    }


}
