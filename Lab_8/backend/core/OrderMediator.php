<?php
class OrderMediator
{
    private $db;
    private $novaPoshtaRequester;

    public function __construct()
    {
        $this->db = Database_connect_l8::getInstance()->getConnection();
        $this->novaPoshtaRequester = new MyNovaPoshtaAPIRequester();
    }

    public function getCities($findByString)
    {
        return $this->novaPoshtaRequester->getCities($findByString);
    }

    public function getWarehouses($cityRef, $typeRef, $weight)
    {
        return $this->novaPoshtaRequester->getWarehouses($cityRef, $typeRef, $weight);
    }

    public function createOrder($data)
    {
        $orderNumber = $this->generateUniqueOrderNumber();

        $stmt = $this->db->prepare("INSERT INTO np_orders (order_number, weight, city_ref, delivery_type, warehouse_ref, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        if (!$stmt) {
            return [
                "success" => false,
                "message" => "Prepare failed: " . $this->db->error
            ];
        }

        $stmt->bind_param(
            'sdsss',
            $orderNumber,
            $data['weight'],
            $data['city_ref'],
            $data['delivery_type'],
            $data['warehouse_ref']
        );

        if ($stmt->execute()) {
            return [
                "success" => true,
                "message" => "Order created successfully",
                "order_number" => $orderNumber
            ];
        } else {
            return [
                "success" => false,
                "message" => "Failed to create order: " . $stmt->error
            ];
        }
    }

    private function generateUniqueOrderNumber()
    {
        return 'ORD-' . strtoupper(bin2hex(random_bytes(4)));
    }
}
