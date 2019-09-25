# PHP Easy Test
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
Import PhpEasyTest as a `trait` in your high level TestCase class. 
> use \PhpEasyTest;

```php
// ...
abstract class TestCase extends Base
{
    use \PhpEasyTest;
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
> Don't forget to import `PhpEasyTest` in your `TestCase` class.
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




