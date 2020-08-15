
<html>
<head>
  <title>SIGWEB - OpenLayers</title>
    <script language="javascript" type="text/JavaScript" src="OpenLayers/OpenLayers.js"></script>
</head>
    <body style="margin:0 0 22 0">
      <div style="width:100%; height:100%" id="map"></div>
      <script defer="defer" type="text/javascript">
        
		var bounds = new OpenLayers.Bounds(               
					-8072000, -3739000,
					-3880000, -276500
                );
		
		var options = {                    
		   
		   projection: "EPSG:3857"
		   
		};

			
		
		var map = new OpenLayers.Map('map', options);
        map.addControl(new OpenLayers.Control.MousePosition());	
		map.addControl(new OpenLayers.Control.ScaleLine());				
		map.addControl(new OpenLayers.Control.LayerSwitcher({'ascending':false}));
		
		
		
		
		
		var osm = new OpenLayers.Layer.OSM();
		map.addLayer(osm);
		
		var brasil = new OpenLayers.Layer.WMS( "Vegetação", 
            "http://geoservicos.ibge.gov.br/geoserver/ows", {layers: 'CREN:vegetacao_radambrasil', format: 'image/png', transparent:true }, {isBaseLayer:true} );
        map.addLayer(brasil); 
				
		var quadra_geo = new OpenLayers.Layer.WMS( "Geomorfologia", 
            "http://geoservicos.ibge.gov.br/geoserver/ows", {layers: 'CREN:Geomorfologia_Brasil', format: 'image/png', srs: 'EPSG:3857', transparent:true }, {isBaseLayer:false} );
		map.addLayer(quadra_geo);

		var quadra_geo = new OpenLayers.Layer.WMS( "Geologia", 
            "http://geoservicos.ibge.gov.br/geoserver/ows", {layers: 'CREN:Geologia_Brasil', format: 'image/png', srs: 'EPSG:3857', transparent:true }, {isBaseLayer:false} );
		map.addLayer(quadra_geo);

		/*var quadra_geo = new OpenLayers.Layer.WMS( "Bacia Hidrográfica BH", 
            "http://bhmap.pbh.gov.br/v2/api/idebhgeo/ows", {layers: 'Bacia Hidrografica', transparent:true }, {isBaseLayer:false} );
		map.addLayer(quadra_geo);*/

				/*var quadra_geo = new OpenLayers.Layer.WMS( "Áreas de Risco SP", 
            "https://ide.emplasa.sp.gov.br/geoserver/ows", {layers: 'Área de Risco - Polígono', transparent:true }, {isBaseLayer:false} );
		map.addLayer(quadra_geo);*/
		
		

		
		map.zoomToExtent(bounds);
		map.updateSize();
      </script>

	<button style="position:fixed; bottom:0; left: 0;"><a href="index.php" style="text-decoration: none"><b>INÍCIO</b></a></

</body>
</html>