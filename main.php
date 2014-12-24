<?php

require 'boundingbox.class.php';
$bbox = new BoundingBox(-80.1, -77.895029, 38.045834, 40.23434);
$hashes = $bbox->getCoveringGeoHashes();
var_dump($hashes);

?>
