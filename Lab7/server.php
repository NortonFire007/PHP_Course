<?php
require_once 'request.php';

$response = handleRequest();

header('Content-Type: application/json');
echo json_encode($response);
