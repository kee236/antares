<?php  

/*

function loginForUserAccessToken($redirectUrl = "")
{
    $redirectUrl = rtrim($redirectUrl, '/');
    $helper = $this->fb->getRedirectLoginHelper();

    // กำหนดสิทธิ์ที่ต้องการ
    $permissions = [
        'email',
        'public_profile',
        'pages_manage_metadata',
        'pages_show_list',
        'pages_manage_engagement',
        'pages_read_user_content',
        'pages_manage_posts',
        'read_insights',
        'pages_read_engagement',
        'business_management',
        'pages_messaging',
        'pages_user_gender',
        'pages_user_locale',
        'pages_user_timezone',
        'human_agent', // เพิ่มสิทธิ์ Human Agent
        'business_asset_user_profile_access' // เพิ่มสิทธิ์ Business Asset User Profile Access
    ];

    // เพิ่มสิทธิ์เพิ่มเติมสำหรับโพสต์กลุ่มหากเปิดใช้งาน
    if ($this->CI->config->item('facebook_poster_group_enable_disable') === '1' && $this->CI->is_group_posting_exist) {
        array_push($permissions, 'publish_to_groups');
    }

    // เพิ่มสิทธิ์ Instagram หากเปิดใช้งาน
    if ($this->CI->config->item('instagram_reply_enable_disable') === '1') {
        array_push(
            $permissions,
            'instagram_basic',
            'instagram_manage_comments',
            'instagram_manage_insights',
            'instagram_content_publish',
            'instagram_manage_messages'
        );
    }

    // สร้าง URL สำหรับการ Login
    $loginUrl = $helper->getLoginUrl($redirectUrl, $permissions);

    return '<a class="btn btn-block btn-social btn-facebook" href="' . htmlspecialchars($loginUrl) . '">
                <span class="fab fa-facebook"></span> Login with Facebook
            </a>';
}



$permissions = [
    'email',
    'public_profile',
    'pages_manage_metadata',
    'pages_show_list',
    'pages_manage_engagement',
    'pages_read_user_content',
    'pages_manage_posts',
    'read_insights',
    'pages_read_engagement',
    'business_management',
    'pages_messaging',
    'pages_user_gender',
    'pages_user_locale',
    'pages_user_timezone',
    'business_asset_user_profile_access',
    'human_agent'
];

*/
include("Facebook/autoload.php");

class Fb_rx_login
{				
	public $database_id=""; 
	public $app_id="";
	public $app_secret="";		
	public $user_access_token="";
	public $fb;


	function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->database();
		$this->CI->load->helper('my_helper');
		$this->CI->load->library('session');

		$this->CI->load->model('basic');
		$this->database_id=$this->CI->session->userdata("fb_rx_login_database_id");

		if($this->CI->session->userdata("social_login_session_set") == 1)
		{
			$facebook_config=$this->CI->basic->get_data("facebook_rx_config",array("where"=>array("status"=>"1"),$select='',$join='',$limit=1,$start=NULL,$order_by=rand()));

			if(empty($facebook_config)) $this->database_id='';
			else
			{
				$config_id = isset($facebook_config[0]) ? $facebook_config[0]['id'] : 0;
				$this->database_id = $config_id;
				$this->CI->session->unset_userdata('social_login_session_set');
				$this->CI->session->set_userdata('return_configid_used_for_social_login',$config_id);
			}
		}

		if($this->CI->uri->segment(1)!='social_apps')
		{
		    if($this->CI->session->userdata("user_type")=="Admin" && ($this->database_id=="" || $this->database_id==0)) 
    		{
    			echo "<h3 align='center' style='font-family:arial;line-height:35px;margin:20px;padding:20px;border:1px solid #ccc;'>Hello Admin : No Facebook app configuration found. You have to  <a href='".base_url("social_apps/facebook_settings")."'> add facebook app & login with facebook</a>. If you just added your first app and redirected here again then <a href='".base_url("home/logout")."'> logout</a>, login again and <a href='".base_url("social_apps/facebook_settings")."'> go to this link</a> to login with facebook for your just added app.</h3>";
    			exit();
    		}
    
    		if($this->CI->session->userdata("user_type")=="Member" && ($this->database_id=="" || $this->database_id==0) && $this->CI->config->item("backup_mode")==1) 
    		{
    			echo "<h3 align='center' style='font-family:arial;line-height:35px;margin:20px;padding:20px;border:1px solid #ccc;'>Hello user : No Facebook app configuration found. You have to  <a href='".base_url("social_apps/facebook_settings")."'> add facebook app & login with facebook</a>. If you just added your first app and redirected here again then <a href='".base_url("home/logout")."'> logout</a>, login again and <a href='".base_url("social_apps/facebook_settings")."'> go to this link</a> to login with facebook for your just added app.</h3>";
    			exit();
    		}

    		if($this->CI->session->userdata("user_type")=="Member" && ($this->database_id=="" || $this->database_id==0) && $this->CI->config->item("backup_mode")==0) 
    		{
    			echo "<h3 align='center' style='font-family:arial;line-height:35px;margin:20px;padding:20px;border:1px solid #ccc;'>Hello User : No Facebook app configuration found. Please contact admin to setup app for the system.</h3>";
    			exit();
    		}
		}

		if($this->database_id != '')
		{
			$facebook_config=$this->CI->basic->get_data("facebook_rx_config",array("where"=>array("id"=>$this->database_id)));
			if(isset($facebook_config[0]))
			{
				if(isset($facebook_config[0]['developer_access']) && $facebook_config[0]['developer_access'] == '1')
				{
					$encrypt_method = "AES-256-CBC";
					$secret_key = 't8Mk8fsJMnFw69FGG5';
					$secret_iv = '9fljzKxZmMmoT358yZ';
					$key = hash('sha256', $secret_key);
					$iv = substr(hash('sha256', $secret_iv), 0, 16);
					$this->app_id = openssl_decrypt(base64_decode($facebook_config[0]["api_id"]), $encrypt_method, $key, 0, $iv);
					$this->app_secret = openssl_decrypt(base64_decode($facebook_config[0]["api_secret"]), $encrypt_method, $key, 0, $iv);
					$this->user_access_token=$facebook_config[0]["user_access_token"];
				}	
				else
				{					
					$this->app_id=$facebook_config[0]["api_id"];
					$this->app_secret=$facebook_config[0]["api_secret"];
					$this->user_access_token=$facebook_config[0]["user_access_token"];
				}		
				if (session_status() == PHP_SESSION_NONE) 
				{
				    session_start();
				}
		
				$this->fb = new Facebook\Facebook([
					'app_id' => $this->app_id, 
					'app_secret' => $this->app_secret,
					'default_graph_version' => 'v21.0',
					'fileUpload'	=>TRUE
					]);
			}
		}


	}
	
	
	
	public function app_initialize($fb_rx_login_database_id){
	    
	    $this->database_id=$fb_rx_login_database_id;
	    $facebook_config=$this->CI->basic->get_data("facebook_rx_config",array("where"=>array("id"=>$this->database_id)));
		if(isset($facebook_config[0]))
		{			
			if(isset($facebook_config[0]['developer_access']) && $facebook_config[0]['developer_access'] == '1')
			{
				$encrypt_method = "AES-256-CBC";
				$secret_key = 't8Mk8fsJMnFw69FGG5';
				$secret_iv = '9fljzKxZmMmoT358yZ';
				$key = hash('sha256', $secret_key);
				$iv = substr(hash('sha256', $secret_iv), 0, 16);
				$this->app_id = openssl_decrypt(base64_decode($facebook_config[0]["api_id"]), $encrypt_method, $key, 0, $iv);
				$this->app_secret = openssl_decrypt(base64_decode($facebook_config[0]["api_secret"]), $encrypt_method, $key, 0, $iv);
				$this->user_access_token=$facebook_config[0]["user_access_token"];
			}	
			else
			{					
				$this->app_id=$facebook_config[0]["api_id"];
				$this->app_secret=$facebook_config[0]["api_secret"];
				$this->user_access_token=$facebook_config[0]["user_access_token"];
			}
			if (session_status() == PHP_SESSION_NONE) 
			{
			    session_start();
			}
	
			$this->fb = new Facebook\Facebook([
				'app_id' => $this->app_id, 
				'app_secret' => $this->app_secret,
				'default_graph_version' => 'v21.0',
				'fileUpload'	=>TRUE
				]);
		}
		
	    
	}


	function login_for_user_access_token($redirect_url="")
	{	
		$redirect_url=rtrim($redirect_url,'/');

		$helper = $this->fb->getRedirectLoginHelper();

		if($this->CI->config->item('facebook_poster_group_enable_disable') == '1' && $this->CI->is_group_posting_exist)
			$permissions = ['email','pages_manage_posts','pages_manage_engagement','pages_manage_metadata','pages_read_engagement','pages_show_list','pages_messaging','public_profile','publish_to_groups','read_insights'];
		else
			$permissions = ['email','pages_manage_posts','pages_manage_engagement','pages_manage_metadata','pages_read_engagement','pages_show_list','pages_messaging','public_profile','read_insights'];

		// if($this->CI->basic->is_exist("add_ons",array("project_id"=>41)))
			// array_push($permissions, 'publish_video');

		if($this->CI->config->item('instagram_reply_enable_disable') == '1')
			array_push($permissions, 'instagram_basic','instagram_manage_comments','instagram_manage_insights','instagram_content_publish','instagram_manage_messages');


		$loginUrl = $helper->getLoginUrl($redirect_url, $permissions);
		
		return '<a class="btn btn-block btn-social btn-facebook" href="'.htmlspecialchars($loginUrl).'"><span class="fab fa-facebook"></span> ThisIsTheLoginButtonForFacebook</a>';	
	}


	public function login_callback_without_email($redirect_url="")
	{
		$redirect_url=rtrim($redirect_url,'/');
		$helper = $this->fb->getRedirectLoginHelper();
		try {
			$accessToken = $helper->getAccessToken($redirect_url);
			$response = $this->fb->get('/me?fields=id,name', $accessToken);

			$user = $response->getGraphUser()->asArray();
		} catch(Facebook\Exceptions\FacebookResponseException $e) {

			$user['status']="0";
			$user['message']= $e->getMessage();
			return $user;

		} catch(Facebook\Exceptions\FacebookSDKException $e) {
			$user['status']="0";
			$user['message']= $e->getMessage();
			return $user;
		}

		$access_token	= (string) $accessToken;
		$access_token = $this->create_long_lived_access_token($access_token);

		$user["access_token_set"]=$access_token;

		return $user;
	}


	public function login_callback($redirect_url="")
	{
		$redirect_url=rtrim($redirect_url,'/');
		$helper = $this->fb->getRedirectLoginHelper();
		try {
			$accessToken = $helper->getAccessToken($redirect_url);
			$response = $this->fb->get('/me?fields=id,name,email', $accessToken);

			$user = $response->getGraphUser()->asArray();
		} catch(Facebook\Exceptions\FacebookResponseException $e) {

			$user['status']="0";
			$user['message']= $e->getMessage();
			return $user;

		} catch(Facebook\Exceptions\FacebookSDKException $e) {
			$user['status']="0";
			$user['message']= $e->getMessage();
			return $user;
		}

		$access_token	= (string) $accessToken;
		$access_token = $this->create_long_lived_access_token($access_token);

		$user["access_token_set"]=$access_token;

		return $user;
	}



	public function app_id_secret_check()
	{
		if($this->app_id == '' || $this->app_secret == '') return 'not_configured';
	}

	function access_token_validity_check(){

		$access_token=$this->user_access_token;
		$client_id=$this->app_id;
		$result=array();
		$url="https://graph.facebook.com/v21.0/oauth/access_token_info?client_id={$client_id}&access_token={$access_token}";

		$headers = array("Content-type: application/json");

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_URL, $url);
		// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
		curl_setopt($ch, CURLOPT_COOKIEJAR,'cookie.txt');  
		curl_setopt($ch, CURLOPT_COOKIEFILE,'cookie.txt');  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3"); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 

		$st=curl_exec($ch); 
		$result=json_decode($st,TRUE);
		if(!isset($result["error"]) && isset($result["access_token"]) && $result["access_token"]!='') return 1;
		else return 0;

	}



	function access_token_validity_check_for_user($access_token){

		$client_id=$this->app_id;
		$result=array();
		$url="https://graph.facebook.com/v21.0/oauth/access_token_info?client_id={$client_id}&access_token={$access_token}";

		$headers = array("Content-type: application/json");

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_URL, $url);
		// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
		curl_setopt($ch, CURLOPT_COOKIEJAR,'cookie.txt');  
		curl_setopt($ch, CURLOPT_COOKIEFILE,'cookie.txt');  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3"); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 

		$st=curl_exec($ch); 

		$result=json_decode($st,TRUE);

		if(!isset($result["error"])) return 1;
		else return 0;

	}



	public function create_long_lived_access_token($short_lived_user_token){

		$app_id=$this->app_id;
		$app_secret=$this->app_secret;
		$short_token=$short_lived_user_token;

		$url="https://graph.facebook.com/v21.0/oauth/access_token?grant_type=fb_exchange_token&client_id={$app_id}&client_secret={$app_secret}&fb_exchange_token={$short_token}";

		$headers = array("Content-type: application/json");

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_URL, $url);
		// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
		curl_setopt($ch, CURLOPT_COOKIEJAR,'cookie.txt');  
		curl_setopt($ch, CURLOPT_COOKIEFILE,'cookie.txt');  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3"); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 

		$st=curl_exec($ch); 
		$result=json_decode($st,TRUE);

		$access_token=isset($result["access_token"]) ? $result["access_token"] : "";

		return $access_token;

	}



	public function facebook_api_call($url){

		$headers = array("Content-type: application/json");

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_URL, $url);
		// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
		curl_setopt($ch, CURLOPT_COOKIEJAR,'cookie.txt');  
		curl_setopt($ch, CURLOPT_COOKIEFILE,'cookie.txt');  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3"); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 

		$st=curl_exec($ch); 

		return  $results=json_decode($st,TRUE);	 
	}

	public function get_page_list($access_token="")
	{

		$error=false;
		try {

			$request = $this->fb->get('/me/accounts?fields=cover,emails,picture,id,name,url,username,access_token&limit=400', $access_token);	
			$response = $request->getGraphList()->asArray();
			return $response;
		} catch(Facebook\Exceptions\FacebookResponseException $e) {

			$error=true;

		} catch(Facebook\Exceptions\FacebookSDKException $e) {
			$error=true;
		}


		if($error)
		{
			
			try {

				$request = $this->fb->get('/me/accounts?fields=cover,emails,picture,id,name,url,username,access_token&limit=400', $access_token);	
				$response = $request->getGraphList()->asArray();
				return $response;
			}

			catch(Facebook\Exceptions\FacebookResponseException $e) {
				$response['error']='1';
				$response['message']= $e->getMessage();
				return $response; 
			}

			catch(Facebook\Exceptions\FacebookSDKException $e) {
				$response['error']='1';
				$response['message']= $e->getMessage();
				return $response; 
			}


		}

		
	}


	public function get_page_insight_info($access_token,$metrics,$page_id){
		
		$from = date('Y-m-d', strtotime(date('Y-m-d').' -28 day'));
        $to   = date('Y-m-d', strtotime(date("Y-m-d").'-1 day'));
		$request = $this->fb->get("/{$page_id}/{$metrics}?&since=".$from."&until=".$to,$access_token);
		$response = $request->getGraphList()->asArray();
		return $response;
		 
	}


	public function get_group_list($access_token="")
	{		

		$error=false;
		try {

			$request = $this->fb->get('/me/groups?fields=cover,picture,id,name&limit=400&admin_only=1', $access_token);	
			$response_group = $request->getGraphList()->asArray();		
			return $response_group;
		} catch(Facebook\Exceptions\FacebookResponseException $e) {

			$error=true;

		} catch(Facebook\Exceptions\FacebookSDKException $e) {
			$error=true;
		}

		if($error)
		{
			$request = $this->fb->get('/me/groups?fields=cover,emails,picture,id,name,url,username,access_token,accounts,perms,category&limit=400', $access_token);	
			$response_group = $request->getGraphList()->asArray();		
			return $response_group;
		}

	}


	public function send_user_roll_access($app_id,$user_id, $user_access_token)
	{
		$url="https://graph.facebook.com/{$app_id}/roles?user={$user_id}&role=testers&access_token={$user_access_token}&method=post";
		$resuls = $this->run_curl_for_fb($url);
		return json_decode($resuls,TRUE);
	}


	public function run_curl_for_fb($url)
	{
		$headers = array("Content-type: application/json"); 
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_URL, $url);
		// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
		curl_setopt($ch, CURLOPT_COOKIEJAR,'cookie.txt');  
		curl_setopt($ch, CURLOPT_COOKIEFILE,'cookie.txt');  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3"); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		$results=curl_exec($ch); 	   
		return  $results;   
	}


	public function get_videolist_from_fb_page($page_id,$access_token)
	{
		$url = "https://graph.facebook.com/$page_id/videos?access_token=$access_token&fields=is_crossposting_eligible,description,created_time,permalink_url,picture";
		$video_list = $this->run_curl_for_fb($url);
		return json_decode($video_list,TRUE);
	}

	public function get_crosspost_whitelisted_pages($page_id,$access_token)
	{
		$url = "https://graph.facebook.com/$page_id/crosspost_whitelisted_pages?access_token=$access_token&limit=200";
		$whitelisted_pages = $this->run_curl_for_fb($url);
		return json_decode($whitelisted_pages,TRUE);
	}


	public function get_postlist_from_fb_page($page_id,$access_token)
	{
		$request = $this->fb->get("$page_id/posts?fields=id,message,permalink_url,picture,created_time&limit=50", $access_token);	
		$response = $request->getGraphList()->asArray();

		$response= json_encode($response);
		$response=json_decode($response,true);

		$final_data['data']=$response;
		return $final_data;
	}
	

	function get_meta_tag_fb($url)
	{  
		$html=$this->run_curl_for_fb($url);	  
		$doc = new DOMDocument();
		@$doc->loadHTML('<meta http-equiv="content-type" content="text/html; charset=utf-8">'.$html);
		$nodes = $doc->getElementsByTagName('title');	  
		if(isset($nodes->item(0)->nodeValue))
			$title = $nodes->item(0)->nodeValue;
		else  $title="";

		$response=array('title'=>'','image'=>'','description'=>'','author'=>'');


		$response['title']=$title;
		$org_desciption="";

		$metas = $doc->getElementsByTagName('meta');

		for ($i = 0; $i < $metas->length; $i++)
		{
			$meta = $metas->item($i);	   
			if($meta->getAttribute('property')=='og:title')
				$response['title'] = $meta->getAttribute('content');		    
			if($meta->getAttribute('property')=='og:image')
				$response['image'] = $meta->getAttribute('content');		    
			if($meta->getAttribute('property')=='og:description')
				$response['description'] = $meta->getAttribute('content');		   
			if($meta->getAttribute('name')=='author')
				$response['author'] = $meta->getAttribute('content');		    
			if($meta->getAttribute('name')=='description')
				$org_desciption =  $meta->getAt