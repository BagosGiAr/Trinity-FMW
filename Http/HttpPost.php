<?php

/**
 * A Class that Generaly Describes each HttpRequest
 * @author Pappas Evangelos - papas.evagelos@gmail.com
 * @copyright 2010
 * @constructor HttpPost()
 */
class HttpPost extends HttpRequest
{
    private $link;
    

    /**
     *
     * @param String $url
     * @param Array $data
     * @param Array $optional_headers
     */
    function  __construct($url,$data=array(),$optHeaders = array())
    {
    }

    function fsockPost($url,$data)
    {
        $postdata ="";
        //Parse url
        $web=parse_url($url);
        //build post string
        foreach($data as $i=>$v)
        {
            $postdata.= $i . "=" . urlencode($v) . "&";
        }
        $postdata.="cmd=_notify-validate";
        //Set the port number
        if($web[scheme] == "https")
        {
            $web[port]="443";
            $ssl="ssl://";
        }
        else
        {
            $web[port]="80";
        }
        $ssl='';
        $errnum='';
        $errstr='';
        //Create paypal connection
        $fp=@fsockopen($ssl . $web[host],$web[port],$errnum,$errstr,30);
        //Error checking
        $info=array();
        if(!$fp)
        {
            echo "$errnum: $errstr";
        }
        //Post Data
        else
        {
            fputs($fp, "POST $web[path] HTTP/1.1\r\n");
            fputs($fp, "Host: $web[host]\r\n");
            fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
            fputs($fp, "Content-length: ".strlen($postdata)."\r\n");
            fputs($fp, "Connection: close\r\n\r\n");
            fputs($fp, $postdata . "\r\n\r\n");
            //loop through the response from the server
            
            while(!feof($fp))
            {
                $info[]=@fgets($fp, 1024);
            }
            //close fp - we are done with it
            fclose($fp);
            //break up results into a string
            $info=implode(",",$info);
        }
        return $info;
    }

    public function close()
    {

    }
    public function connect() 
    {
        
    }
    public function getError()
    {

    }
    public function setError($err)
    {
        
    }
    public function setHeader($headerParam)
    {
        
    }
}
?>
