//global scripts
$(document).ready(function(){
    $('#city_list').change(updateArea);
});

function updateArea()
{
    var city_id = parseInt($('#city_list').val());

    if(city_id)
    {
        $.ajax({
            url: '/adm/area/get/city_id/'+city_id,
            type: 'get'
        }).success(function(res){
                if(res)
                {
                    $('#area_list').html(res);
                }
            });
    }
}

//map settings
if ($('div').is('#map_canvas')) {
    var map = undefined;
    var marker = undefined;

    var lat = $('input#lat').val();
    var lng = $('input#lng').val();
    var zoom = 16;
    var use = true;

    function initialize() {

        if (!lat || !lng) {
            lat = 53.904338;
            lng = 27.556243;
            zoom = 10;
            use = false;
        }

        var mapOptions = {
            center: new google.maps.LatLng(lat, lng),
            zoom: zoom,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);

        if (use) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(lat, lng),
                map: map,
                title: 'Current locations'
            });
        }

        google.maps.event.addListener(map, 'click', function (e) {
            if (typeof(marker) == "undefined") {
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(e.latLng.lat(), e.latLng.lng()),
                    map: map,
                    title: 'Current locations'
                });
                $('input#lat').val(e.latLng.lat());
                $('input#lng').val(e.latLng.lng());
            } else {
                marker.setOptions({
                    position: new google.maps.LatLng(e.latLng.lat(), e.latLng.lng())
                });
                $('input#lat').val(e.latLng.lat());
                $('input#lng').val(e.latLng.lng());
            }
        });
    }

    $(window).load(function () {
        initialize();
    });
}
//map settings