<?php $this->load->view('includes/header'); ?>

<div id="notifications"></div>

<div class="google-map">
  <form id="google-map-form" action="<?php echo site_url('map/search'); ?>">
    <input id="thread-search" name="thread-search" type="search" placeholder="Find threads" />
  </form>

  <div id="google-map-map" class="map"></div>
</div>

<?php $this->load->view('includes/footer'); ?>