<?php $this->load->view('includes/header'); ?>

<?php echo form_open(site_url('account/login'), array('id' => 'login-form', 'class' => 'form-block')); ?>

    <h1>Login</h1>

<?php echo form_hidden('url', (set_value('url') ? set_value('url') : current_url())); ?>
<?php echo form_input(array('name' => 'email_address', 'class' => 'sweet', 'value' => set_value('email_address'))); // spam filter ?>

    <ul class="form-fields">
        <li>
            <?php echo form_label('Email *', 'user_email', array('class' => 'visuallyhidden')); ?>
            <?php echo form_input(array('name' => 'user_email', 'placeholder' => 'Email *', 'value' => set_value('user_email'))); ?>
            <?php echo form_error('user_email', '<span class="form-error">', '</span>'); ?>
        </li>
        <li>
            <?php echo form_label('Password *', 'user_password', array('class' => 'visuallyhidden')); ?>
            <?php echo form_password(array('name' => 'user_password', 'placeholder' => 'Password *', 'value' => set_value('user_password'))); ?>
            <?php echo form_error('user_password', '<span class="form-error">', '</span>'); ?>
        </li>
        <button class="btn btn--small" type="submit">Login</button>
    </ul>

<?php echo form_close(); ?>

<?php $this->load->view('includes/footer'); ?>