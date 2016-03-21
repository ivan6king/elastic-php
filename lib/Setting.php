<?php
namespace Ivan\Elastic;

class Setting
{
    private $_config = null;
    private $_name = null;
    private $_url = '';
    public function __construct($config) {
        $this->_config = $config;
        $this->_url = $config[0]['host'];
    }

    public function setIndex($name){
        $this->_name = $name;
    }

    public function get(){
        $result = array('status'=>0,'data'=>'','err'=>'');
        $res = Curl::httpGet($this->_url.$this->_name.'/_settings',false,true);
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


    public function update($params){
        $result = array('status'=>0,'data'=>'','err'=>'');
        $res = Curl::httpPut($this->_url.$this->_name.'/_settings',json_encode($params));
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
