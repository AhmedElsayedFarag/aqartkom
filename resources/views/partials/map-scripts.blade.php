<script async
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBSji4f8rxgtuD-JnkBgm4jrIUaXkFDyCw&callback=initAutocomplete&v=weekly&libraries=places">
</script>
<script>
    const SAUDI_ARABA_BOUNDS = {
        north: 32.0,
        south: 16.0,
        west: 34.0,
        east: 55.0,
    };

    function initAutocomplete() {
        let long = document.getElementById('long');
        let lat = document.getElementById('lat');
        let center = {
            lat: 24.774265,
            lng: 46.738586,
        }

        if (long != null && lat != null) {

            if (long.value && lat.value) {
                lat = lat.value;
                long = long.value;
                center = {};

                lat = parseFloat(lat);
                long = parseFloat(long);
                center = {
                    lat: lat,
                    lng: long,
                }
            }
        }

        const map = new google.maps.Map(document.getElementById("map"), {
            center,
            zoom: 13,
            mapTypeId: "roadmap",
            restriction: {
                latLngBounds: SAUDI_ARABA_BOUNDS,
                strictBounds: false,
            },

        });
        // Create the search box and link it to the UI element.
        const input = document.getElementById("pac-input");
        const searchBox = new google.maps.places.SearchBox(input);
        let marker = null;
        placeMarker(center);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
        // Bias the SearchBox results towards current map's viewport.
        map.addListener("bounds_changed", () => {
            searchBox.setBounds(map.getBounds());
        });
        google.maps.event.addListener(map, 'click', function(event) {
            placeMarker(event.latLng);
        });
        let markers = [];

        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener("places_changed", () => {
            const places = searchBox.getPlaces();

            if (places.length == 0) {
                return;
            }

            // Clear out the old markers.
            markers.forEach((marker) => {
                marker.setMap(null);
            });
            markers = [];

            // For each place, get the icon, name and location.
            const bounds = new google.maps.LatLngBounds();

            places.forEach((place) => {
                if (!place.geometry || !place.geometry.location) {
                    console.log("Returned place contains no geometry");
                    return;
                }

                // const icon = {
                //     url: place.icon,
                //     size: new google.maps.Size(71, 71),
                //     origin: new google.maps.Point(0, 0),
                //     anchor: new google.maps.Point(17, 34),
                //     scaledSize: new google.maps.Size(25, 25),
                // };

                // Create a marker for each place.
                // markers.push(
                //     new google.maps.Marker({
                //         map,
                //         icon,
                //         title: place.name,
                //         position: place.geometry.location,
                //     })
                // );
                placeMarker(place.geometry.location);
                if (place.geometry.viewport) {
                    // Only geocodes have viewport.
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
            });
            map.fitBounds(bounds);
        });

        function placeMarker(location) {

            if (marker != null)
                marker.setMap(null);

            // console.log(location.lat());
            marker = new google.maps.Marker({
                position: location,
                map: map,
                icon: "{{ asset('icons_map/home.svg') }}"
            });
            long = document.getElementById('long');
            lat = document.getElementById('lat');

            if (typeof location.lat == "function") {
                long.value = location.lng();
                lat.value = location.lat();
            } else {
                long.value = location.lng;
                lat.value = location.lat;
            }

            map.setCenter(location);
        }
    }

    window.initAutocomplete = initAutocomplete;
</script>
