 <section class="section">
  <div class="section-header">
    <h1><i class="fas fa-hands-helping"></i> <?php echo $page_title; ?></h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item"><?php echo $this->lang->line("System"); ?></div>
      <div class="breadcrumb-item"><?php echo $page_title; ?></div>
    </div>
  </div>


    <div class="section-body">
      <div class="row">
        
        <div class="col-lg-6">
          <div class="card card-large-icons">
            <div class="card-icon text-primary">
              <i class="fab fa-facebook"></i>
            </div>
            <div class="card-body">
              <h4><?php echo $this->lang->line("Facebook"); ?></h4>
              <p><?php echo $this->lang->line("Set your Facebook app key, secret etc..."); ?></p>
              <a href="<?php echo base_url("social_apps/facebook_settings"); ?>" class="card-cta"><?php echo $this->lang->line("Change Setting"); ?> <i class="fas fa-chevron-right"></i></a>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card card-large-icons">
            <div class="card-icon text-primary">
              <i class="fab fa-google"></i>
            </div>
            <div class="card-body">
              <h4><?php echo $this->lang->line("Google"); ?></h4>
              <p><?php echo $this->lang->line("Set your Google app key, secret etc..."); ?></p>
              <a href="<?php echo base_url("social_apps/google_settings"); ?>" class="card-cta"><?php echo $this->lang->line("Change Setting"); ?> <i class="fas fa-chevron-right"></i></a>
            </div>
          </div>
        </div>
        
        <div class="col-lg-6">
          <div class="card card-large-icons">
            <div class="card-icon text-primary">
              <i class="fab fa-twitter-square"></i>
            </div>
            <div class="card-body">
              <h4><?php echo $this->lang->line("Twitter"); ?></h4>
              <p><?php echo $this->lang->line("Set your Twitter app key, secret etc..."); ?></p>
              <a href="<?php echo base_url("social_apps/twitter_settings"); ?>" class="card-cta"><?php echo $this->lang->line("Change Setting"); ?> <i class="fas fa-chevron-right"></i></a>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card card-large-icons">
            <div class="card-icon text-primary">
              <i class="fab fa-linkedin"></i>
            </div>
            <div class="card-body">
              <h4><?php echo $this->lang->line("Linkedin"); ?></h4>
              <p><?php echo $this->lang->line("Set your Linkedin app key, secret etc..."); ?></p>
              <a href="<?php echo base_url("social_apps/linkedin_settings"); ?>" class="card-cta"><?php echo $this->lang->line("Change Setting"); ?> <i class="fas fa-chevron-right"></i></a>
            </div>
          </div>
        </div>  

        <div class="col-lg-6">
          <div class="card card-large-icons">
            <div class="card-icon text-primary">
              <i class="fab fa-line-square"></i>
            </div>
            <div class="card-body">
              <h4><?php echo $this->lang->line("LINE BUSINESS"); ?></h4>
              <p><?php echo $this->lang->line("Set your Line Business app key, secret etc..."); ?></p>
              <a href="<?php echo base_url("social_apps/line_settings"); ?>" class="card-cta"><?php echo $this->lang->line("Change Setting"); ?> <i class="fas fa-chevron-right"></i></a>
            </div>
          </div>
        </div>

        <!-- <div class="col-lg-6">
          <div class="card card-large-icons">
            <div class="card-icon text-primary">
              <i class="fab fa-tiktok-square"></i>
            </div>
            <div class="card-body">
              <h4><?php echo $this->lang->line("Tiktok"); ?></h4>
              <p><?php echo $this->lang->line("Set your Tiktok app key, secret etc..."); ?></p>
              <a href="<?php echo base_url("social_appstiktok_settings"); ?>" class="card-cta"><?php echo $this->lang->line("Change Setting"); ?> <i class="fas fa-chevron-right"></i></a>
            </div>
          </div>
        </div> -->
        



        <div class="col-lg-6">
          <div class="card card-large-icons">
            <div class="card-icon text-primary">
              <i class="fab fa-wordpress"></i>
            </div>
            <div class="card-body">
              <h4><?php echo $this->lang->line("Wordpress"); ?></h4>
              <p><?php echo $this->lang->line("Set your Wordpress app key, secret etc..."); ?></p>
              <a href="<?php echo base_url("social_apps/wordpress_settings"); ?>" class="card-cta"><?php echo $this->lang->line("Change Setting"); ?> <i class="fas fa-chevron-right"></i></a>
            </div>
          </div>
        </div>



        <!-- <div class="col-lg-6">
          <div class="card card-large-icons">
            <div class="card-icon text-primary">
              <i class="fab fa-tumblr-square"></i>
            </div>
            <div class="card-body">
              <h4><?php echo $this->lang->line("What App"); ?></h4>
              <p><?php echo $this->lang->line("Set your what app app key, secret etc..."); ?></p>
              <a href="<?php echo base_url("social_apps/whatapp_settings"); ?>" class="card-cta"><?php echo $this->lang->line("Change Setting"); ?> <i class="fas fa-chevron-right"></i></a>
            </div>
          </div>
        </div> -->

        <div class="col-lg-6">
          <div class="card card-large-icons">
            <div class="card-icon text-primary">
              <i class="fab fa-wordpress"></i>
            </div>
            <div class="card-body">
              <h4><?php echo $this->lang->line("Wordpress (Self-Hosted)"); ?></h4>
              <p><?php echo $this->lang->line("Set your Wordpress app url, name etc..."); ?></p>
              <a href="<?php echo base_url("social_apps/wordpress_settings_self_hosted"); ?>" class="card-cta"><?php echo $this->lang->line("Change Setting"); ?> <i class="fas fa-chevron-right"></i></a>
            </div>
          </div>
        </div>



<!--         <div class="col-lg-6">
          <div class="card card-large-icons">
            <div class="card-icon text-primary">
              <i class="fab fa-telegram"></i>
            </div>
            <div class="card-body">
              <h4><?php echo $this->lang->line("Telegram"); ?></h4>
              <p><?php echo $this->lang->line("Set your Telegram app key, secret etc..."); ?></p>
              <a href="<?php echo base_url("social_apps/telegram_settings"); ?>" class="card-cta"><?php echo $this->lang->line("Change Setting"); ?> <i class="fas fa-chevron-right"></i></a>
            </div>
          </div>
        </div>     -->  

      </div>
    </div>
  </section>