# Lumen Test Booster
Just a small abstraction of lumen test with aspectmock and handler excpetion. 

## Install

```bash
# Install in dev mode
composer require alexrili/php-easy-test --dev
```

## how to use

First of all, you need to make sure you have the `Stubs` folder inside your high level `test` folder.
Name your `clone classes` as YourClassName**Stub** and put them inside a `Stubs` folder

```
    tests\
        Stubs\
          ClassYouWantToCloneStub
```
Import LumenTestBooster as a `trait` in your high level TestCase class. 
> use \LumenTestBooster;

```php
// ...
abstract class TestCase extends Base
{
    use \LumenTestBooster;
//    ...
}
```

### How to clone/mock your tests
Just ovewriter the `setUp` method and call `$this->stubClasses()` method to stub/mock your classes
> Make sure you have, a `Stubs` folder inside your `test` high level folder.
```php
//  ...    
    public function setUp(): void
    {
        $this->stubClasses([ClassYourWantToMock::class]);
        parent::setUp();
    }
//    ...
```

### Use case
**1st case scenario.** 
Let's say you have a class name **NotificationService** and you want to mock/stub this class.
First of all you need to create a **NotificationServiceStub** inside a `tests/Stubs/` folder.
After this, you just call  `$this->stubClasses([ClassYourWantToMock::class]);` inside your `setUp` method.
And That's It.
> Don't forget to import `LumenTestBooster` in your `TestCase` class.
```
    tests\
        Stubs\
          NotificationServiceStub.php
``` 
```php
//  ...    
    public function setUp(): void
    {
        $this->stubClasses([NotificationService::class]);
        parent::setUp();
    }
//    ...
```
**2st case scenario.**
But, if you want to test some different returns of a method? Eg. you need to test a error return. 

```
    tests\
        Stubs\
          NotificationServiceStub.php
``` 
> Inside your StubClass(in this case NotificationServiceStub), you will create a `sendEmailNotificationError()` method. 
> In this case you can disable exception handler by call `$this->withoutShowingExceptions()` 
```php
//  ...    
    /** @test */
    public function should_return_erro_when_consumer_doesnt_have_an_email()
    {
      $this->doubleMethod(NotificationService::class, 'sendEmailNotification')
                  ->setReturn(NotificationServiceStub::class, "sendEmailNotificationError");
    }
//    ...
```

## Other configs

You can change exception handlers to not showing/handler in runtime. Say you have a specific test you want to return an error.
```php
//  ...    
    /** @test */
    public function should_return_error()
    {
        $this->withoutShowingExceptions();
//     ...
    }
//    ...
```

You also can change the default set of stub paths. 
> This config must be put inside you high level test case class.
```php
//  ...    
    /**
     * setup before class function
     *
     * @return void
     */
    public static function setUpBeforeClass(): void
    {

        self::initAspectMock(
        [
             'appDir' => '/', // root directory of your aplication. 
             'debug' => true, // to get debug details 
             'includePaths' => [__DIR__ . '/api/app', '/common'], // you can put how many folders you want to be maped here.
             'cacheDir' => __DIR__ . '../storage/cache/__tests_ // place where you 'mocked/stub' class are runing.
        ]);
        parent::setUpBeforeClass();
    }
//    ...
```


## Thanks!
@GMBN (the goldenboy)
@cadukiz
