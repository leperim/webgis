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
   <!--FUNCIONA ROUTE MACHINE APENAS NA HOSTINGER, NÃO NO EASYphp. bUSCA PASTA dist DENTRO DO GITIGNORE-->
	<!--<link rel="stylesheet" href="/dist/leaflet-routing-machine.js" />
	<script src="/dist/leaflet-routing-machine.js"></script>-->
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
			height: 600px;
			display: flex;
			flex-wrap: wrap;
		}
	</style>

</head>
<body style="overflow: auto";>
	<div style="display:flex">
		<a id="btn1" href="mobile.php" style="background-color:black ; border :1px solid white; border-radius: 20px;color:white; text-align:center; text-decoration:none; padding: 15px 0; margin: 0px; display:inline-block; flex: 1; width: 33.3%">APLICAÇÃO GPS</a>
		<a id="btn1" href="densi_pop.php" style="background-color:darkviolet; border :1px solid white; border-radius: 20px; color:white; text-align:center; text-decoration:none; padding: 15px 0; margin: 0px; display:inline-block; flex: 1; width: 33.3%">DENSIDADE POPULACIONAL</a>
		<a id="btn1" href="seadeWMS.php" style="background-color:darkred; border :1px solid white; border-radius: 20px; color:white; text-align:center; text-decoration:none; padding: 15px 0; margin: 0px; display:inline-block; flex: 1; width: 33.3%">LEAFLET</a>
		<a id="btn1" href="OpenLayers.php" style="background-color:darkgreen; border :1px solid white; border-radius: 20px; color:white; text-align:center; text-decoration:none; padding: 15px 0; margin: 0px; display:inline-block; flex: 1; width: 33.3%">OPENLAYERS</a>
	</div>
	<div id="mapid"></div>

<script src="feicoes.js" type="text/javascript"></script>

		<script>
			var map = L.map('mapid').setView([-23.645632, -46.642145], 15);
			//Open Steet Map
			var baseMap = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
				attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
			});
			baseMap.addTo(map);


				/*//Estilizando os pontos
				var geojsonMarkerOptions = {
				    radius: 8,
				    fillColor: "#ff7800",
				    color: "#000",
				    weight: 1,
				    opacity: 1,
				    fillOpacity: 0.8
				};*/
				//Inserindo pontos SEM atributos popup 
				/*L.geoJSON(minhasEsquinas, {
						pointToLayer(feature,latlng){
							return L.circleMarker(latlng, geojsonMarkerOptions);
						}
				}).addTo(myMap);*/

				//Estilizando e inserindo linhas
				var myStyle = {
				    "color": "#ff0000",
				    "weight": 5,
				    "opacity": 0.65
				};
			var rua = L.geoJSON(myLines, {style: myStyle}).addTo(map);

			/*//Inserindo trecho SPVIAS
			var viario = L.geoJSON(spvias)//.addTo(myMap);*/

			//Inserindo pollígono (quarteirão) 
			var quadra = L.geoJSON(myPolygon);


			//Inserindo pontos COM atributos popup
			function onEachFeature(feature, layer) {
			    // does this feature have a property named popupContent?
			    if (feature.properties && feature.properties.popupContent) {
			        layer.bindPopup(feature.properties.popupContent);
			    }
			};

			//INSERIR ESQUINAS INDIVIDUALMENTE
			var esquinas = [];
			esquinas = L.geoJSON(minhasEsquinas,{
				onEachFeature: onEachFeature
			})//.addTo(myMap);


			var radio = {
				"Mapa Base": baseMap
			};
			var onoff = {
				"Pontos": esquinas,
				"Quadra": quadra,
				//"SPVias":viario
				"Rua": rua
			};
			L.control.layers("", onoff).addTo(map);

			//Adicionando evento de click para obtenção de par de coordenadas a partir de um popup
			var popup = L.popup();
			function onMapClick(e) {
			    popup
			        .setLatLng(e.latlng)
			        .setContent("Você clicou na coordenada " + e.latlng.toString())
			        .openOn(map);
			}
			map.on('click', onMapClick);

			L.Routing.control({
			  waypoints: [
			    L.latLng(-23.645632, -46.642145),
			    L.latLng(-23.65, -46.65)
			  ]
			}).addTo(map);


		</script>
		<img src="obras.png" alt="Site em Construção" style=" display: block; margin-left: auto; margin-right: auto">

<footer style="background-color: #333333; color:white; text-align: center; line-height: 1; font-size:80%">
	<p style="margin:0">Contato com o autor pode ser feito pelo email: contato@leandroamadeu.online!</p>
	<p style="margin:0">	
		<?php
			$arquivo = fopen("contador.txt","r"); // r = abre para leitura com ponteiro no início
			$cont = fread($arquivo, 21); //999 999 999 999 999 999 999 número máximo de acessos
			$cont++;
			$arquivo = fopen("contador.txt","w"); //abre p/ escrita com ponteiro no início e zera o arquivo.
			fwrite($arquivo, $cont);	// Escreve no arquivo, agora vazio, a variável incrementada.
			fclose($arquivo);
			$fakeNum = 13000+$cont;
			echo "Quantidade de acessos: $fakeNum<br/>"
		?>		
	</p>
	<p style="margin:0">© 2020-<?php echo date("Y");?></p>
</footer>

</body>
</html>