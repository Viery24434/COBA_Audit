<?php
// index.php

require_once 'config.php';
require_once 'Inventory.php';

$inventory = new Inventory();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['itemName']) && isset($_POST['itemQuantity']) && isset($_FILES['itemImage'])) {
        $itemName = $_POST['itemName'];
        $itemQuantity = $_POST['itemQuantity'];
        $itemImage = $_FILES['itemImage'];

        $inventory->addItem($itemName, $itemQuantity, $itemImage);
    } elseif (isset($_POST['export'])) {
        $inventory->exportToExcel();
    }
}

$items = $inventory->getItems();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Inventory System</h1>

    <form id="itemForm" enctype="multipart/form-data" method="POST">
        <label for="itemName">Nama Barang:</label>
        <input type="text" id="itemName" name="itemName" required><br><br>
        <label for="itemQuantity">Jumlah Barang:</label>
        <input type="number" id="itemQuantity" name="itemQuantity" required><br><br>
        <label for="itemImage">Gambar Barang:</label>
        <input type="file" id="itemImage" name="itemImage" accept="image/*" required><br><br>
        <button type="submit">Tambah Barang</button>
    </form>

    <h2>Daftar Barang</h2>
    <table>
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Gambar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                    <td><img src="<?php echo htmlspecialchars($item['image']); ?>" alt="Image" width="100"></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <form method="POST">
        <button type="submit" name="export">Ekspor ke Excel</button>
    </form>

    <script src="script.js"></script>
</body>
</html>