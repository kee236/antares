<?PHP



$this->fb = new Facebook\Facebook([
    'app_id' => $this->app_id,
    'app_secret' => $this->app_secret,
    'default_graph_version' => 'v21.0',
    'fileUpload' => true
]);



$permissions = [
    'email', 
    'pages_manage_posts', 
    'pages_manage_engagement', 
    'pages_manage_metadata',
    'pages_read_engagement', 
    'pages_show_list', 
    'pages_messaging', 
    'public_profile', 
    'read_insights',
    'instagram_basic', 
    'instagram_manage_comments',
    'instagram_manage_insights',
    'instagram_content_publish', 
    'instagram_manage_messages'
];



$url = "https://graph.facebook.com/v21.0/debug_token?input_token={$access_token}&access_token={$app_id}|{$app_secret}";




try {
    $request = $this->fb->get('/me/accounts?fields=id,name,access_token', $access_token);
    $response = $request->getGraphEdge()->asArray();
    return $response;
} catch (Facebook\Exceptions\FacebookResponseException $e) {
    return ['error' => 'Facebook API Error', 'message' => $e->getMessage()];
} catch (Facebook\Exceptions\FacebookSDKException $e) {
    return ['error' => 'Facebook SDK Error', 'message' => $e->getMessage()];
}










if ($request->isError()) {
    $errorMsg = $request->getThrownException()->getMessage();
    // บันทึกหรือแสดงผล error ตามความเหมาะสม
}


$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if ($httpCode !== 200) {
    // Handle the error based on the HTTP code
}




libxml_use_internal_errors(true);


curl_setopt($ch, CURLOPT_TIMEOUT, 30); // ลดเวลา timeout
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);



$fields = "cover,picture,id,name";
$requestUrl = "/me/groups?fields=$fields&limit=400&admin_only=1";



if (isset($response['data'])) {
    return $response['data'];
} else {
    return [];
}



private function validateMetaTag($meta, $propertyName) {
    return $meta->getAttribute('property') === $propertyName;
}




public function cta_post(
    $message = "", $link = "", $description = "", $name = "", $cta_type = "", 
    $cta_value = "", $thumbnail = "", $scheduled_publish_time = "", 
    $post_access_token = '', $page_id = '', $og_action_type_id = "", 
    $og_object_id = ""
) {
    $params = [];

    if (!empty($message)) $params['message'] = spintax_process($message);
    if (!empty($link)) $params['link'] = $link;
    if (!empty($description)) $params['description'] = $description;
    if (!empty($thumbnail)) $params['thumbnail'] = $this->fb->fileToUpload($thumbnail);
    if (!empty($name)) $params['name'] = $name;

    $params['call_to_action'] = ["type" => $cta_type, "value" => $cta_value];

    if (!empty($scheduled_publish_time)) {
        $params['scheduled_publish_time'] = $scheduled_publish_time;
        $params['published'] = false;
    }

    try {
        $response = $this->fb->post("{$page_id}/feed", $params, $post_access_token);
        return $response->getGraphObject()->asArray();
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}





public function get_post_permalink($post_id, $post_access_token) {
    try {
        $response = $this->fb->get("{$post_id}?fields=permalink_url", $post_access_token);
        $response_data = $response->getGraphObject()->asArray();

        if (!empty($response_data["permalink_url"])) {
            if (strpos($response_data["permalink_url"], 'facebook.com') === false) {
                $response_data["permalink_url"] = "https://www.facebook.com" . $response_data["permalink_url"];
            }
        }

        return $response_data;

    } catch (Facebook\Exceptions\FacebookResponseException $e) {
        return ['error' => 'API Error: ' . $e->getMessage()];
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        return ['error' => 'SDK Error: ' . $e->getMessage()];
    } catch (Exception $e) {
        return ['error' => 'General Error: ' . $e->getMessage()];
    }
}




class FacebookAPIHandler {

    protected $fb;

    public function __construct($fbInstance) {
        $this->fb = $fbInstance;
    }

    private function executeFbRequest($endpoint, $params = [], $accessToken) {
        try {
            $response = $this->fb->post($endpoint, $params, $accessToken);
            return $response->getGraphObject()->asArray();
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            return ['error' => 'Graph returned an error: ' . $e->getMessage()];
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            return ['error' => 'Facebook SDK returned an error: ' . $e->getMessage()];
        }
    }

    private function getFbData($endpoint, $accessToken) {
        try {
            $response = $this->fb->get($endpoint, $accessToken);
            return $response->getGraphNode()->asArray();
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            return ['error' => 'Graph returned an error: ' . $e->getMessage()];
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            return ['error' => 'Facebook SDK returned an error: ' . $e->getMessage()];
        }
    }

    public function getPrivateReplyMessageIdInfo($privateReplyMessageId, $accessToken) {
        return $this->getFbData("{$privateReplyMessageId}/?fields=id,from,message,to,created_time", $accessToken);
    }

    public function postPhoto($pageId, $accessToken, $message = "", $imagePath = "", $scheduledPublishTime = "") {
        $params = [];
        if ($message) $params['message'] = $message;
        if ($imagePath) $params['source'] = $this->fb->fileToUpload($imagePath);
        if ($scheduledPublishTime) {
            $params['scheduled_publish_time'] = $scheduledPublishTime;
            $params['published'] = false;
        }

        return $this->executeFbRequest("{$pageId}/photos", $params, $accessToken);
    }

    public function postVideo($pageId, $accessToken, $description = "", $fileSource = "", $title = "", $thumbnail = "", $scheduledPublishTime = "") {
        $params = [
            'description' => $description,
            'title' => $title,
            'source' => $this->fb->fileToUpload($fileSource),
            'thumb' => $thumbnail ? $this->fb->fileToUpload($thumbnail) : null,
            'scheduled_publish_time' => $scheduledPublishTime ?: null,
            'published' => $scheduledPublishTime ? false : true,
            'is_crossposting_eligible' => 1,
        ];

        return $this->executeFbRequest("{$pageId}/videos", array_filter($params), $accessToken);
    }

    public function debugAccessToken($inputToken) {
        $url = "https://graph.facebook.com/debug_token?input_token={$inputToken}&access_token={$this->userAccessToken}";
        return json_decode($this->runCurlForFb($url), true);
    }

    private function runCurlForFb($url) {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $url,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_USERAGENT => "Mozilla/5.0",
        ]);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}



public function enable_bot($page_id = '', $post_access_token = '')
{
    if (empty($page_id) || empty($post_access_token)) {
        return ['success' => 0, 'error' => $this->CI->lang->line("Something went wrong, please try again.")];
    }

    try {
        $params = [
            'subscribed_fields' => ["messages", "messaging_optins", "messaging_postbacks", "messaging_referrals", "feed"]
        ];
        $response = $this->fb->post("{$page_id}/subscribed_apps", $params, $post_access_token);
        return array_merge($response->getGraphObject()->asArray(), ['error' => '']);
    } catch (Exception $e) {
        return ['success' => 0, 'error' => $e->getMessage()];
    }
}






public function delete_persistent_menu($post_access_token = '', $media_type = 'fb')
{
    $platform = $media_type === 'instagram' ? "&platform=instagram" : "";
    $url = "https://graph.facebook.com/v4.0/me/messenger_profile?access_token={$post_access_token}{$platform}";

    $data = json_encode(["fields" => ["persistent_menu"]]);
    return $this->execute_curl_request($url, "DELETE", $data);
}







private function execute_curl_request($url, $method = "POST", $data = null)
{
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_HTTPHEADER => ["Content-type: application/json"],
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_USERAGENT => "Mozilla/5.0",
    ]);

    if ($data) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
        curl_close($ch);
        return ['success' => 0, 'error' => $error_msg];
    }

    curl_close($ch);
    return json_decode($response, true);
}




class FacebookAPIHelper {

    private $baseUrl = "https://graph.facebook.com/v4.0";
    private $headers = ["Content-Type: application/json"];

    // ส่ง cURL Request
    private function sendRequest($url, $method = "GET", $data = null) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        if ($method === "POST") {
            curl_setopt($ch, CURLOPT_POST, true);
            if ($data) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            }
        } elseif ($method === "DELETE") {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        }

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            return ['error' => curl_error($ch)];
        }
        curl_close($ch);

        return json_decode($response, true);
    }

    // ส่งข้อความที่ไม่ใช่โปรโมชั่น
    public function sendNonPromotionalMessage($message, $accessToken) {
        $url = "{$this->baseUrl}/me/messages?access_token={$accessToken}";
        return $this->sendRequest($url, "POST", $message);
    }

    // Whitelist Domain
    public function domainWhitelist($accessToken, $domain) {
        $url = "{$this->baseUrl}/me/messenger_profile?fields=whitelisted_domains&access_token={$accessToken}";
        $response = $this->sendRequest($url);

        if (isset($response['error'])) {
            return ['status' => 0, 'result' => $response['error']['message']];
        }

        $domains = isset($response['data'][0]['whitelisted_domains']) ? $response['data'][0]['whitelisted_domains'] : [];
        $domains[] = $domain;

        $updateUrl = "{$this->baseUrl}/me/messenger_profile?access_token={$accessToken}";
        $payload = ['whitelisted_domains' => $domains];
        return $this->sendRequest($updateUrl, "POST", $payload);
    }

    // การสร้างป้ายกำกับ
    public function createLabel($accessToken, $labelName) {
        $url = "{$this->baseUrl}/me/custom_labels?access_token={$accessToken}";
        $payload = ["page_label_name" => $labelName];
        return $this->sendRequest($url, "POST", $payload);
    }
    
    // เพิ่มฟังก์ชันเพิ่มเติมตามความต้องการ...
}




class InstagramAPIHelper {

    private $fb;

    public function __construct($fb) {
        $this->fb = $fb;
    }

    // ตรวจสอบการเชื่อมต่อ Instagram Business Account
    public function checkInstagramAccountById($pageId, $accessToken) {
        try {
            $request = $this->fb->get("{$pageId}?fields=instagram_business_account", $accessToken);
            $response = $request->getGraphObject()->asArray();

            return $response['instagram_business_account']['id'] ?? "";
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            return "Error: " . $e->getMessage();
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            return "SDK Error: " . $e->getMessage();
        }
    }

    // ดึงข้อมูลบัญชี Instagram
    public function getInstagramAccountInfo($accountId, $accessToken) {
        try {
            $request = $this->fb->get("{$accountId}?fields=id,username,followers_count,media_count,website,biography", $accessToken);
            return $request->getGraphObject()->asArray();
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    // ดึงรายการโพสต์จากบัญชี Instagram
    public function getPostListFromInstagramAccount($accountId, $accessToken, $limit = 100) {
        try {
            $request = $this->fb->get("{$accountId}/media?fields=id,timestamp,caption,like_count,comments_count,media_type,media_url,permalink,is_comment_enabled&limit={$limit}", $accessToken);
            return $request->getGraphList()->asArray();
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    // ดึงข้อมูลโพสต์โดยใช้ Media ID
    public function getInstagramPostInfoById($mediaId, $accessToken) {
        try {
            $request = $this->fb->get("{$mediaId}?fields=caption,media_type,timestamp,permalink", $accessToken);
            return $request->getGraphObject()->asArray();
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}



$fb = new \Facebook\Facebook([...]); // กำหนดค่าการเชื่อมต่อ Facebook SDK

$instagramHelper = new InstagramAPIHelper($fb);
$pageId = 'YOUR_PAGE_ID';
$accessToken = 'YOUR_ACCESS_TOKEN';

// ตรวจสอบ Instagram Account
$instagramAccountId = $instagramHelper->checkInstagramAccountById($pageId, $accessToken);
if ($instagramAccountId) {
    echo "Instagram Account ID: " . $instagramAccountId;
}




class InstagramGraphAPI {

    private $fb;

    public function __construct($fb) {
        $this->fb = $fb;
    }

    // ส่งคำขอ GET ไปยัง Facebook Graph API
    private function sendRequest($endpoint, $accessToken) {
        try {
            $response = $this->fb->get($endpoint, $accessToken);
            return $response->getGraphObject()->asArray();
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    // ดึงข้อมูลคอมเมนต์ของโพสต์
    public function getCommentsOfPost($postId, $pageAccessToken, $limit = 20) {
        return $this->sendRequest("{$postId}/comments?fields=id,text,timestamp,username&limit={$limit}", $pageAccessToken);
    }

    // ซ่อนคอมเมนต์
    public function hideComment($commentId, $accessToken) {
        $url = "https://graph.facebook.com/v2.11/{$commentId}?method=post&access_token={$accessToken}&hide=true";
        return $this->runCurlRequest($url);
    }

    // ลบคอมเมนต์
    public function deleteComment($commentId, $accessToken) {
        $url = "https://graph.facebook.com/{$commentId}?access_token={$accessToken}&method=delete";
        return $this->runCurlRequest($url);
    }

    // ส่งคำขอผ่าน cURL สำหรับกรณีที่ Facebook SDK ไม่รองรับ
    private function runCurlRequest($url) {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
        ]);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result, true);
    }

    // ดึงข้อมูลผู้ใช้ Instagram ผ่าน Business Discovery
    public function getBusinessDiscoveryData($accountId, $accessToken, $username) {
        $endpoint = "/{$accountId}?fields=business_discovery.username({$username}){followers_count,media_count}";
        return $this->sendRequest($endpoint, $accessToken);
    }
}

class InstagramGraphAPI {

    private $fb;

    public function __construct($fb) {
        $this->fb = $fb;
    }

    // เปิดหรือปิดการแสดงความคิดเห็นบนสื่อ Instagram
    public function setMediaCommentStatus($mediaId, $userAccessToken, $isEnabled = true) {
        try {
            $response = $this->fb->post(
                "/{$mediaId}",
                ['comment_enabled' => $isEnabled],
                $userAccessToken
            );
            return $response->getGraphObject()->asArray();
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    // ดึงข้อมูลสื่อที่ถูกแท็กสำหรับบัญชีธุรกิจหรือครีเอเตอร์
    public function getTaggedMedia($businessAccountId, $accessToken, $limit = 100) {
        try {
            $response = $this->fb->get(
                "{$businessAccountId}/tags?fields=permalink,media_type,media_url,timestamp,username,caption&limit={$limit}",
                $accessToken
            );
            return $response->getGraphList()->asArray();
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    // สร้างโพสต์ใหม่บน Instagram
    public function createInstagramPost($businessAccountId, $type = "IMAGE", $mediaUrl, $caption = "", $userAccessToken) {
        $isCarousel = is_array($mediaUrl) && count($mediaUrl) > 1;
        $response = $this->createMediaContainer($businessAccountId, $type, $mediaUrl, $caption, $userAccessToken, $isCarousel);

        if (isset($response['status']) && $response['status'] == "error") {
            return ['status' => 'error', 'message' => $response['message']];
        }

        $sleepValue = isset($response['has_video']) && $response['has_video'] == 'yes' ? 30 : 0;
        unset($response['has_video']);

        return $this->publishPostFromContainer($businessAccountId, $response, $userAccessToken, $caption, $sleepValue);
    }

    // ฟังก์ชันช่วยในการสร้าง Media Container (จำลอง)
    private function createMediaContainer($businessAccountId, $type, $mediaUrl, $caption, $userAccessToken, $isCarousel) {
        // Logic สำหรับสร้าง Media Container
        return ['id' => 'container_id', 'has_video' => 'no']; // ตัวอย่างข้อมูลที่คืนค่า
    }

    // ฟังก์ชันช่วยในการโพสต์จาก Media Container (จำลอง)
    private function publishPostFromContainer($businessAccountId, $containerResponse, $userAccessToken, $caption, $sleepValue) {
        sleep($sleepValue);  // ตัวอย่างการหน่วงเวลาในกรณีมีวิดีโอ
        // Logic สำหรับการโพสต์สู่ Instagram
        return ['status' => 'success', 'id' => 'post_id']; // ตัวอย่างข้อมูลที่คืนค่า
    }
}


