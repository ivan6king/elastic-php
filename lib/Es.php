<?php
namespace Ivan\Elastic;

class Es
{
    private $_config;
    private $_index = null;
    private $_mapping = null;
    private $_setting = null;
    private $_document = null;
    private $_url = '';
    public function __construct($_config)
    {
        $this->_config = $_config;
        $this->_index = new \Ivan\Elastic\Index($_config);
        $this->_mapping = new \Ivan\Elastic\Mapping($_config);
        $this->_setting = new \Ivan\Elastic\Setting($_config);
        $this->_document = new \Ivan\Elastic\Document($_config);
        $this->_url = $_config[0]['host'];
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

    public function query($url){
        $result = array('status'=>0,'data'=>'','err'=>'');
        $res = Curl::httpGet($this->_url.$url,false,true);
        if ($res['header']['http_code']==200) {
            $result['status']=1;
            $result['data']=$res['body'];
        }elseif($res['err']!=''){
            throw new \Exception($res['err']);
        }else{
            $result['status']=0;
            $result['data']=$res['body'];
        }
        return $result;
    }

}
