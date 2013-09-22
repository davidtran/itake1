if (canShowCityDialog){
    $('#locationDialog').modal('show');
}

var UserLocation = {
    locationDialog:'#locationDialog',
    cityField:'#LocationForm_city',
    defaultLat:null,
    defaultLng:null,
    map:$('locationMap'),
    addressField:'#LocationForm_address',
    init: function() {
        UserLocation.initShowLocationDialogButton();                
    },
    initShowLocationDialogButton:function(){
        $('#linkSort_2').click(function(e){
            e.preventDefault();
            
            if(typeof(loginUser) != 'undefined'){
                
                $.ajax({
                    url:BASE_URL + '/site/locationDialog',
                    type:'post',
                    success:function(jsons){
                        var data = $.parseJSON(jsons);
                        if(data.success){
                            if(data.msg.alreadyHaveLocation){
                                window.location = data.msg.url;
                            }else{
                                $('body').append(data.msg.html);                        
                                $(UserLocation.locationDialog).modal('show');
                                UserLocation.initDialog();
                                UserLocation.initAddressField();
                                UserLocation.initSaveLocation();                                
                            }
                            

                        }else{
                            bootbox.alert(data.msg);
                        }
                    }
                });
                $(UserLocation.locationDialog).modal('show');
                
            }else{
                window.location = '/login.html';
            }
            
            
            return false;
        });
    },
    initSaveLocation:function(){
        $('#saveLocation').click(function(e){
            e.preventDefault();
            var lat = $('#LocationForm_lat').val();
            var lng = $('#LocationForm_lng').val();
            var address = $('#LocationForm_address').val();
            var city = $('#LocationForm_city option:selected').text();
            if(lat && lng && address.trim().length > 0){
                $.ajax({
                    url:BASE_URL + '/site/saveLocation',
                    type:'post',
                    data:{
                        lat:lat,
                        lng:lng,
                        address:address,
                        city:city
                    },
                    success:function(jsons){
                        var data = $.parseJSON(jsons);
                        if(data.success){
                            window.location = data.msg.url;
                        }else{
                            bootbox.alert(data.msg);
                        }
                    }
                });
            }else{
                bootbox.alert('Vui lòng chọn địa chỉ')
            }
            
            return false;
        })
    },

    initDialog: function() {
        $(UserLocation.cityField).change(function(e) {
            UserLocation.onCityChange($(UserLocation.cityField).val());
        });
        UserLocation.onCityChange($(UserLocation.cityField).val());
        if(cityList!=null)
        {       
            var firstCityIndex = null;
             for (var prop in cityList)
             {
                if (cityList.propertyIsEnumerable(prop))
                {
                   firstCityIndex = prop;
                   return;
               }
            }
               UserLocation.defaultLat = cityList[firstCityIndex].latitude;
               UserLocation.defaultLng = cityList[firstCityIndex].longitude;
        }
        UserLocation.locationDialog.on('shown', function() {
            UserLocation.map = MapUtils.addMap(UserLocation.map,UserLocation.defaultLat,UserLocation.defaultLng);
        });
    },
    onCityChange: function(value) {
        $.ajax({
            url: BASE_URL + '/upload/getGeoData',
            data: {
                cityId: value
            },
            type: 'get',
            success: function(json) {                
                data = $.parseJSON(json);
                if (data.success) {
                    UserLocation.setFormLatLon(data.msg.latitude, data.msg.longitude);
                    UserLocation.map = MapUtils.addMap(UserLocation.map,data.msg.latitude, data.msg.longitude);
                    
                    MapUtils.placeMarker(UserLocation.map,data.msg.latitude, data.msg.longitude,function(address){                 
                    });
                    locationData = data.msg;
                }
            }
        });
    },
    setFormLatLon:function(lat,lon){
        $('#LocationForm_lat').val(lat);
        $('#LocationForm_lng').val(lon);
    },
    initAddressField: function() {
        $(UserLocation.addressField).keydown(function(e){
            console.log(e.keycode);            
            if (e.keyCode == 13) {
                e.preventDefault();
                UserLocation.seachMapByAddress($(UserLocation.addressField).val(), $('#LocationForm_city option:selected').text());
                return false;
            }            
        });
        $('#btnSearchLocation').click(function(e){
            e.preventDefault();
            UserLocation.seachMapByAddress($(UserLocation.addressField).val(), $('#LocationForm_city option:selected').text());
            return false;
        });
    },
    seachMapByAddress:function(address,cityName){
        var address = address + ',' + cityName;
        MapUtils.searchMapByAddress(
                address,
                function(lat,lon){
                    UserLocation.setFormLatLon(lat,lon);
                    UserLocation.map = MapUtils.addMap(UserLocation.map,lat,lon);                  
                }
            );
    }    
};

$(document).ready(function() {
    UserLocation.init();
});