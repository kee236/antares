<?php




public function important_feature()
    {
		//bugs
    }


    public function credential_check($secret_code=0)
    {
		//bugs
    }

    public function credential_check_action()
    {
		//bugs

    }

    public function code_activation_check_action($purchase_code,$only_domain,$periodic=0)
    {
		//bugs
    }

    public function periodic_check(){
		//bugs
    }


    public function license_check()
    {
		//bugs

    }

    public function license_check_action()
    {
        $encoded = file_get_contents(APPPATH . 'core/licence_type.txt');
        $encrypt_method = "AES-256-CBC";
        $secret_key = 't8Mk8fsJMnFw69FGG5';
        $secret_iv = '9fljzKxZmMmoT358yZ';
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        $decoded = openssl_decrypt(base64_decode($encoded), $encrypt_method, $key, 0, $iv);

        $decoded = explode('_', $decoded);
        $decoded = array_pop($decoded);
        $this->session->set_userdata('license_type',$decoded);
    }

    public function php_info()
    {
        if($this->session->userdata('user_type')== 'Admin')
        echo phpinfo();
        else redirect('home/access_forbidden', 'location');
    }



    //=======================USAGE LOG & LICENSE FUNCTIONS======================
    //=============================================





?>
