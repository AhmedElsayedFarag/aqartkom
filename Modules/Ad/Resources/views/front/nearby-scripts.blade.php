<script>
    const icons = {
        mosque: "{{ asset('icons_map/Mosque.svg') }}",
        food: "{{ asset('icons_map/food.svg') }}",
        home: "{{ asset('icons_map/home.svg') }}",
        hospital: "{{ asset('icons_map/hospital.svg') }}",
        school: "{{ asset('icons_map/school.svg') }}",
        market: "{{ asset('icons_map/market.svg') }}",
    }
    let map;
    let service;
    let infowindow;
    let markers = [];
    let center;
    let currentType = "market";
    const lat = parseFloat(document.querySelector("#lat").value);
    const lng = parseFloat(document.querySelector("#long").value);
    const nearbyButtons = document.querySelectorAll(".nearby-buttons");

    function initMap() {
        center = new google.maps.LatLng(lat, lng);
        infowindow = new google.maps.InfoWindow();
        map = new google.maps.Map(document.getElementById("nearby-places"), {
            center: center,
            zoom: 15,
        });
        placeHomeMarker();
        service = new google.maps.places.PlacesService(map);
        filterPlaces("market", 0);
    }

    function filterPlaces(type, index) {
        currentType = type;
        var request = {
            location: center,
            radius: "1500",
            type: [type],
        };

        currentButton = nearbyButtons[index].parentElement;

        if (currentButton.classList.contains("active")) {
            currentButton.classList.remove("active");
            clearMarkers();
        } else {
            console.log('clicked')
            currentButton.classList.add("active");
            service.nearbySearch(request, callback);
        }



    }

    function callback(results, status) {
        if (status == google.maps.places.PlacesServiceStatus.OK) {
            for (var i = 0; i < results.length; i++) {
                createMarker(results[i]);
            }
        }
    }

    function clearMarkers() {

        for (let i = 0; i < markers.length; i++) {
            let marker = markers[i];
            if (marker.type == currentType) {
                marker.setMap(null);
                // markers.splice(i, 1);
            }
        }

    }

    function createMarker(place) {
        if (!place.geometry || !place.geometry.location) return;
        let marker = new google.maps.Marker({
            map,
            position: place.geometry.location,
            icon: icons[currentType],
        });
        marker.type = currentType;
        markers.push(marker);
        google.maps.event.addListener(marker, "click", () => {
            infowindow.setContent(place.name || "");
            infowindow.open(map, marker);
        });
    }

    function placeHomeMarker() {
        const marker = new google.maps.Marker({
            map,
            position: center,
            icon: icons["home"],
        });


    }

    window.initMap = initMap;
</script>
