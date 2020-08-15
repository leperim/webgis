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
			z-index: 0;
		}
	</style>
	<style>
		/*#map { width: 800px; height: 500px; }*/
		.info { padding: 6px 8px; 							/*Duas caixas*/
			font: 14px/16px Arial, Helvetica, sans-serif;
			/*background: black; */
			background: rgba(255,255,255,0.8);
			box-shadow: 0 0 15px rgba(0,0,0,0.2);
			border-radius: 5px;
		} 
		.info h4 { 
			margin: 0 0 5px; 
			color: #777; 
		}
		.legend { 
			text-align: left; 			/*Caixa legenda*/
			line-height: 18px; 			/*provavel encavalada no celular*/
			color: #555; 
			
		} 
		.legend i { 
			width: 18px; 				/*Elementos da legenda*/
			height: 18px;
			float: left;
			background-color: green; 
			margin-right: 
			8px; opacity: 0.7; 
		}
	</style>

</head>
<body>
	<script src="feicoes.js" type="text/javascript"></script>
	<script src="PopESP.js" type="text/javascript"></script>
	<div id="mapid"></div>
	<script>

									//zoomDelta e zoomSnap só funcionam quando em conjunto. Descobrir o porquê.
		var myMap = L.map('mapid', {zoomDelta: 0.25, zoomSnap:0}).setView([-22.278931, -49.108887],6);
									//zoomDelta é o fracionamento da unidade de zoom que vem por padrão
									//zoomSnap não entendido. Quando !=0 && >1 desabilita o botão zoom +-

			//OPEN STREET MAP
			var baseMap = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
				attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
			});
			baseMap.addTo(myMap);

		//myMap.setZoom(5); //Config de zoom com rápida animação
		//myMap.setView([-22.278931, -49.108887],7); // Config de posição e zoom do mapa com rápida animação
		//myMap.flyTo([-22.278931, -49.108887],8,{animate: true, duration: 10});//\Permite configs de posição, zoom e tempo da animação 
		//myMap.zoomIn(1); //Incrementa nível de zoom com rápida animação. (1)=default ver zoom in(delta)
		//myMap.zoomOut(1); //Decrementa nível de zoom com rápida animação. (1)=default ver zoom out(delta)
		//myMap.setZoomAround([-22.639363, -44.143066], 8, false);//??Não entendi o critério para reposicionar o mapa (como usa coordenada passada?).
		//myMap.fitWorld();// Aplica zoom 0 ao mapa
		/*myMap.fitBounds([	//Define um BoundBox e enquadra o zoom nele. Só funciona bem em conjunto com zoomDelta e zoomSnap
			[-25.3,-53.1],
			[-19.7,-44.1]
			],{animate: true, duration: 10});	//Só será aplicado o nível de zoom, quando couber no Bounds*/
		//var bounds = [[-25.3,-53.1],[-19.7,-44.1]];
		//CONSTUINDO UM BOUND
		var corner1 = L.latLng(-25.3, -53.1),
		corner2 = L.latLng(-19.7, -44.1),
		bounds = L.latLngBounds(corner1, corner2);
		//APLICANDO O ZOOM PARA O TAMANHO DO BOUND
		myMap.flyToBounds(bounds,{animate: true, duration: 10}); //animate e duration são heranças de zoom option e pam option


		//BARRA DE ESCALA  maxWidth: 150 ?
		L.control.scale({maxWidth: 150}).addTo(myMap);


		// control that shows state info on hover
		var info = L.control();

		info.onAdd = function (mymap) {
			this._div = L.DomUtil.create('div', 'info');
			this.update();
			return this._div;
		};

		info.update = function (properties) {
			this._div.innerHTML = '<h4>São Paulo <br> Densidade Populacional</h4>' +  (properties ?
				'<b>' + properties.Nome + '</b><br />' + properties.Den_Demo + ' habitantes / km<sup>2</sup>'
				: 'Passe o mouse sobre o município');
		};

		//INSERE FERRAMENTA INFORMATIVA
		info.addTo(myMap);

		function getColor(d) {
		    return d > 7000 ? '#800026' :
		           d > 3000  ? '#BD0026' :
		           d > 500  ? '#E31A1C' :
		           d > 100  ? '#FC4E2A' :
		           d > 50   ? '#FD8D3C' :
		           d > 10   ? '#FEB24C' :
		           d > 3   ? '#FED976' :
		                      '#FFEDA0';
		}

		function style(feature) {
		    return {
		        fillColor: getColor(feature.properties.Den_Demo),
		        weight: 2,
		        opacity: 1,
		        color: 'white',
		        dashArray: '3',
		        fillOpacity: 0.8
		    };
		}

		function highlightFeature(e) {
		    var layer = e.target;

		    layer.setStyle({
		        weight: 5,
		        color: '#666',
		        dashArray: '',
		        fillOpacity: 0.7
		    });

		    if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
		        layer.bringToFront();
		    }
		    info.update(layer.feature.properties);
		};

		var geojson;

		function resetHighlight(e) {
		    geojson.resetStyle(e.target);
		    info.update();
		};

		function zoomToFeature(e) {
			myMap.fitBounds(e.target.getBounds());
		};

		function onEachFeature(feature, layer) {
			layer.on({
				mouseover: highlightFeature,
				mouseout: resetHighlight,
				click: zoomToFeature
			});
		};

		geojson = L.geoJson(PopESP, {
			style: style,
			onEachFeature: onEachFeature
		}).addTo(myMap);

		myMap.attributionControl.addAttribution(' | Dados sensitários: <a href="http://www.seade.gov.br/">IBGE/Fundação SEADE</a>');


		var legend = L.control({position: 'bottomright'});

		legend.onAdd = function (mymap) {

			var div = L.DomUtil.create('div', 'info legend'),
				grades = [0, 3, 10, 50, 100, 500, 3000, 7000],
				labels = [],
				from, to;

			for (var i = 0; i < grades.length; i++) {
				from = grades[i];
				to = grades[i + 1];

				labels.push(
					'<i style="background:' + getColor(from + 1) + '"></i> ' +
					from + (to ? '&ndash;' + to : '+'));
			}

			div.innerHTML = labels.join('<br>');
			return div;
		};
		legend.addTo(myMap);

		//Inserindo trecho SPVIAS
		var viario = L.geoJSON(spvias);//.addTo(mymap);
		var radio = {};
		var onoff = 
			{"Viário": viario,
			"ESP": geojson
		};

		L.control.layers("", onoff).addTo(myMap);

		var popup = L.popup();
		function onMapClick(e) {
		    popup
		        .setLatLng(e.latlng)
		        .setContent("Você clicou na coordenada " + e.latlng.toString())
		        .openOn(mymap);
		}
		myMap.on('click', onMapClick);



	</script>
	<button style="position:fixed; bottom:38px; left: 5px; z-index: 2"><a href="index.php" style="text-decoration: none"><b>INÍCIO<b><a></button>
</body>

</html>