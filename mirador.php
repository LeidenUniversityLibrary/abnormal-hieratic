<?php
/**
 * License: GPLv2 Copyright (c) 2019 Leiden University Libraries
*/
if ( $_SERVER['REQUEST_METHOD'] !== 'GET') {
    die ('You didn\'t GET it');
}
if ( isset($_GET['m']) && stripos($_GET['m'], 'https://lab.library.universiteitleiden.nl/manifests/') === 0) {
    $manifest = $_GET['m'];
} else {
    $manifest = 'https://lab.library.universiteitleiden.nl/manifests/external/louvre/e-7852.json';
}

?><!DOCTYPE html>
<html lang="en">
  <head>
    <title>Mirador</title>
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
      var mir;
      $(function() {
        mir = Mirador({
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
            sidePanel: false,
            id: "the_window"
          }],
          availableAnnotationDrawingTools: [
            'Rectangle', 'Ellipse', 'Polygon'
          ],
          annotationEndpoint: {
            name: 'Simple Annotation Store Endpoint',
            module: 'SimpleASEndpoint',
            options: {
              url: 'https://lab.library.universiteitleiden.nl/anno/annotation',
            }
          }
        });
        if (true) {
            console.log('before emit');
            console.log(mir.viewer);
            console.log(mir.eventEmitter);
            //var wid = mir.viewer.workspace.slots[0].window.id;
            var wid = "the_window";
            mir.eventEmitter.subscribe('annotationListLoaded.the_window', function(event) { console.log('received annolist loaded'); });
            mir.eventEmitter.subscribe('fitBounds.the_window', function(event, bounds) { console.log('received fitBounds'); });
            mir.eventEmitter.subscribe('imageBoundsUpdated', function(event, data) { 
              $.map(data.osdBounds, function(item, i) { 
                console.log('new bounds: ' + item); 
              }) 
            });
            console.log(wid);
            mir.eventEmitter.publish('fitBounds.'+wid, {'x': 0, 'y': 0, 'width': 200, 'height': 200});
            console.log('after emit');
        }
      });
    </script>
  </body>
</html>