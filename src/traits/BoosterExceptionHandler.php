<?php

trait BoosterExceptionHandler
{

    /**
     * @var $exception_disabled ;
     */
    protected $exception_disabled;

    /**
     * @var bool
     */
    public $die_on_exception = true;

    /**
     * setUpException
     */
    public function setUpException(): void
    {
        $this->exception_disabled = false;
        parent::setUp();
    }

    /**
     * @param $method
     * @param $uri
     * @param array $parameters
     * @param array $cookies
     * @param array $files
     * @param array $server
     * @param null $content
     */
    public function call($method, $uri, $parameters = [], $cookies = [], $files = [], $server = [], $content = null)
    {
        parent::call($method, $uri, $parameters, $cookies, $files, $server, $content);
        $this->handleWithExceptions();
    }

    /**
     * withoutShowingExceptions
     */
    public function withoutShowingExceptions(): void
    {
        $this->exception_disabled = true;
    }

    /**
     * handleWithExceptions
     */
    public function handleWithExceptions(): void
    {
        if ($this->response->exception) {
            if (!$this->exception_disabled) {
                dump($this->response->exception);
                if ($this->die_on_exception) {
                    die();
                }
                throw $this->response->exception;
            }
        }
    }


}
