// Create the map using the specified DOM element
    var map = new ol.Map("ch1_simple_map");
    
    // Create an OpenStreeMap raster layer and add to the map
    var osm = new ol.Layer.OSM();
    map.addLayer(osm);
    
    // Set view to zoom maximum map extent
    map.zoomToMaxExtent();