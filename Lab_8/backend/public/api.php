<?php
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

require '../core/Database_connect_l8.php';
require '../core/MyNovaPoshtaAPIRequester.php';
require '../core/OrderMediator.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$mediator = new OrderMediator();

$action = $_GET['action'] ?? null;

switch ($action) {
    case 'getCities':
        $findByString = $_GET['FindByString'] ?? '';
        if (strlen($findByString) < 3) {
            echo json_encode([
                "success" => false,
                "message" => "FindByString must be at least 3 characters long."
            ]);
            break;
        }
        $cities = $mediator->getCities($findByString);
        echo json_encode($cities);
        break;

    case 'getWarehouses':
        $cityRef = $_GET['CityRef'] ?? '';
        $typeRef = $_GET['TypeOfWarehouseRef'] ?? '';
        $weight = $_GET['weight'] ?? 0;

        if (empty($cityRef) || empty($typeRef) || empty($weight)) {
            echo json_encode([
                "success" => false,
                "message" => "CityRef, TypeOfWarehouseRef, and weight are required."
            ]);
            break;
        }

        $warehouses = $mediator->getWarehouses($cityRef, $typeRef, $weight);
        echo json_encode([
            "success" => true,
            "data" => array_values($warehouses)
        ]);
        break;

    case 'createOrder':
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['weight'], $data['city_ref'], $data['delivery_type'], $data['warehouse_ref'])) {
            echo json_encode([
                "success" => false,
                "message" => "Missing required fields."
            ]);
            break;
        }

        $orderResult = $mediator->createOrder($data);
        echo json_encode($orderResult);
        break;

    default:
        echo json_encode([
            "success" => false,
            "message" => "Invalid action."
        ]);
}