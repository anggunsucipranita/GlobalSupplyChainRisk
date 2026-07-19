@extends('layouts.master')

@section('content')

<h2 class="mb-4 fw-bold text-light">
    🚢 Port Dashboard
</h2>

<div class="input-group mb-4">

    <input
        type="text"
        id="searchPort"
        class="form-control"
        placeholder="Search port or country...">

</div>
<div id="map"
style="height:500px;border-radius:15px;"
class="mb-4"></div>

<div class="row g-3">

@forelse($ports as $port)

<div class="col-lg-4 col-md-6 port-card">

    <div class="card bg-dark text-light border-secondary shadow h-100">

        <div class="card-body">

            <h5 class="text-info">
    🚢 {{ $port->name }}
</h5>

<hr>

<p class="mb-2">
    🌍 <strong>Country :</strong>
    {{ $port->country }}
</p>

<p class="mb-2">
    📍 <strong>Latitude :</strong>
    {{ $port->latitude }}
</p>

<p class="mb-2">
    📍 <strong>Longitude :</strong>
    {{ $port->longitude }}
</p>

<p class="mb-0">
    ⚓ <strong>Port Size :</strong>

    <span class="badge bg-primary">
        {{ ucfirst($port->size) }}
    </span>
</p>

        </div>

    </div>

</div>

@empty

<div class="col-12">

    <div class="alert alert-warning">

        Data pelabuhan tidak ditemukan.

    </div>

</div>

@endforelse

</div>

@endsection

@push('scripts')

<script>

document.addEventListener("DOMContentLoaded", function () {

    const search = document.getElementById("searchPort");
    const cards = document.querySelectorAll(".port-card");

    search.addEventListener("keyup", function () {

        const keyword = this.value.toLowerCase();

        let firstVisible = null;

        cards.forEach(function(card, index){

            const text = card.innerText.toLowerCase();
            const match = text.includes(keyword);

            card.style.display = match ? "" : "none";

            if(match && firstVisible === null){
                firstVisible = index;
            }

        });

        const matched = [];

window.portInfo.forEach(function(port){

    if(port.text.includes(keyword)){
        matched.push(port.marker);
    }

});

if(matched.length == 1){

    window.map.flyTo(matched[0].getLatLng(),6,{
        animate:true,
        duration:1
    });

    matched[0].openPopup();

}
else if(matched.length > 1){

    const group = L.featureGroup(matched);

    window.map.fitBounds(group.getBounds(),{
        padding:[50,50]
    });

}

    });

});

</script>

<script>

var map = L.map('map').setView([20,0],2);

var markers = [];
var portInfo = [];

L.tileLayer(
'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
{
    attribution:'OpenStreetMap'
}).addTo(map);

@foreach($ports as $port)

var m = L.marker([
    {{ $port->latitude }},
    {{ $port->longitude }}
])
.addTo(map)
.bindPopup(`
<b>{{ $port->name }}</b><br>
{{ $port->country }}<br>
Size : {{ ucfirst($port->size) }}
`);

markers.push(m);

portInfo.push({
    marker: m,
    text: "{{ strtolower($port->name.' '.$port->country) }}"
});

@endforeach

window.map = map;
window.markers = markers;
window.portInfo = portInfo;


</script>

@endpush