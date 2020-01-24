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
<p>This form allows you to search within the annotated papyri using (parts of) transliterations, the name of the annotator, translations or word type.
    By default all fields are searched.
</p>
<form id="search" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
    <input name="q" type="text" placeholder="Your query…" value="<?php echo $query; ?>" />
    <input type="submit" value="Search" />
</form>
<p id="show-instructions">Show/hide full search instructions ›</p>
<div id="instructions" style="display: none;">
<p>
By default, the query you enter is used to search all fields.
This makes it easy to get results, although you may limit what fields are searched by using this syntax:</p>

<code>field_name:query</code>

<p>Note that there are no spaces around the colon.</p>

<p>Available (useful) field names are</p>
<ul>
    <li><code>transliteration</code></li>
    <li><code>translation</code></li>
    <li><code>type</code> (type of word)</li>
    <li><code>annotator</code></li>
</ul>

<p>Example searches using this query syntax:</p>
<ul>
    <li><code>translation:field</code></li>
    <li><code>transliteration:I͗mn</code></li>
    <li><code>annotator:Juan</code></li>
</ul>
</div>
<p>Results for <span class="searchterm"><?php echo $query; ?></span> (<?php echo $results['hits']['total']['value']; ?> results found)</p>

<?php foreach($results['hits']['hits'] as $hit):
    $source = $hit['_source'];
    $url = $source['portal_url'] . '?anno=' . $source['uri'] ?>
<div class="result-hit">
    <?php if ($source['transliteration'] != ""): ?>
    <h2 class="result-link"><a href="<?php echo $url; ?>" target="_blank" title="View annotation in context"><span class="transliteration"><?php echo $source['transliteration'] ; ?></span> (<?php echo $source['canvas_label']; ?>)</a></h2>
    <?php else: ?>
    <h2 class="result-link"><a href="<?php echo $url; ?>" target="_blank" title="View annotation in context">[Annotation without transliteration] (<?php echo $source['canvas_label']; ?>)</a></h2>
    <?php endif; ?>
    <a href="<?php echo $url; ?>" target="_blank" title="View annotation in context"><img src="<?php echo $source['image_full_url']; ?>"></a>
    <div class="hieroglyphs" style="width: <?php echo $source['w']; ?>px;">
    <?php foreach($source['svg'] as $img): ?>
    <img src="<?php echo $img; ?>">
    <?php endforeach; ?></div>
<dl class="result-list">
    <dt>Transliteration</dt>
    <dd class="transliteration"><?php echo $source['transliteration']; ?></dd>
    <dt>Type</dt>
    <dd><?php echo $source['type']; ?></dd>
    <dt>Translation</dt>
    <dd><?php echo $source['translation']; ?></dd>
</dl>
<p class="anno-prov">Added to <?php echo $source['manifest_label']; ?> by <?php echo ($source['annotator'] != "")? $source['annotator'] : "unknown"; ?>.</p>
</div>
<?php endforeach; ?>
<footer>
    <p>Return to the <a href="https://lab.library.universiteitleiden.nl/abnormalhieratic/">Abnormal Hieratic Global Portal</a>.</p>
</footer>
<script type="text/javascript">
const instructions = document.querySelector('#instructions');
const s = document.querySelector('#show-instructions');
s.onclick = toggleInstructions;

function toggleInstructions(e) {
    if (instructions.style.display === 'none') {
        instructions.style.display = 'block';
    } else {
        instructions.style.display = 'none';
    }
}</script>
</body>
</html>