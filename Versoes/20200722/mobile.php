<!DOCTYPE html>
<html>
<lang pt-BR>
<head>
	<title>SIG WEB</title>
	<meta charset = "UTF-8">
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
   				integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
   				crossorigin=""/>
	<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
   			integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
   			crossorigin="">					
   </script>
   <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" /><!--Atestar resultado!-->
	<style>
		html, body, #mapid{
			height: 100%;
		}
		body{
			width: 100%;
			margin: 0;
		}
		#mapid{
			width: 100%;
			height: 100%;
			z-index: 0;
		}
	</style>

</head>
<body>
	<div id="mapid"></div>
	<script>
		var myMap = L.map('mapid').fitWorld();//zoom para o mundo
		//var myMap = L.map('mapid').setView([-23.645632, -46.642145], 15);
		//Open Steet Map
		var baseMap = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
			attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
		});
		baseMap.addTo(myMap);

		//Adicionando um marcador pontual padrão
		var marker = L.marker([-23.645632, -46.642145]).addTo(myMap);

		//Adicionando um circulo de raio de 500m
		var circle = L.circle([-23.645632, -46.642145], {
    		color: 'yellow',
    		fillColor: 'purple',
    		fillOpacity: 0.5,
    		radius: 500
		}).addTo(myMap);

		//Adicionando um polígono
		var polygon = L.polygon([
		    [-23.641991, -46.644327],
		    [-23.641572, -46.645591],
		    [-23.641379, -46.645367],
		    [-23.641469, -46.645249],
		    [-23.641025, -46.644631],
		    [-23.641706, -46.644215]
		]).addTo(myMap);

		//Atribuindo rótulos às feições 
		//marker.bindPopup("<b>Geo-atributo:</b><br>Terminal Rod. do Jabaquara.").openPopup();
		marker.bindPopup("<b>Geo-atributo:</b><br>Terminal Rod. do Jabaquara.");
		circle.bindPopup("Raio de 500m.");
		polygon.bindPopup("Supermercado Assaí.");	
	
		/*//Adicionando atributo a um par de coordenadas
		var popup = L.popup()
		    .setLatLng([-23.643575, -46.631167])
		    .setContent("Rodovia dos Imigrantes.")
		    .openOn(mymap);*/

		/*//Adicionando evento de click para obtenção de par de coordenadas a partir de uma alerta
		function onMapClick(e) {
		    alert("Você clicou na coordenada " + e.latlng);
		}
		mymap.on('click', onMapClick);*/

		//Adicionando evento de click para obtenção de par de coordenadas a partir de um popup
		var popup = L.popup();
		function onMapClick(e) {
		    popup
		        .setLatLng(e.latlng)
		        .setContent("Você clicou na coordenada " + e.latlng.toString())
		        .openOn(myMap);
		}
		myMap.on('click', onMapClick);

		//Solicita permissão para saber localização e centraliza página no local do usuário
		myMap.locate({watch: true, setView: true, maxZoom: 16});

		function onLocationFound(e) {
		    var radius = e.accuracy;
		    L.marker(e.latlng).addTo(myMap)
		        .bindPopup("Você está a " + radius + " metros deste ponto").openPopup();
		    L.circle(e.latlng, radius).addTo(myMap);
		}
		myMap.on('locationfound', onLocationFound);

		//Caso não funcione a localização
		function onLocationError(e) {
		    alert(e.message);
		}
		myMap.on('locationerror', onLocationError);

	</script>
	<!--<a id="btn1" href="map.html" style="background-color:black; color:white; text-align:center; text-decoration:none; padding: 25px 0; display:block;">VOLTAR PARA A PÁGINA INICIAL</a>-->
	<button style="position:fixed; bottom:0; left: 0 ;z-index: 2;"><a href="index.php" style="text-decoration: none"><b>INÍCIO<b><a></button>
</body>

</html>
