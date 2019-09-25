<?php

trait BoosterExceptionHandler
{

    /**
     * @var $exception_disabled ;
     */
    protected $exception_disabled;

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
        if ($this->response->exception) {
            if (!$this->exception_disabled) {
                dump($this->response->exception);
            }
        }
    }

    /**
     * withoutShowingExceptions
     */
    public function withoutShowingExceptions(): void
    {
        $this->exception_disabled = true;
    }


}
