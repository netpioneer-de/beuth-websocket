<?php
/**
 * Created by PhpStorm.
 * User: kobow
 * Date: 14.12.15
 * Time: 17:38
 */

if (isset($_POST["marker"])) {
    $markers = fopen("markers.txt", "a");
    fwrite($markers, $_POST['marker'] . "\n");
    fclose($markers);
}

