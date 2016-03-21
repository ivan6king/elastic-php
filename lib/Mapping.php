<?php
namespace Ivan\Elastic;

class Mapping
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



    public function add($type,$params=false){
        $result = array('status'=>0,'data'=>'','err'=>'');
        $res = Curl::httpPut($this->_url.$this->_name.'/_mapping/'.$type,json_encode($params));
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

    public function get($type=''){
        $result = array('status'=>0,'data'=>'','err'=>'');
        $res = Curl::httpGet($this->_url.$this->_name.'/_mapping/'.$type,false,true);
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

    /**
     * 判断索引是否存在
     * @return [type] [description]
     */
    public function exists($type){
        $res = Curl::httpHead($this->_url.$this->_name.'/'.$type);
        if ($res['header']['http_code']==200) {
            return true;
        }elseif($res['err']!=''){
            throw new \Exception($res['err']);
        }else{
            return false;
        }
    }

}
