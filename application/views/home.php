<?php $this->load->view('includes/header'); ?>

<div id="notifications"></div>

<div class="google-map">
  <form id="google-map-form" action="<?php echo site_url('map/search'); ?>">
    <input id="thread-search" name="thread-search" type="search" placeholder="Find threads" />
  </form>

  <div id="google-map-map" class="map"></div>
</div>

<div class="thread-list">
    <?php foreach($threads as $thread) { ?>

        <?php $this->load->view('partials/thread_list', array('thread' => $thread)); ?>

    <?php } ?>
</div>

<script type="text/javascript">
var ajaxGetThreads = function(lat, long) {

    $.ajax({
        url: '<?php echo base_url('thread/get_nearby_threads') ?>',
        type: 'POST',
        data: {
            lat: lat,
            long: long
        },
        beforeSend: function(){
            //console.log('getting nearby posts/threads');
        },
        success: function(data){
            if(data.errors){
                $.each(data.errors, function(field_name, err_msg){
                    if(field_name == 'error'){
                        alert(err_msg);
                        return false; // break from the loop
                    }
                });
            }

            var thread_list = $('.thread-list');
            if(data.threads){

                thread_list.empty().addClass('loading'); // clear the .thread-list so we can repopulate

                $.each(data.threads, function(thread, fields){
                    thread_list.append(fields.html);
                });

                thread_list.removeClass('loading');
            }
        },
        dataType: 'json'
    });
}
</script>

<?php $this->load->view('includes/footer'); ?>