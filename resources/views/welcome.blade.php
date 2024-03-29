<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
</head>
<body>

    <div id="map" class="h-screen w-screen"></div>
    @if($id != 0)
    <form action="/api/reset/{{$id}}" class="bottom-10 fixed right-10" style="z-index: 10000;" method="post">
        <button class="w-20 text-xl rounded hover:bg-red-500 bg-red-600 text-white">Reset</button>
    </form>
    @endif
    <script>
        function getRandomHexColor() {
            var r = Math.floor(Math.random() * 256);
            var g = Math.floor(Math.random() * 256);
            var b = Math.floor(Math.random() * 256);

            var hexColor = "#" + r.toString(16).padStart(2, '0') + g.toString(16).padStart(2, '0') + b.toString(16).padStart(2, '0');
            return hexColor;
        }

        function add_to_datacontainer(value){
            if(data_container[value.node_id] == undefined){
                data_container[value.node_id] = {
                    color: getRandomHexColor(),
                }
            }else{
                L.polyline([[data_container[value.node_id].value.latitude, data_container[value.node_id].value.longitude], [value.latitude, value.longitude]], {color: data_container[value.node_id].color}).addTo(mymap);
            }
            var map = L.marker([value.latitude, value.longitude]).bindPopup(`<b>Time:</b> ${value.created_at}`).addTo(mymap);
            // markers.addLayer(marker);
            data_container[value.node_id].value = value
        }

        var randomColor = getRandomHexColor();

        var data_container = {}

        var id = "{{$id}}";

        var mymap = L.map('map').setView([27.6920113, 85.3304820], 13);
        // var markers = L.markerClusterGroup();
        // this.map.addLayer(markers);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          maxZoom: 19,
        }).addTo(mymap);

        function update() {
            data_container = {}
            fetch(`/api/show/${id}`)
            .then(response => response.json())
            .then(data => {
                // markers.clearLayers();
                data.locations.forEach(value =>{
                    add_to_datacontainer(value)

                })
            })
            .catch(error => {
                console.error('Error fetching random color:', error);
            });
           setTimeout(()=>{
               update()
           }, 10000)
        }
        update()
  </script>
</body>
</html>
