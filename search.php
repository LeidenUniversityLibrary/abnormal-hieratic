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
    <link href="assets/css/search.css" rel="stylesheet" />
</head>
<body>
<h1>Search papyrus contents</h1>
<p>This form allows you to search within the annotated papyri using (parts of) transliterations, the name of the annotator, translations or word type.</p>
<form id="search" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
    <input name="q" type="text" placeholder="Your query…" value="<?php echo $query; ?>" />
    <input type="submit" value="Search" />
</form>
<div>
<p>
By default, the query you enter is used to search all fields.
This makes it easy to get results, although you may limit what fields are searched by using this syntax:</p>

<code>field_name:query</code>

<p>Note that there are no spaces around the colon.</p>

<p>Available (useful) field names are</p>
<ul>
    <li>transliteration</li>
    <li>translation</li>
    <li>type (type of word)</li>
    <li>annotator</li>
</ul>

<p>Example searches using this query syntax:</p>
<ul>
    <li>translation:field</li>
    <li>transliteration:I͗mn</li>
    <li>annotator:Juan</li>
</ul>
</div>
<p>Results for <span class="searchterm"><?php echo $query; ?></span> (<?php echo $results['hits']['total']['value']; ?> results found)</p>

<?php foreach($results['hits']['hits'] as $hit):
    $url = $hit['_source']['portal_url'] . '?anno=' . $hit['_source']['uri'] ?>
<div>
    <h2><?php echo $hit['_source']['manifest_label'] . '→' . $hit['_source']['canvas_label']; ?></h2>
    <p><a href="<?php echo $url; ?>" target="_blank">View 
    <?php echo $hit['_source']['canvas_label']; ?> in portal</a></p>
    <a href="<?php echo $url; ?>" target="_blank"><img src="<?php echo $hit['_source']['image_full_url']; ?>"></a>
    <div class="hieroglyphs" style="width: <?php echo $hit['_source']['w']; ?>px;">
    <?php foreach($hit['_source']['svg'] as $img): ?>
    <img src="<?php echo $img; ?>">
    <?php endforeach; ?></div>
<dl class="result">
    <dt>Transliteration</dt>
    <dd class="transliteration"><?php echo $hit['_source']['transliteration']; ?></dd>
    <dt>Type</dt>
    <dd><?php echo $hit['_source']['type']; ?></dd>
    <dt>Translation</dt>
    <dd><?php echo $hit['_source']['translation']; ?></dd>
    <dt>Annotator</dt>
    <dd><?php echo $hit['_source']['annotator']; ?></dd>
</dl>
</div>
<?php endforeach; ?>
<footer>
    <p>Return to the <a href="https://lab.library.universiteitleiden.nl/abnormalhieratic/">Abnormal Hieratic Global Portal</a>.</p>
</footer>
</body>
</html>