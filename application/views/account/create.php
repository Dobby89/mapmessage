<?php $this->load->view('includes/header'); ?>

<?php echo form_open(site_url('account/create_account'), array('id' => 'create-account-form', 'class' => 'form-block')); ?>

    <h1>Create Account</h1>

<?php echo form_hidden('url', (set_value('url') ? set_value('url') : current_url())); ?>
<?php echo form_input(array('name' => 'email_address', 'class' => 'sweet', 'value' => set_value('email_address'))); // spam filter ?>

    <ul class="form-fields">
        <li>
            <?php echo form_label('Username *', 'user_username', array('class' => 'visuallyhidden')); ?>
            <?php echo form_input(array('name' => 'user_username', 'placeholder' => 'Username *', 'value' => set_value('user_username'))); ?>
            <?php echo form_error('user_username', '<span class="form-error">', '</span>'); ?>
        </li>
        <li>
            <?php echo form_label('Email *', 'user_email', array('class' => 'visuallyhidden')); ?>
            <?php echo form_input(array('name' => 'user_email', 'placeholder' => 'Email *', 'value' => set_value('user_email'))); ?>
            <?php echo form_error('user_email', '<span class="form-error">', '</span>'); ?>
        </li>
        <li>
            <?php echo form_label('Confirm Email *', 'user_email_confirm', array('class' => 'visuallyhidden')); ?>
            <?php echo form_input(array('name' => 'user_email_confirm', 'placeholder' => 'Confirm Email *', 'value' => set_value('user_email_confirm'))); ?>
            <?php echo form_error('user_email_confirm', '<span class="form-error">', '</span>'); ?>
        </li>
        <li>
            <?php echo form_label('Password *', 'user_password', array('class' => 'visuallyhidden')); ?>
            <?php echo form_password(array('name' => 'user_password', 'placeholder' => 'Password *', 'value' => set_value('user_password'))); ?>
            <?php echo form_error('user_password', '<span class="form-error">', '</span>'); ?>
        </li>
        <li>
            <?php echo form_label('Confirm Password *', 'user_password_confirm', array('class' => 'visuallyhidden')); ?>
            <?php echo form_password(array('name' => 'user_password_confirm', 'placeholder' => 'Confirm Password *', 'value' => set_value('user_password_confirm'))); ?>
            <?php echo form_error('user_password_confirm', '<span class="form-error">', '</span>'); ?>
        </li>
        <button class="btn btn--small" type="submit">Create Account</button>
    </ul>

<?php echo form_close(); ?>

<?php $this->load->view('includes/footer'); ?>