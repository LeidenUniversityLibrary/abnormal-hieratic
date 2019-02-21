<?php
/*
License: GPLv2 Copyright (c) 2018 Leiden University Libraries
*/
if ( $_SERVER['REQUEST_METHOD'] !== 'GET') {
    die ('You didn\'t GET it');
}
if ( isset($_GET['q']) ) {
    $query = $_GET['q'];
} else {
    $query = '*';
}
$file = file_get_contents( 'http://localhost:9200/annotations/_search?q=' . $query );

// var_dump(json_decode($file, true));

$results = json_decode($file, true);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Search results</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<p>Results for <span><?php echo $query; ?></span></p>

<?php foreach($results['hits']['hits'] as $hit): ?>
<div>
    <h2><?php echo $hit['_source']['manifest_label'] . '→' . $hit['_source']['canvas_label'] . '#xywh=' . $hit['_source']['x'] . ','. $hit['_source']['y'] .','. $hit['_source']['w'] .','. $hit['_source']['h']; ?></h2>
    <img src="<?php echo $hit['_source']['image_full_url']; ?>">
    <?php foreach($hit['_source']['svg'] as $img): ?>
    
    <img src="<?php echo $img; ?>">
    <?php endforeach; ?>
<dl class="result">
    <dt>Transliteration</dt>
    <dd><?php echo $hit['_source']['transliteration']; ?></dd>
    <dt>Type</dt>
    <dd><?php echo $hit['_source']['type']; ?></dd>
    <dt>Translation</dt>
    <dd><?php echo $hit['_source']['translation']; ?></dd>
    <dt>Annotator</dt>
    <dd><?php echo $hit['_source']['annotator']; ?></dd>
</dl>
</div>
<?php endforeach; ?>
</body>
</html>