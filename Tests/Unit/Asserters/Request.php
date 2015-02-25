<?php

namespace Camael\Api\Tests\Unit\Asserters;

class Request extends \atoum\asserters\variable
{
    private $_host = '';
    private $_request = null;
    private $_router  = null;
    private $_dispatcher = null;
    private $_view = null;

    public function __construct()
    {
        parent::__construct();

        $dir = realpath(__DIR__.'/../../../Public/');
        \Sohoa\Framework\Framework::initialize($dir);

        $this->_framework  = new \Mock\Application\Maestria\Maestria();
        $this->_router     = new \Mock\Sohoa\Framework\Router();

        $this->_framework->_router = $this->_router;

        $this->_framework->setAcl();
        $this->_framework->kit('redirector', new \Camael\Api\Tests\Unit\Mock\Redirect());
        

        $this->_dispatcher = $this->_framework->getDispatcher();
        $this->_view       = $this->_framework->getView();

        //$this->_router->construct();

        // print_r($this->_router->dump());
    }

    public function __call($name, $arg)
    {
        $method = ['get', 'post', 'put', 'patch', 'update', 'new', 'destroy'];

        if(in_array($name, $method) === false)
            return parent::__call($name, $arg);

        if (isset($arg[0]) === false) {
            throw new \Exception("You need and url in first argument", 0);
        }

        if (isset($arg[1]) === true && is_array($arg[1]) === false) {
            throw new \Exception("Post argument must be an array", 1);
        }

        // print_r($this->_router->dump());

        $this->_router->getMockController()->getMethod = $name;
        $this->_router->route($arg[0]);

        $_POST = (isset($arg[1]) === true) ? $arg[1] : [];

        ob_start();
        $this->_dispatcher->dispatch($this->_router, $this->_view, $this->_framework);
        $this->_request = ob_get_contents();
        ob_end_clean();

        return $this;
    }

    public function echoBody()
    {
        return $this->_request."\n";
    }

    public function __get($key)
    {
        switch ($key) {
            case 'body':
                return $this->generator->__call('string', array($this->_request));
                break;
            case 'json':
                return $this->generator->__call('array', array(json_decode($this->_request, true)));
                break;
            case 'request':
                return $this->_request;
            case 'data':
                $json = json_decode($this->_request, true);
                return $this->generator->__call('array', [$json['data']]);
            default:
                break;
        }

        return parent::__get($key);
    }
}