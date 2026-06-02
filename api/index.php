<?php
// api/index.php
header('Content-Type: application/json');

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod === 'GET') {
    echo json_encode([
        'status' => 'success',
        'message' => 'PHP is running on Vercel Serverless!',
        'data' => [
            'service' => 'cek ongkir',
            'courier' => 'Shipping API Simulation',
            'rate' => 15000
        ]
    ]);
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}

// 1. Database Connection
$host = 'localhost';
$user = 'root'; // Default XAMPP/WAMP username
$pass = '';     // Default XAMPP/WAMP password
$dbname = 'ecommerce_shipments';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 2. Handle CRUD Operations
$edit_state = false;
$id = 0;
$tracking_number = '';
$courier = '';
$recipient_name = '';
$status = '';

// CREATE
if (isset($_POST['save'])) {
    $tracking = $_POST['tracking_number'];
    $cour = $_POST['courier'];
    $recipient = $_POST['recipient_name'];
    $stat = $_POST['status'];

    $conn->query("INSERT INTO waybills (tracking_number, courier, recipient_name, status) VALUES ('$tracking', '$cour', '$recipient', '$stat')");
    header('location: index.php');
}

// UPDATE (Fetch record to edit)
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $edit_state = true;
    $record = $conn->query("SELECT * FROM waybills WHERE id=$id");
    if ($record->num_rows == 1) {
        $n = $record->fetch_array();
        $tracking_number = $n['tracking_number'];
        $courier = $n['courier'];
        $recipient_name = $n['recipient_name'];
        $status = $n['status'];
    }
}

// UPDATE (Save edited record)
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $tracking = $_POST['tracking_number'];
    $cour = $_POST['courier'];
    $recipient = $_POST['recipient_name'];
    $stat = $_POST['status'];

    $conn->query("UPDATE waybills SET tracking_number='$tracking', courier='$cour', recipient_name='$recipient', status='$stat' WHERE id=$id");
    header('location: index.php');
}

// DELETE
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM waybills WHERE id=$id");
    header('location: index.php');
}

// READ (Fetch all records)
$results = $conn->query("SELECT * FROM waybills");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping Waybill CRUD</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px; }
        .container { max-width: 800px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #333; color: white; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; }
        .form-group input, .form-group select { width: 100%; padding: 8px; box-sizing: border-box; }
        .btn { padding: 10px 15px; background: #28a745; color: white; border: none; cursor: pointer; border-radius: 4px; }
        .btn-edit { background: #ffc107; color: black; text-decoration: none; padding: 5px 10px; border-radius: 3px; }
        .btn-delete { background: #dc3545; color: white; text-decoration: none; padding: 5px 10px; border-radius: 3px; }
    </style>
</head>
<body>

<div class="container">
    <h2>Manage Waybills (Resi)</h2>

    <form method="POST" action="index.php">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        
        <div class="form-group">
            <label>Tracking Number</label>
            <input type="text" name="tracking_number" value="<?php echo $tracking_number; ?>" required>
        </div>
        <div class="form-group">
            <label>Courier</label>
            <input type="text" name="courier" value="<?php echo $courier; ?>" placeholder="e.g., JNE, SiCepat" required>
        </div>
        <div class="form-group">
            <label>Recipient Name</label>
            <input type="text" name="recipient_name" value="<?php echo $recipient_name; ?>" required>
        </div>
        <div class="form-group">
            <label>Status</label>
            <select name="status">
                <option value="Pending" <?php if($status == 'Pending') echo 'selected'; ?>>Pending</option>
                <option value="Shipped" <?php if($status == 'Shipped') echo 'selected'; ?>>Shipped</option>
                <option value="Delivered" <?php if($status == 'Delivered') echo 'selected'; ?>>Delivered</option>
            </select>
        </div>
        
        <div class="form-group">
            <?php if ($edit_state): ?>
                <button type="submit" name="update" class="btn" style="background: #007bff;">Update Record</button>
            <?php else: ?>
                <button type="submit" name="save" class="btn">Save Record</button>
            <?php endif ?>
        </div>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tracking Number</th>
                <th>Courier</th>
                <th>Recipient</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $results->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['tracking_number']; ?></td>
                    <td><?php echo $row['courier']; ?></td>
                    <td><?php echo $row['recipient_name']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td>
                        <a href="index.php?edit=<?php echo $row['id']; ?>" class="btn-edit">Edit</a>
                        <a href="index.php?delete=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Are you sure?');">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>