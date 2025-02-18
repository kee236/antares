<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ai_model extends CI_Model {

    protected $table = 'ai_settings'; // ชื่อตารางสำหรับเก็บข้อมูล AI

    public function __construct() {
        parent::__construct();
    }

    // ดึงข้อมูลการตั้งค่าตามประเภทโมเดล (openai, gemini, deepseek, dialosflow)
    public function get_settings($model) {
        $this->db->where('model', $model);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    // บันทึกการตั้งค่าสำหรับโมเดล AI
    public function save_settings($model, $data) {
        $this->db->where('model', $model);
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            // ถ้ามีข้อมูลอยู่แล้วให้ update
            return $this->db->update($this->table, $data, array('model' => $model));
        } else {
            // หากไม่มีข้อมูล ให้ insert ใหม่
            $data['model'] = $model;
            return $this->db->insert($this->table, $data);
        }
    }
}