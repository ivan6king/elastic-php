<?php
namespace Ivan\Elastic;

class Curl {

    public static function httpGet($url,$header=false,$body=true,$timeout=10){
        $response = array('header'=>false,'body'=>false,'err'=>'');
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_TIMEOUT,$timeout);
        curl_setopt( $ch, CURLOPT_HEADER, $header );
        curl_setopt( $ch, CURLOPT_NOBODY, !$body );
        $response['body'] = curl_exec( $ch );
        $response['err'] = $response['body']===false?curl_error($ch):'';
        $response['header'] = curl_getinfo($ch);
        curl_close($ch);
        return $response;
    }

    public static function httpPost($url,$params=array(),$header=false,$body=false,$timeout=10) {
        // $postData = json_encode($params);
        $postData = is_array($params)?json_encode($params):$params;
        $ch = curl_init();  
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_HEADER, $header); 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        if(!is_array($params)){
            curl_setopt($ch, CURLOPT_BINARYTRANSFER,true);
        }
        curl_setopt( $ch, CURLOPT_NOBODY, !$body ); 
        curl_setopt( $ch, CURLOPT_TIMEOUT,$timeout);
        $response['body'] = curl_exec( $ch );
        $response['err'] = $response['body']===false?curl_error($ch):'';
        $response['header'] = curl_getinfo($ch);
        curl_close($ch);
        return $response;
    }

    

    public static function httpHead($url,$header=false,$body=false,$timeout=10){
        $response = array('header'=>false,'body'=>false,'err'=>'');
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'HEAD' );
        curl_setopt( $ch, CURLOPT_TIMEOUT,$timeout);
        curl_setopt( $ch, CURLOPT_HEADER, $header );
        curl_setopt( $ch, CURLOPT_NOBODY, !$body );

        $response['body'] = curl_exec( $ch );
        $response['err'] = $response['body']===false?curl_error($ch):'';
        $response['header'] = curl_getinfo($ch);
        curl_close($ch);
        return $response;
    }


    public static function httpPut($url,$fields='',$header=false,$body=true,$timeout=10){
        $response = array('header'=>false,'body'=>false);
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'PUT' );
        curl_setopt( $ch, CURLOPT_TIMEOUT,$timeout);
        curl_setopt( $ch, CURLOPT_HEADER, $header );
        curl_setopt( $ch, CURLOPT_NOBODY, !$body );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Length: ' . strlen($fields))); 
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $fields);

        $response['body'] = curl_exec( $ch );
        $response['err'] = $response['body']===false?curl_error($ch):'';
        $response['header'] = curl_getinfo($ch);
        curl_close($ch);
        return $response;
    }

    public static function httpDelete($url,$header=false,$body=true,$timeout=10){
        $response = array('header'=>false,'body'=>false,'err'=>'');
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'DELETE' );
        curl_setopt( $ch, CURLOPT_TIMEOUT,$timeout);
        curl_setopt( $ch, CURLOPT_HEADER, $header );
        curl_setopt( $ch, CURLOPT_NOBODY, !$body );

        $response['body'] = curl_exec( $ch );
        $response['err'] = $response['body']===false?curl_error($ch):'';
        $response['header'] = curl_getinfo($ch);
        curl_close($ch);
        return $response;
    }
}