<?php
class Tiktok_api
{
    private $api_key;

    public function __construct()
    {
        // กำหนดค่า API Key
        $this->api_key = 'YOUR_TIKTOK_API_KEY';
    }

    public function post_video($video_path, $caption)
    {
        // เรียก API ของ TikTok เพื่ออัปโหลดวิดีโอ
        $url = 'https://open.tiktokapis.com/v1/videos/upload';
        $headers = [
            'Authorization: Bearer ' . $this->api_key,
            'Content-Type: multipart/form-data',
        ];
        $post_fields = [
            'video' => new CURLFile($video_path),
            'caption' => $caption,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code == 200) {
            return ['status' => 'success', 'data' => json_decode($response, true)];
        } else {
            return ['status' => 'error', 'message' => 'Failed to post video on TikTok.'];
        }
    }
}