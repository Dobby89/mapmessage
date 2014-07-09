<?php $this->load->view('includes/header'); ?>

<?php echo form_open(site_url('thread/create_thread'), array('id' => 'create-thread-form', 'class' => 'form-block')); ?>

    <h4>Create Thread</h4>

<?php echo form_hidden('url', (set_value('url') ? set_value('url') : current_url())); ?>
<?php echo form_input(array('name' => 'email_address', 'class' => 'sweet', 'value' => set_value('email_address'))); // spam filter ?>

    <ul class="form-fields">
        <li>
            <?php echo form_label('Title *', 'thread_title', array('class' => 'visuallyhidden')); ?>
            <?php echo form_input(array('name' => 'thread_title', 'placeholder' => 'Title', 'value' => set_value('thread_title'))); ?>
            <?php echo form_error('thread_title', '<span class="form-error">', '</span>'); ?>
        </li>
        <li>
            <?php echo form_label('Description', 'thread_content', array('class' => 'visuallyhidden')); ?>
            <?php echo form_textarea(array('name' => 'thread_content', 'placeholder' => 'Description', 'value' => set_value('thread_content'))); ?>
            <?php echo form_error('thread_content', '<span class="form-error">', '</span>'); ?>
        </li>
        <button class="btn btn--small" type="submit">Create Thread</button>
    </ul>

<?php echo form_close(); ?>

<?php $this->load->view('includes/footer'); ?>