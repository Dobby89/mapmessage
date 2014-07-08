<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />

  <title>Geogab</title>

  <link rel="stylesheet" href="<?php echo base_url('dist/css/style.css'); ?>" />

  <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
  <script type="text/javascript" src="<?php echo base_url('dist/js/all.js'); ?>"></script>
</head>
<body>

<?php if ($this->session->flashdata('success')){ ?>
    <?php $this->load->view('includes/notification', array('class' => 'success', 'message' => $this->session->flashdata('success'))); ?>
<?php } ?>
<?php if ($this->session->flashdata('error')){ ?>
<?php $this->load->view('includes/notification', array('class' => 'error', 'message' => $this->session->flashdata('error'))); ?>
<?php } ?>