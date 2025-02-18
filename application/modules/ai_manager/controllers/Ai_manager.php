<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ai_manager extends Home {

    public function __construct() {
        parent::__construct();
        // โหลด Model สำหรับ AI
        $this->load->model('Ai_model');
        // ตรวจสอบการเข้าสู่ระบบ (logged in) หากไม่ได้ให้ redirect ไปยังหน้า login
        if (!$this->session->userdata('logged_in')) {
            redirect('home/login', 'location');
        }
    }

    // แสดงหน้าตั้งค่า OpenAI
    public function openai_settings() {
        $data['settings'] = $this->Ai_model->get_settings('openai');
        $data['page_title'] = 'OpenAI Settings';
        $data['body'] = 'ai_manager/openai_settings';
        $this->_viewcontroller($data);
    }

    // แสดงหน้าตั้งค่า Gemini
    public function gemini_settings() {
        $data['settings'] = $this->Ai_model->get_settings('gemini');
        $data['page_title'] = 'Gemini Settings';
        $data['body'] = 'ai_manager/gemini_settings';
        $this->_viewcontroller($data);
    }

    // แสดงหน้าตั้งค่า DeepSeek
    public function deepseek_settings() {
        $data['settings'] = $this->Ai_model->get_settings('deepseek');
        $data['page_title'] = 'DeepSeek Settings';
        $data['body'] = 'ai_manager/deepseek_settings';
        $this->_viewcontroller($data);
    }

    // แสดงหน้าตั้งค่า Dialosflow (NLP)
    public function dialosflow_settings() {
        $data['settings'] = $this->Ai_model->get_settings('dialosflow');
        $data['page_title'] = 'Dialosflow Settings';
        $data['body'] = 'ai_manager/dialosflow_settings';
        $this->_viewcontroller($data);
    }

    // ฟังก์ชันสำหรับบันทึกการตั้งค่า AI ทั้งหมด (ใช้ร่วมกันได้)
    public function save_settings() {
        // รับค่า model ที่ต้องการบันทึก เช่น openai, gemini, deepseek, dialosflow
        $model = $this->input->post('model');
        $api_key = $this->input->post('api_key');
        $model_choice = $this->input->post('model_choice');
        $custom_prompt = $this->input->post('custom_prompt');

        $data = [
            'api_key' => $api_key,
            'model_choice' => $model_choice,
            'custom_prompt' => $custom_prompt,
            'updated_at' => date("Y-m-d H:i:s")
        ];

        $result = $this->Ai_model->save_settings($model, $data);
        if ($result) {
            $this->session->set_flashdata('success_message', 'Settings saved successfully');
        } else {
            $this->session->set_flashdata('error_message', 'Failed to save settings');
        }
        redirect('ai_manager/' . $model . '_settings');
    }
}