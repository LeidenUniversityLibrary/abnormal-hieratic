<?php
/**
 * License: GPLv2 Copyright (c) 2019 Leiden University Libraries
*/
if ( $_SERVER['REQUEST_METHOD'] !== 'GET') {
    die ('You didn\'t GET it');
}
if ( isset($_GET['m']) && stripos($_GET['m'], 'https://iiif.universiteitleiden.nl/manifests/') === 0) {
    $manifest = $_GET['m'];
} else {
    $manifest = 'https://iiif.universiteitleiden.nl/manifests/external/louvre/e-7852.json';
}

?><!DOCTYPE html>
<html lang="en">
  <head>
    <title>Mirador – Papyrus 001</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
      #viewer {
        width: 100%;
        height: 100%;
        position: fixed;
      }
    </style>
    <link rel="stylesheet" type="text/css" href="/mirador/2.7.0/css/mirador-combined.css">
    <script src="/mirador/2.7.0/mirador.js"></script>
  </head>
  <body>
    <div id="viewer"></div>
    <script type="text/javascript">
      $(function() {
        var mir = Mirador({
          id: "viewer",
          buildPath: "/mirador/2.7.0/",
          data: [{manifestUri: "<?php echo $manifest; ?>", location: "Louvre"}],
          mainMenuSettings: {
            show: false
          },
          windowObjects: [{
            loadedManifest: "<?php echo $manifest; ?>",
            displayLayout: false,
            bottomPanel: false,
            bottomPanelAvailable: false,
            bottomPanelVisible: false,
            sidePanel: false
          }],
          availableAnnotationDrawingTools: [
            'Rectangle', 'Ellipse', 'Polygon'
          ],
          annotationEndpoint: {
            name: 'Simple Annotation Store Endpoint',
            module: 'SimpleASEndpoint',
            options: {
              url: 'https://iiif.universiteitleiden.nl/anno/annotation',
            }
          }
        });
        if (true) {
            mir.eventEmitter.publish('fitBounds.0', {'x': x, 'y': y, 'width': w, 'height': h});
        }
      });
    </script>
  </body>
</html>