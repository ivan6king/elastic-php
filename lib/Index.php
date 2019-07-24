<?php
namespace Ivan\Elastic;

class Index
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



    /**
     * 判断索引是否存在
     * @return [type] [description]
     */
    public function exists(){
        $res = Curl::httpHead($this->_url.$this->_name);
        if ($res['header']['http_code']==200) {
            return true;
        }elseif($res['err']!=''){
            throw new \Exception($res['err']);
        }else{
            return false;
        }
    }

    public function delete(){
        $result = array('status'=>0,'data'=>'','err'=>'');
        $res = Curl::httpDelete($this->_url.$this->_name);
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
     * 添加索引
     * @param array $params [description]
     */
    public function create($params=array()){
        $result = array('status'=>0,'data'=>'','err'=>'');
        $res = Curl::httpPut($this->_url.$this->_name,json_encode($params));
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
     * 获得索引信息
     * $type = _settings, _mappings, _warmers and _aliases.
     */
    public function getInfo($type=''){
        $result = array('status'=>0,'data'=>'','err'=>'');
        $res = Curl::httpGet($this->_url.$this->_name.'/'.$type,false,true);
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

    public function close(){
        $result = array('status'=>0,'data'=>'','err'=>'');
        $res = Curl::httpPost($this->_url.$this->_name.'/_close',array(),array(),false,true);
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

    public function open(){
        $result = array('status'=>0,'data'=>'','err'=>'');
        $res = Curl::httpPost($this->_url.$this->_name.'/_open',array(),array(),false,true);
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

    public function getAll(){
        $res = Curl::httpGet($this->_url.'_cat/indices/',false,true);
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

    public function search($search){
        // $res = Curl::httpGet($this->_url.'_cat/indices/',false,true);
    }

}
