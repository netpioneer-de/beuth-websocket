<!doctype html>
<html>
<head>
    <title>Socket Example</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        #map {
            height: 100%;
        }
    </style>
</head>
<script src="http://code.jquery.com/jquery-1.11.1.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?callback=initMap" async defer></script>
<script>
    var beuthCoords = {lat: 52.545517, lng: 13.351622};
    var map;

    var markers = [
        <?php
        // add markers
        try {
            $markers = fopen("markers.txt", "r");
            if ($markers) {
                while (($marker = fgets($markers)) !== false) {
                    echo $marker . ',';
                }
                fclose($markers);
            }
        } catch (Exception $e) {}
        ?>
    ];

    markers.push(beuthCoords);

    var createNewMarker = function (map, coords) {
        var newMarker = new google.maps.Marker({
            position: coords,
            map: map
        });

        markers.push(newMarker);
        setDeleteListener(newMarker);

        return newMarker;
    };

    var setDeleteListener = function (marker) {
        marker.addListener('click', function (event) {
            deleteObjectOnServer(event.latLng);
        });
    };

    var removeMarker = function (marker) {
        for (var i = 0; i < markers.length; i++) {
            if (marker.lat === markers[i].position.lat()
                && marker.lng === markers[i].position.lng()) {

                markers[i].setMap(null);
                markers.splice(i, 1);

            }
        }
    };

    function initMap() {

        map = new google.maps.Map(document.getElementById('map'), {
            center: beuthCoords, // der Beuth Hochschule
            zoom: 15
        });

        map.addListener('click', function (event) {
            console.log('click event');

            createNewMarker(map, event.latLng);

            var data = {};
            data.marker = '{lat: ' + event.latLng.lat() + ', lng: ' + event.latLng.lng() + '}';

            $.post('/marker.php', data);
        });

        markers.forEach(function (marker) {
            createNewMarker(map, marker);
        });
    }

</script>
<body>
<div id="map"></div>
</body>
</html>
