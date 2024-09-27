<?php


if (isset($_GET['store_id']) && isset($_GET['owner_id'])) {
    $store_id = $_GET['store_id'];
    $owner_id = $_GET['owner_id'];
    

    echo ($store_id . " " . $owner_id);
} else {
    echo ("no id found");
}



?>