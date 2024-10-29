<?php
// Inventory.php

class Inventory {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function addItem($itemName, $itemQuantity, $itemImage) {
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($itemImage['name']);
        move_uploaded_file($itemImage['tmp_name'], $uploadFile);

        $query = "INSERT INTO items (name, quantity, image) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sis", $itemName, $itemQuantity, $uploadFile);
        $stmt->execute();
    }

    public function getItems() {
        $query = "SELECT * FROM items";
        $result = $this->conn->query($query);
        $items = array();
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        return $items;
    }

    public function exportToExcel() {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="inventory_data.csv"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['Nama Barang', 'Jumlah', 'Gambar']);

        $items = $this->getItems();
        foreach ($items as $item) {
            fputcsv($output, [$item['name'], $item['quantity'], $item['image']]);
        }

        fclose($output);
        exit();
    }
}
?>