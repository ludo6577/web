
function initialize() {
    var companyPosition = new google.maps.LatLng(48.85629, 2.91102);
    var userPosition;
    var zoom = 12;
    var company_title = "Carroserrie crécy";
    var infoWindowContent = '<div id="content">' +
        '<center><img src="img/icons/boutique_crop.jpg">' +
        '<div id="bodyContent">' +
        '<p><b>1 rue dam gilles</b><br/>Crécy la chapelle 77580</p></center>' +
        '</div>' +
        '</div>';
    var showDirection = true;

    //La map
    var mapOptions = {
        zoom: zoom,
        center: companyPosition,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

    //Position et nom entreprise
    var companyMarker = new google.maps.Marker({
        position: companyPosition,
        animation: google.maps.Animation.DROP,
        title: company_title
    });
    companyMarker.setMap(map);

    //Infowindow on marker click
    var infowindow = new google.maps.InfoWindow({
        content: infoWindowContent
    });
    google.maps.event.addListener(companyMarker, 'click', function () {
        infowindow.open(map, companyMarker);
    });

    //Le chemin (si gps)
    if (showDirection && navigator.geolocation) {
        var rendererOptions = {
            draggable: true
        };
        directionsService = new google.maps.DirectionsService();
        directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
        directionsDisplay.setMap(map);
        directionsDisplay.setPanel(document.getElementById("directionsPanel"));

        //Position utilisateur
        navigator.geolocation.getCurrentPosition(function (position) {
            userPosition = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

            //Direction (route)
            var request = {
                origin: userPosition,
                destination: companyPosition,
                travelMode: google.maps.TravelMode.DRIVING
            };      
            directionsService.route(request, function (response, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    directionsDisplay.setDirections(response);
                    directionsDisplay.setOptions({ suppressMarkers: true });
                }
            });

            $('#details-button').show();
        });
    }
}

function loadScript() {
    $('#details-button').hide();
    var script = document.createElement('script');
    script.type = 'text/javascript';
    script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyAlNmylDGQGTnBbZlBEMo2TDTYqcZYEzLY&sensor=true&callback=initialize';
    document.body.appendChild(script);
}


window.onload = loadScript;