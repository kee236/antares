<!-- application/modules/ai_manager/views/openai_settings.php -->
<div class="container">
    <h2>OpenAI Settings</h2>
    <?php if ($this->session->flashdata('success_message')): ?>
        <div class="alert alert-success"><?php echo $this->session->flashdata('success_message'); ?></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error_message')): ?>
        <div class="alert alert-danger"><?php echo $this->session->flashdata('error_message'); ?></div>
    <?php endif; ?>

    <form action="<?php echo base_url('ai_manager/save_settings'); ?>" method="post">
        <input type="hidden" name="model" value="openai">
        <div class="form-group">
            <label for="api_key">API Key</label>
            <input type="text" name="api_key" id="api_key" class="form-control" value="<?php echo isset($settings['api_key']) ? $settings['api_key'] : ''; ?>">
        </div>
        <div class="form-group">
            <label for="model_choice">Model Choice</label>
            <select name="model_choice" id="model_choice" class="form-control">
                <option value="chatgpt" <?php echo (isset($settings['model_choice']) && $settings['model_choice'] == 'chatgpt') ? 'selected' : ''; ?>>ChatGPT</option>
                <option value="davinci" <?php echo (isset($settings['model_choice']) && $settings['model_choice'] == 'davinci') ? 'selected' : ''; ?>>Davinci</option>
            </select>
        </div>
        <div class="form-group">
            <label for="custom_prompt">Custom Prompt</label>
            <textarea name="custom_prompt" id="custom_prompt" class="form-control"><?php echo isset($settings['custom_prompt']) ? $settings['custom_prompt'] : ''; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save Settings</button>
    </form>
</div>