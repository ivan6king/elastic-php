<?php
namespace Ivan\Elastic;

class Es
{
    private $_config;
    private $_index = null;
    private $_mapping = null;
    private $_setting = null;
    private $_document = null;
    public function __construct($_config)
    {
        $this->_config = $_config;
        $this->_index = new \Ivan\Elastic\Index($_config);
        $this->_mapping = new \Ivan\Elastic\Mapping($_config);
        $this->_setting = new \Ivan\Elastic\Setting($_config);
        $this->_document = new \Ivan\Elastic\Document($_config);
    }

    public function index($name=''){
        if($name!=''){
            $this->_index->setIndex($name);
        }
        return $this->_index;
    }


    public function mapping($name=''){
        if($name!=''){
            $this->_mapping->setIndex($name);
        }
        return $this->_mapping;
    }  
    public function setting($name=''){
        if($name!=''){
            $this->_setting->setIndex($name);
        }
        return $this->_setting;
    }  
    public function document($name=''){
        $this->_document->setIndex($name);
        return $this->_document;
    }

}
