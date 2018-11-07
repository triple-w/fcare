define(function(require) {
    
    var $ = require('jquery');
    var config = require('config');

    return {
        fnAJAX: function (url, type, data, dataType, contentType, callBack) {
            if (contentType === null) {
                contentType = "application/x-www-form-urlencoded; charset=UTF-8";
            }
            $.ajax({
                url: url,
                type: type,
                data: data,
                datatype: dataType,
                cache: false,
                processData: false,
                contentType: contentType,
                beforeSend: function (jqXHR, settings) {
                    return jqXHR.setRequestHeader('X-CSRF-TOKEN', config.csrfToken);
                },
                success: function (response, textStatus, jqXHR) {
                    // if (jqXHR.getResponseHeader('REQUIRES_AUTH') === '1') {
                    //     window.location.href = jqXHR.getResponseHeader('LOCATION');
                    // }
                    if ($.type(callBack) === "function") {
                        callBack(response, true);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    if ($.type(callBack) === "function") {
                        callBack(jqXHR.responseText, false);
                    }
                },
                complete: function (jqXHR, textStatus) {
                    // if ($.type(callBackLoading) === "function") {
                    //     callBackLoading(false);
                    // }
                }
            });
        },
        generateMap: function(latitude, longitude, idObj) {
            var idObj = typeof idObj !== 'undefined' ?  idObj : 'mapa';
            var map = document.getElementById(idObj);
            var mapOptions = {
              center: new google.maps.LatLng(latitude, longitude),
              zoom: 15,
              mapTypeId: google.maps.MapTypeId.ROADMAP
            }
            var map = new google.maps.Map(map, mapOptions);

            var markers = [];
            var markerPosition = new google.maps.LatLng(latitude, longitude);
            var marker = new google.maps.Marker({
                position: markerPosition,
                    title: '',
                animation:  '' ,
                        icon: ''
            });
            marker.setMap(map);
        }
    };
});