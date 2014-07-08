<?php $this->load->view('includes/header'); ?>

<div id="notifications"></div>

<form id="search-form" action="<?php echo site_url('map/search'); ?>">
    <select id="search-radius" name="search-radius">
        <option value="5" selected>5</option>
        <option value="10">10</option>
        <option value="20">20</option>
        <option value="40">40</option>
        <option value="80">80</option>
    </select>

    <button id="search-submit" type="submit">Find Threads</button>
</form>

<?php $this->load->view('partials/create_thread'); ?>

<div class="thread-list"></div>

<script type="text/javascript">

    var latitude;
    var longitude;

    geolocate();

    $('#search-form').bind('submit', function(event){

        console.log($('#search-radius').val());

        event.preventDefault();

        ajaxGetThreads({
            lat: latitude,
            long: longitude,
            radius: $('#search-radius').val()
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
    }

    function geolocationError(error) {

        console.warn('ERROR(' + error.code + '): ' + error.message);
    }

    function ajaxGetThreads(params) {

        $.ajax({
            url: '<?php echo site_url('thread/get_nearby_threads') ?>',
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
</script>

<?php $this->load->view('includes/footer'); ?>