<?php
defined('BASEPATH') OR exit('No direct script access allowed');

abstract class  Oauth
{
	protected $ci;
    public $client_id =null;
    public $redirect_uri =null;
    public $client_secret = null;

    protected $state;
    protected $code;
    protected $user_profile_url;
	public function __construct()
	{
        $this->ci =& get_instance();
	}
	public abstract function request_auth();
	public abstract function login_callback();

	protected function curl_bearer($url,$access_token)
	{
		$ch = curl_init();
        $auth = array("Authorization: Bearer {$access_token}");
        curl_setopt($ch, CURLOPT_URL, $url );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $auth );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt($ch, CURLOPT_COOKIE, '' );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3); //seconds
        $result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}
	protected function curl($url,$post=null)
    {
        $ch = curl_init(); 
        curl_setopt ($ch, CURLOPT_URL,$url); //접속할 URL 주소 
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, false); // 인증서 체크같은데 true 시 안되는 경우가 많다. 
        // default 값이 true 이기때문에 이부분을 조심 (https 접속시에 필요) 
        curl_setopt ($ch, CURLOPT_SSLVERSION,4); // SSL 버젼 (https 접속시에 필요) 
        curl_setopt ($ch, CURLOPT_HEADER, 0); // 헤더 출력 여부 
		curl_setopt ($ch, CURLOPT_POST, 0); // Post Get 접속 여부 
		if($post !== null)
		{
			curl_setopt ($ch, CURLOPT_POSTFIELDS, $post); // Post 값  Get 방식처럼적는다. 
		}
        // curl_setopt ($ch, CURLOPT_POSTFIELDS, "latlng=37,126.961452&key=AIzaSyDG0o9eNwx-e019j2Xe-yBdwrSojDr29eY"); // Post 값  Get 방식처럼적는다. 
        curl_setopt ($ch, CURLOPT_TIMEOUT, 30); // TimeOut 값 
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); // 결과값을 받을것인지 
        $infos = curl_exec ($ch); 
        curl_close ($ch); 
        $infos = json_decode($infos);
        return $infos;
    }
}

/* End of file Api.php */
/* Location: .//C/Users/이재윤/Desktop/01shortcut/03libraries/Api.php */
