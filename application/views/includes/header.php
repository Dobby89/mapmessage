<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />

  <title>Geogab</title>

  <link rel="stylesheet" href="<?php echo base_url('dist/css/style.css'); ?>" />

  <script type="text/javascript" src="http://maps.google.com/maps/api/js?v=3.exp&libraries=places&sensor=true"></script>
  <script type="text/javascript" src="<?php echo base_url('dist/js/all.js'); ?>"></script>
</head>
<body>

<ul class="nav nav--block">
    <li><a href="<?php echo site_url(); ?>">Home</a></li>
    <?php if($this->session->userdata('logged_in')) { ?>
        <li><a href="<?php echo site_url('account/logout'); ?>">Logout</a></li>
    <?php } else { ?>
        <li><a href="<?php echo site_url('account/create'); ?>">Create Account</a></li>
        <li><a href="<?php echo site_url('account/login'); ?>">Login</a></li>
    <?php } ?>
</ul>

<?php if ($this->session->flashdata('success')){ ?>
    <?php $this->load->view('includes/notification', array('class' => 'success', 'message' => $this->session->flashdata('success'))); ?>
<?php } ?>
<?php if ($this->session->flashdata('error')){ ?>
<?php $this->load->view('includes/notification', array('class' => 'error', 'message' => $this->session->flashdata('error'))); ?>
<?php } ?>