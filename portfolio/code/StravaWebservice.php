<?php
class StravaWebservice extends Controller {
    private $cURL;

    public function __construct() {
        $this->initCurl();
        parent::__construct();
    }

    private static $allowed_actions = array('getActivities' => true);

    private function initCurl() {
        $this->cURL = curl_init();
        $options = array(
            CURLOPT_TIMEOUT => 30,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => false
        );
        curl_setopt_array($this->cURL, $options);
    }

    private function executeCurl($url) {
        curl_setopt($this->cURL, CURLOPT_URL, $url);

        $response = curl_exec($this->cURL);
        $http_status = curl_getinfo($this->cURL, CURLINFO_HTTP_CODE);

        if($http_status==200){
            return $response;
        }
        curl_close($this->cURL);
    }

    public function getActivities() {
        $url = 'https://www.strava.com/api/v3/athletes/'.$this->config()->id.'/activities?access_token=83ebeabdec09f6670863766f792ead24d61fe3f9';
        return $this->executeCurl($url);
    }
} 