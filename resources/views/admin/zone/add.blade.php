@extends('admin.theme.default')
@section('content')
@include('admin.breadcrumb')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card border-0 h-450-px">
                <div class="card-body">
                    <div class="form-validation">
                        <form action="{{URL::to('admin/zone/store')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label class="col-lg-12 col-form-label" for="">{{trans('labels.name')}} </label>
                                <div class="col-lg-12">
                                    <input type="text" class="form-control" name="name" value="{{old('name')}}" placeholder="{{trans('labels.name')}}" required>
                                    @error('name') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                    <label class="col-lg-12 col-form-label" for="">{{ trans('labels.delivery_charge') }}
                                    </label>
                                    <div class="col-lg-12">
                                        <input type="text" class="form-control" name="delivery_charge"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                            value="" placeholder="{{ trans('labels.delivery_charge') }}" required>
                                        @error('delivery_charge')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                            </div>


                            <div class="form-group">
                                <label class="col-lg-12 col-form-label" for="">{{trans('labels.coordinates')}} </label>
                                <div class="col-lg-12">
                                    <textarea class="form-control" name="coordinates" id="coordinates" rows="6" placeholder="{{trans('labels.enter_coordinates')}}" readonly required></textarea>
                                    @error('coordinates') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                            </div>
                            <div class="form-group text-end">
                            <a href="{{URL::to('admin/zone')}}"><button class="btn btn-outline-danger" @if (env('Environment') == 'sendbox') onclick="myFunction()" @endif type="button">{{ trans('labels.cancel') }}</button></a>
                                <button class="btn btn-primary" @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{trans('labels.save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card border-0">
                <div class="card-body h-450-px">
                    <input id="pac-input" class="controls rounded map-search-box" title="Search your location here" type="text" placeholder="Search your location here" />
                    <div id="map-canvas" class="zone-map"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="https://maps.googleapis.com/maps/api/js?key={{@Helper::appdata()->map}}&libraries=drawing,places"></script>
    <script type="text/javascript">
        var map; // Global declaration of the map
        var drawingManager;
        var lastpolygon = null;
        var polygons = [];
        function resetMap(controlDiv) {
            "use strict";
            // Set CSS for the control border.
            const controlUI = document.createElement("div");
            controlUI.style.backgroundColor = "#fff";
            controlUI.style.border = "1px solid #fff";
            controlUI.style.borderRadius = "3px";
            controlUI.style.boxShadow = "0 2px 6px rgba(0,0,0,.3)";
            controlUI.style.cursor = "pointer";
            controlUI.style.marginTop = "8px";
            controlUI.style.marginBottom = "22px";
            controlUI.style.textAlign = "center";
            controlUI.title = "Reset map";
            controlDiv.appendChild(controlUI);
            // Set CSS for the control interior.
            const controlText = document.createElement("div");
            controlText.style.color = "rgb(25,25,25)";
            controlText.style.fontFamily = "Roboto,Arial,sans-serif";
            controlText.style.fontSize = "10px";
            controlText.style.lineHeight = "16px";
            controlText.style.paddingLeft = "2px";
            controlText.style.paddingRight = "2px";
            controlText.innerHTML = "X";
            controlUI.appendChild(controlText);
            // Setup the click event listeners: simply set the map to Chicago.
            controlUI.addEventListener("click", () => {
                lastpolygon.setMap(null);
                $('#coordinates').val('');
            });
        }
        function initialize() {
            "use strict";
            var myLatlng = {lat: {{@Helper::appdata()->lat}},lng: {{@Helper::appdata()->lang}}};
            var myOptions = {
                zoom: 13,
                center: myLatlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }
            map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);
            drawingManager = new google.maps.drawing.DrawingManager({
                drawingMode: google.maps.drawing.OverlayType.POLYGON,
                drawingControl: true,
                drawingControlOptions: {
                    position: google.maps.ControlPosition.TOP_CENTER,
                    drawingModes: [google.maps.drawing.OverlayType.POLYGON]
                },
                polygonOptions: {
                    editable: true
                }
            });
            drawingManager.setMap(map);
            // to get current location block ===================> Start
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition( (position) => {
                    const pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                    };
                    map.setCenter(pos);
                });
            }
            // to get current location block ==================> End
            google.maps.event.addListener(drawingManager, "overlaycomplete", function(event) {
                if (lastpolygon) {
                    lastpolygon.setMap(null);
                }
                $('#coordinates').val(event.overlay.getPath().getArray());
                lastpolygon = event.overlay;
                let element = document.getElementById("coordinates");
                element.style.height = (element.scrollHeight) + "px";
            });
            const resetDiv = document.createElement("div");
            resetMap(resetDiv, lastpolygon);
            map.controls[google.maps.ControlPosition.TOP_CENTER].push(resetDiv);
            // Create the search box and link it to the UI element.
            const input = document.getElementById("pac-input");
            const searchBox = new google.maps.places.SearchBox(input);
            map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);
            // Bias the SearchBox results towards current map's viewport.
            map.addListener("bounds_changed", () => {
                searchBox.setBounds(map.getBounds());
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
                    const icon = {
                        url: place.icon,
                        size: new google.maps.Size(71, 71),
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(17, 34),
                        scaledSize: new google.maps.Size(25, 25),
                    };
                    // Create a marker for each place.
                    markers.push(
                        new google.maps.Marker({
                            map,
                            icon,
                            title: place.name,
                            position: place.geometry.location,
                        })
                    );
                    if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                });
                map.fitBounds(bounds);
            });
        }
        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
@endsection