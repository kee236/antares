<?php

require_once("application/controllers/Home.php"); // loading home controller

class Integration extends Home
{
    public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('logged_in') != 1) {
            redirect('home/login', 'location');
        }

        $this->load->helper('form');
        $this->load->library('upload');

        $this->important_feature();
    }

    public function index()
    {
        $this->integration_menu_section();
    }

    public function integration_menu_section()
    {
        $data['body'] = 'api_channels';
        $data['page_title'] = $this->lang->line('API Channels');

        // API credentials sections for TikTok, WhatsApp, Line, OpenAI, and Gemini
        $data['api_integrations'] = [
            'tiktok' => $this->get_tiktok_credentials(),
            'whatsapp' => $this->get_whatsapp_credentials(),
            'line' => $this->get_line_credentials(),
            'openai' => $this->get_openai_credentials(),
            'gemini' => $this->get_gemini_credentials()
        ];

        $this->_viewcontroller($data);
    }

    public function get_tiktok_credentials()
    {
        $asset_path_common = base_url('assets/img/api_channel_icon/');
        return [
            'title' => 'TikTok',
            'img_path' => $asset_path_common . 'social_media/tiktok.png',
            'action_url' => base_url('integration/tiktok_settings'),
        ];
    }

    public function get_whatsapp_credentials()
    {
        $asset_path_common = base_url('assets/img/api_channel_icon/');
        return [
            'title' => 'WhatsApp',
            'img_path' => $asset_path_common . 'social_media/whatsapp.png',
            'action_url' => base_url('integration/whatsapp_settings'),
        ];
    }

    public function get_line_credentials()
    {
        $asset_path_common = base_url('assets/img/api_channel_icon/');
        return [
            'title' => 'Line',
            'img_path' => $asset_path_common . 'social_media/line.png',
            'action_url' => base_url('integration/line_settings'),
        ];
    }

    public function get_openai_credentials()
    {
        $asset_path_common = base_url('assets/img/api_channel_icon/');
        return [
            'title' => 'OpenAI',
            'img_path' => $asset_path_common . 'social_media/openai.png',
            'action_url' => base_url('integration/openai_settings'),
        ];
    }

    public function get_gemini_credentials()
    {
        $asset_path_common = base_url('assets/img/api_channel_icon/');
        return [
            'title' => 'Gemini',
            'img_path' => $asset_path_common . 'social_media/gemini.png',
            'action_url' => base_url('integration/gemini_settings'),
        ];
    }

    // Action for saving OpenAI credentials
    public function open_ai_api_credentials()
    {
        if ($this->session->userdata('user_type') != 'Admin') redirect('home/login_page', 'location');
        $data['body'] = "admin/openAI/api_credentials";
        $data['page_title'] = $this->lang->line('Open AI API Credentials');
        
        // Get OpenAI credentials from the database
        $get_data = $this->basic->get_data("open_ai_config");
        $data['xvalue'] = isset($get_data[0]) ? $get_data[0] : [];
        if ($this->is_demo == '1') {
            $data["xvalue"]["open_ai_secret_key"] = "XXXXXXXXXX";
        }
        
        $this->_viewcontroller($data);
    }

    public function open_ai_api_credentials_action()
    {
        if ($this->is_demo == '1') {
            echo "<h2 style='text-align:center;color:red;border:1px solid red; padding: 10px'>This feature is disabled in this demo.</h2>";
            exit();
        }

        if ($this->session->userdata('user_type') != 'Admin') redirect('home/login_page', 'location');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $open_ai_secret_key = $this->input->post('open_ai_secret_key');
            $this->basic->update_data('open_ai_config', ['id' => 1], ['open_ai_secret_key' => $open_ai_secret_key]);
            $this->session->set_flashdata('success_message', 'API credentials saved successfully.');
            redirect('integration/open_ai_api_credentials');
        }
    }

    // Function for handling TikTok API credentials save/update
    public function tiktok_settings()
    {
        // Add code to save TikTok credentials
    }

    // Function for handling WhatsApp API credentials save/update
    public function whatsapp_settings()
    {
        // Add code to save WhatsApp credentials
    }

    // Function for handling Line API credentials save/update
    public function line_settings()
    {
        // Add code to save Line credentials
    }

    // Function for handling Gemini API credentials save/update
    public function gemini_settings()
    {
        // Add code to save Gemini credentials
    }
}

?>