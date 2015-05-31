$(document).ready(function(){
    $('.bxslider').bxSlider({
        adaptiveHeight: true,
        mode: 'fade'
    });

    $('.popup-close').click(function(){
        $(this).parents('.popup').fadeOut(300);
    });

    if($('a').is('#login_btn')){
        $('#login_btn').click(function(){
            $('.popup-login').fadeIn(300);
            return false;
        });
    }

    if ($('form').is('#login-form')) {
        $('#login-form').submit(function () {
            loginAjax();
            return false;
        });
    }
});
//map settings
if ($('div').is('#map_canvas')) {

    var map = undefined;
    var markers = new Array();
    var info_windows = new Array();

    function initialize() {

        lat = 53.904338;
        lng = 27.556243;
        zoom = 12;

        var mapOptions = {
            center: new google.maps.LatLng(lat, lng),
            zoom: zoom,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            disableDefaultUI: true,
            zoomControl: true,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.LARGE,
                position: google.maps.ControlPosition.LEFT_CENTER
            }
        };
        map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);

    }

    $(window).load(function () {
        initialize();

        if ($('.home-page > div').is('#map_canvas')) {
            $.ajax({
                type: 'get',
                url: '/address/get',
                dataType: 'json'
            }).success(function (res) {
                    if (res.length) {
                        for (i in res) {
                            var content = '<div class="map-address-item"><h2>' + res[i]['title'] + '</h2><h3>'+res[i]['organization']+'</h3><h4>'+res[i]['service']+'</h4><div class="content-map-address-item"><div class="img" style="background-image: url(http://www.' + res[i]['hostName'] + '/' + res[i]['thumb_dir'] + '/' + res[i]['file_name'] + ')"></div>' + res[i]['address'] + '</div><a href="/service/show/service_id/'+res[i]['service_id']+'">подробнее</a></div>';
                            createMarker(res[i]['map_lat'], res[i]['map_lng'], res[i]['title'], content);
                        }
                    }
                });
        }
    });
} else if($('div').is('.item-map')){

    $('div.item-map').each(function(){
        var lat = $(this).attr('lat');
        var lng = $(this).attr('lng');
        var id = $(this).attr('id');
        initMap(lat, lng, id);
    });
}
//map settings

function initMap(lat, lng, id)
{
    var mapOptions = {
        center: new google.maps.LatLng(lat, lng),
        zoom: 15,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        disableDefaultUI: true,
        zoomControl: true,
        zoomControlOptions: {
            style: google.maps.ZoomControlStyle.LARGE,
            position: google.maps.ControlPosition.LEFT_CENTER
        }
    };
    map = new google.maps.Map(document.getElementById(id), mapOptions);

    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(lat, lng),
        map: map
    });
}

function createMarker(lat, lng, title, content) {

    var info_window = new google.maps.InfoWindow({
        content: content
    });

    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(lat, lng),
        map: map,
        title: title
    });


    google.maps.event.addListener(marker, 'click', function () {
        closeInfowindows();
        info_window.open(map, marker);
    });

    markers.push(marker);
    info_windows.push(info_window);
}

function closeInfowindows(i) {
    i = i || false;

    var info_windows_length = info_windows.length;

    if (info_windows_length) {
        if (!i) {

            for (j in info_windows) {
                info_windows[j].close();
            }

        }else{
            info_windows[i].close();
        }
    }
}

function loginAjax() {
    var email = $('.popup-login input#email').val();
    var password = $('.popup-login input#password').val();
    var remember_me = $('.popup-login input#remember_me').val();
    var ajax = 1;

    if (!email.length) {
        $('.popup-login .alert').html('пожалуйста, введите email');
    } else if (!password.length) {
        $('.popup-login .alert').html('пожалуйста, введите пароль');
    } else {
        $.ajax({
            url: '/home/login',
            type: 'post',
            data: {'Login[email]': email, 'Login[password]': password, ajax: ajax, 'Login[remember_me]': remember_me}
        }).success(function (res) {
                if (parseInt(res) == 1) {
                    window.location = '/account';
                }else if(parseInt(res) == 2){
                    window.location = '/adm';
                }else {
                    $('.popup-login .alert').html(res);
                }
            });
    }
}