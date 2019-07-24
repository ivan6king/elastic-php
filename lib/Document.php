<?php
namespace Ivan\Elastic;

class Document
{
    private $_config = null;
    private $_name = null;
    private $_url = '';
    private $_user = '';
    private $_passwd = '';
    private $_req_header = array();

    public function __construct($config) {
        $this->_config = $config;
        $this->_url = $config[0]['host'];
        $this->_user = $config[0]['user'];
        $this->_passwd = $config[0]['passwd'];
        $this->setReqHeader();
    }

    public function setReqHeader(){
        $token = $this->basicAuthHeaderValue();
        $this->_req_header = [
            'Content-Type:application/json',
            "Authorization:Basic {$token}"
        ];
    }

    private function basicAuthHeaderValue(){
        $token = base64_encode($this->_user . ":" . $this->_passwd);
        return $token;
    }

    public function setIndex($name){
        $this->_name = $name;
    }


    /**
     * 添加文档/更新文档
     * @param [type]  $id     [description]
     * @param boolean $params [description]
     */
    public function add($id,$params=false){
        if ($id!='') {
            $res = $this->putAdd($id,$params);
        }else{
            $res = $this->postAdd($params);
        }
        // $res = $id!=''?$this->putAdd($id,$params):$this->postAdd($params);
        return $res;
    }

    private function putAdd($id,$params){
        $result = array('status'=>0,'data'=>'','err'=>'');
        $res = Curl::httpPut($this->_url.$this->_name.'/'.$id,json_encode($params),false,true);
        if ($res['header']['http_code']==201) {
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
    private function postAdd($params){
        $result = array('status'=>0,'data'=>'','err'=>'');
        // $res = Curl::httpPost($this->_url.$this->_name.'/',json_encode($params),array(),array(),false,true);
        $res = Curl::httpPost($this->_url.$this->_name.'/',$params,$this->_req_header,false,true);
        if ($res['header']['http_code']==201) {
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


    public function get($id,$source=false){
        $result = array('status'=>0,'data'=>'','err'=>'');
        $url = $source==false?$this->_url.$this->_name.'/'.$id:$this->_url.$this->_name.'/'.$id.'/_source';
        $res = Curl::httpGet($url,false,true);
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
    public function exists($id){
        $res = Curl::httpHead($this->_url.$this->_name.'/'.$id);
        if ($res['header']['http_code']==200) {
            return true;
        }elseif($res['err']!=''){
            throw new \Exception($res['err']);
        }else{
            return false;
        }
    }

    public function delete($id){
        $result = array('status'=>0,'data'=>'','err'=>'');
        $res = Curl::httpDelete($this->_url.$this->_name."/".$id);
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

    public function bulk($str){
        $result = array('status'=>0,'data'=>'','err'=>'');
        if(!strstr(substr($str, -2), PHP_EOL)) {
            $str = $str."\n";
        }
        // $res = Curl::httpPost($this->_url.$this->_name.'/',json_encode($params),false,true);
        $res = Curl::httpPost($this->_url.'_bulk',$str,$this->_req_header,false,true);
        if ($res['header']['http_code']==200 ) {
            $fbody = json_decode($res['body'],true);
            $result['status'] = $fbody['errors']==false?1:0;
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
