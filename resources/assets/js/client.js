import Vue from 'vue'
import Booking from './modules/client/Booking/index'
import Guestbook from './modules/client/Guestbook/index'
import Auth from './modules/client/Auth/index'

import './modules/client/Registration/index';
import './i18n/datepicker-de'


$(document).ready(function () {

    var vm = new Vue({
        el: 'body',
        components: {
            Guestbook,
            Booking,
            Auth
        },

        data() {
            return {
                locale: $('meta[name="locale"]').attr('content')
            }
        },

        methods: {
            changeLocale() {
                window.location = `/client/set_locale/${this.locale}`;
            },
        }
    });

    var $clientCarousel = $('#clientCarousel');
    var $nextArrow = $('.client-carousel__next');
    var $prevArrow = $('.client-carousel__prev');

    $clientCarousel.slick({
        nextArrow: $nextArrow,
        prevArrow: $prevArrow
    });

    $('.settings-block__table a').click(function (event) {
        $(event.target).parents('.settings-block__table').css('display', 'none');
        $(event.target).parents('.settings-block__table').next().css('display', 'table');
        return false;
    });

    $('#update_pass').submit(function (event) {

        var pass1 = $("#pass").val();
        var pass2 = $("#pass_confirm").val();
        if (pass1 === "") {
            alert("Passwords cannot be empty");
            return false;
        }
        if (pass1 !== pass2) {
            alert("Passwords do not match");
            return false;
        }
    });

    $("#kontaktTabs").tabs();

    $('#birthday').datepicker(
        {
            showOtherMonths: true,
            selectOtherMonths: true,
            firstDay: 1,
            changeYear: true,
            changeMonth: true,
            yearRange: "-100:+0",
            dateFormat: 'dd/mm/yy',
            beforeShow: function (input, inst) {
                $('#ui-datepicker-div').addClass('reg');
            }
        });
    $('birthday').datepicker( $.datepicker.regional[ "de" ] );

    //select init
    $('.newsletter-table__checkbox, .login-form__checkbox').styler();

    //Google maps api
    if ($('#googleMap').length) {
        var initialize = function initialize() {

            var style = [{
                featureType: 'road',
                elementType: 'geometry',
                stylers: [{color: '#bababa'}]
            }, {
                featureType: 'road',
                elementType: 'labels',
                stylers: [{invert_lightness: true}]
            }, {
                featureType: 'landscape',
                elementType: 'geometry',
                stylers: [{hue: '#e8e7e3'}, {color: '#e8e7e3'}, {saturation: 0}, {lightness: 10}]
            }, {
                featureType: 'poi.school',
                elementType: 'geometry',
                stylers: [{hue: '#e8e7e3'}, {lightness: 1}, {saturation: 1}]
            }];

            var mapProp = {
                center: myCenter,
                zoom: 15,
                panControl: false,
                zoomControl: false,
                mapTypeControl: false,
                streetViewControl: false,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                styles: style
            };

            var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);

            var marker = new google.maps.Marker({
                position: myCenter,
                icon: 'images/marker.png'
            });

            var geocoder = new google.maps.Geocoder();

            geocodeAddress(geocoder, map);

            marker.setMap(map);
        };

        var myCenter = new google.maps.LatLng(51.508742, -0.120850);

        google.maps.event.addDomListener(window, 'load', initialize);
    }

    function geocodeAddress(geocoder, resultsMap) {
        var googleMap = document.getElementById('googleMap');

        var country = googleMap.getAttribute('data-country');
        var city = googleMap.getAttribute('data-city');
        var street = googleMap.getAttribute('data-street');


        var result = country + ' ' + city + ' ' + street;

        geocoder.geocode({'address': result}, function (results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                resultsMap.setCenter(results[0].geometry.location);
                var marker = new google.maps.Marker({
                    map: resultsMap,
                    position: results[0].geometry.location
                });
            } else {
                alert('Geocode was not successful for the following reason: ' + status);
            }
        });
    }

});
