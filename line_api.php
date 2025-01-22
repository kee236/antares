public function send_line_message($to, $message)
{
    $url = 'https://api.line.me/v2/bot/message/push';
    $headers = [
        'Authorization: Bearer YOUR_CHANNEL_ACCESS_TOKEN',
        'Content-Type: application/json',
    ];
    $data = [
        'to' => $to,
        'messages' => [['type' => 'text', 'text' => $message]],
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}