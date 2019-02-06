<?php
// Facade for cURL class, used to obtain only HTML and HTTP status code
class URL {
    private $ch = NULL;

    public $returndata = '';

    private $defaults = array(
        CURLOPT_HEADER => 0,
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_HTTPHEADER => array(
            "Accept-Language: et,en-us,en;q=0.5",
            "Accept-Encoding: identity",
            "Accept-Charset: ISO-8859-1,UTF-8,ASCII,Latin 1;q=0.7,*;q=0.7",
            "Accept: application/json,text/plain,text/html,application/xhtml+xml,text/xml,application/xml,text/javascript,application/javascript;q=0.9,*/*;q=0.8",
            "Connection: keep-alive" ),
        CURLOPT_QUOTE => array(),
        CURLOPT_HTTP200ALIASES=> array(),
        CURLOPT_POSTQUOTE=> array(),
        CURLOPT_USERAGENT => 'AdoptapediaBot/1.0 (+https://adoptapedia.com/)',
        CURLOPT_HTTPGET => TRUE
    );

    public function __construct($url)
    {
        $this->ch = curl_init($url);
        curl_setopt_array($this->ch, $this->defaults);
        $this->returndata = curl_exec($this->ch);
    }

    public function getData() {
        return $this->returndata;
    }

    public function getResponseType() {
        return curl_getinfo($this->ch)['http_code'] ;
    }

    public function __destruct() {
        curl_close($this->ch);
    }
}