

var MapUtils = {
    searchMapByAddress: function(address,callback) {
        callback = callback || function(){};
        GMaps.geocode({
            address: address,
            callback: function(results, status) {
                if (status == 'OK') {
                    var latlng = results[0].geometry.location;
                    callback(latlng.lat(), latlng.lng());
                } else {
                    alert('Không tìm thấy kết quả cho địa chỉ bạn nhập, vui lòng nhập lại.');
                }
            }
        });
    },
    addMap: function(selector,lat, lng,callback) {
        callback = callback || function(){};
        
        selector = new GMaps({
            div: '#map',
            lat: lat,
            lng: lng,
            width: 500,
            height: 400,
            zoom: 15,
            click: function(e) {
               
                MapUtils.placeMarker(selector,e.latLng.lat(), e.latLng.lng());
            }
        });
        selector.addControl({
            position: 'top_right',
            text: 'Nơi bán hàng',
            style: {
                margin: '5px',
                padding: '1px 6px',
                border: 'solid 1px #717B87',
                background: '#fff'
            },
            events: {
                click: function() {
                    GMaps.geolocate({
                        success: function(position) {
                            selector.setCenter(position.coords.latitude, position.coords.longitude);
                        },
                        error: function(error) {
                            alert('Không thể đặt vị trí: ' + error.message);
                        },
                        not_supported: function() {
                            alert("Trình duyệt của bạn không cho phép sử dụng bản đồ");
                        }
                    });
                }
            }
        });

        
        selector.addMarker({
            lat: lat,
            lng: lng,
            icon: 'http://i.imgur.com/jfx5t.png',
        });
        callback();
        return selector;
    },
    placeMarker: function(selector,lat, lng,callback) {
        callback = callback || function(){};
        selector.removeMarkers();
        $('#Product_lat').val(lat);
        $('#Product_lon').val(lng);


        GMaps.geocode({
            lat: lat,
            lng: lng,
            callback: function(results, status) {
                if (status == 'OK') {
                    var formatAddress = results[0].formatted_address;
                    console.log(results[0]);
                    callback(results[0].formatted_address);                    
                    var latlng = results[0].geometry.location;
                    selector.setCenter(latlng.lat(), latlng.lng());
                    selector.addMarker({
                        lat: latlng.lat(),
                        lng: latlng.lng()
                    });
                }
            }
        });
    }
};