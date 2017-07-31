<?php
$clients_address = array("ip"=>$_SERVER['REMOTE_ADDR']);
$clients_address_json = json_encode($clients_address);
echo $clients_address_json;
?>
