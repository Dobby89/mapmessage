<?php $this->load->view('includes/header'); ?>

<form>
    <input id="geocomplete" type="search" placeholder="Type in an address" size="90" />
    <button id="find" class="btn btn--small" type="button">Find Threads</button>
</form>

<form id="filter-form" action="<?php echo site_url('map/search'); ?>">
    <select id="filter-radius" name="search-radius">
        <option value="5" selected>5</option>
        <option value="10">10</option>
        <option value="20">20</option>
        <option value="40">40</option>
        <option value="80">80</option>
    </select>

    <button id="filter-submit" class="btn btn--small" type="submit">Filter</button>
</form>

<div>
    <a class="btn btn--small" href="<?php echo site_url('threads/create'); ?>">Create Thread</a>
</div>

<div class="thread-list"></div>

<script type="text/javascript">

    var latitude = <?php echo $this->session->userdata('user_latitude') ? $this->session->userdata('user_latitude') : 'null'; ?>;
    var longitude = <?php echo $this->session->userdata('user_longitude') ? $this->session->userdata('user_longitude') : 'null'; ?>;

    <?php if($this->session->userdata('user_latitude') && $this->session->userdata('user_longitude')) { ?>
        ajaxGetThreads({
            lat: <?php echo $this->session->userdata('user_latitude'); ?>,
            long: <?php echo $this->session->userdata('user_longitude'); ?>,
            radius: 5
        });
    <?php } else { ?>
        geolocate();
    <?php } ?>

    $('#filter-form').bind('submit', function(event){

        event.preventDefault();

        ajaxGetThreads({
            lat: latitude,
            long: longitude,
            radius: $('#filter-radius').val()
        });
    });

    function geolocate(){
        if (navigator.geolocation) {
            var timeoutVal = 10 * 1000 * 1000;
            var options = [{
                enableHighAccuracy: false,
                timeout: timeoutVal,
                maximumAge: 0
            }];
            navigator.geolocation.getCurrentPosition(currentPosition, geolocationError, options);
        }
        else {
            alert("Geolocation is not supported by this browser");
        }
    }

    function currentPosition(position) {

        latitude = position.coords.latitude;
        longitude = position.coords.longitude;

        console.log(latitude);
        console.log(longitude);

        ajaxSaveLocation(latitude, longitude);
    }

    function geolocationError(error) {

        console.warn('ERROR(' + error.code + '): ' + error.message);
    }

    function ajaxSaveLocation(latitude, longitude){

        console.log('saving location');

        $.ajax({
            url: '<?php echo site_url('geolocation/save_location') ?>',
            type: 'POST',
            data: {
                lat: latitude,
                long: longitude
            },
            beforeSend: function(){
                //console.log('saving user location');
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
            },
            dataType: 'json'
        });
    }

    function ajaxGetThreads(params) {

        console.log('ajax getting threads');
        console.log(params);

        $.ajax({
            url: '<?php echo site_url('thread/ajax_get_threads') ?>',
            type: 'POST',
            data: {
                lat: params['lat'],
                long: params['long'],
                radius: params['radius']
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

                    // clear the list so we can repopulate and add a loading class
                    thread_list.empty().addClass('loading');

                    // loop through results and add to the list
                    $.each(data.threads, function(thread, fields){
                        thread_list.append(fields.html);
                    });

                    // remove loading class
                    thread_list.removeClass('loading');
                }
            },
            dataType: 'json'
        });
    }

    $(function(){

        // autocomplete the search results for addresses
        $("#geocomplete").geocomplete()
            .bind("geocode:result", function(event, result){
                console.log('latitude:' + result.geometry.location.k);
                console.log('longitude:' + result.geometry.location.B);

                latitude = result.geometry.location.k;
                longitude = result.geometry.location.B;

                ajaxGetThreads({
                    lat: latitude,
                    long: longitude,
                    radius: 5
                })
            })
            .bind("geocode:error", function(event, status){
                console.log("ERROR: " + status);
            })
            .bind("geocode:multiple", function(event, results){
                console.log("Multiple: " + results.length + " results found");
            });

        $("#find").click(function(){
            $("#geocomplete").trigger("geocode");
        });
    });
</script>

<?php $this->load->view('includes/footer'); ?>