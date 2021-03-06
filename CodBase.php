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

</head>
<body style="overflow: auto";>

	<div id="mapid"></div>
<!--<script src="feicoes.js" type="text/javascript"></script> - REFERÊNCIA PARA GoeJSON -->

	<script>
		var map = L.map('mapid').setView([-23.645632, -46.642145], 15);
		//Open Steet Map
		var baseMap = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
			attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
		});
		baseMap.addTo(map);	

		//BARRA DE ESCALA
		L.control.scale({maxWidth: 150}).addTo(map);
	</script>

<button style="position:fixed; bottom:38px; left: 5px; z-index: 2"><a href="index.php" style="text-decoration: none"><b>INÍCIO<b><a></button>
<footer>
</footer>

</body>
</html>