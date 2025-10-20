<?php
session_start();
include '../config/config.php';
include '../classes/Service.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$serviceClass = new Service($conn);

$action = $_GET['action'] ?? null;
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

if ($action === 'delete' && $id) {
    if ($serviceClass->delete($id)) {
        $_SESSION['success_message'] = "Service deleted successfully!";
    } else {
        $_SESSION['error_message'] = "Failed to delete service.";
    }
    header("Location: services.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_service'])) {
    $id = !empty($_POST['id']) ? intval($_POST['id']) : null;

    $data = [
        'service_name' => isset($_POST['service_name']) ? trim($_POST['service_name']) : '',
        'image'        => isset($_POST['image']) ? trim($_POST['image']) : '',
        'price'        => isset($_POST['price']) ? floatval($_POST['price']) : 0,
        'description'  => isset($_POST['description']) ? trim($_POST['description']) : '',
        'best_for'     => isset($_POST['best_for']) ? trim($_POST['best_for']) : ''
    ];

    if ($data['service_name'] === '' || $data['price'] <= 0) {
        $_SESSION['error_message'] = "Please fill out the service name and a valid price.";
        header("Location: services.php");
        exit();
    }

    if ($id) {
        $updated = $serviceClass->update($id, $data);
        $_SESSION[$updated ? 'success_message' : 'error_message'] =
            $updated ? "Service updated successfully!" : "Failed to update service.";
    } else {
        $created = $serviceClass->create(
            $data['service_name'],
            $data['image'],
            $data['price'],
            $data['description'],
            $data['best_for']
        );
        $_SESSION[$created ? 'success_message' : 'error_message'] =
            $created ? "Service added successfully!" : "Failed to add service.";
    }

    header("Location: services.php");
    exit();
}

$editRow = null;
if ($action === 'edit' && $id) {
    $editRow = $serviceClass->getById($id);
}

$services = $serviceClass->getAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Edit Services</title>
    <link rel="stylesheet" href="../assets/toastify.css">
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to bottom, #B2EBF2, #E0F7FA);
            min-height: 100vh;
            margin: 0;
            display: flex;
        }

        .sidebar {
            width: 180px;
            background: #4A90E2;
            color: white;
            padding: 20px 10px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .sidebar .menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            color: white;
            padding: 10px;
            border-radius: 6px;
            font-size: 14px;
            margin-bottom: 6px;
        }

        .sidebar .menu a.active {
            background: white;
            color: #4A90E2;
            font-weight: 600;
        }

        .sidebar .logout {
            padding: 10px;
            background: #d64545;
            text-align: center;
            border-radius: 6px;
            color: white;
            font-weight: 600;
            margin-top: 10px;
        }

        a {
            text-decoration: none;
        }

        .main {
            flex: 1;
            padding: 30px;
        }

        .card {
            min-width: 900px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.6);
            padding: 24px;
            border-radius: 12px;
        }

        h2 {
            text-align: center;
            color: #4d4d4d;
            margin-bottom: 18px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        .table th,
        .table td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        .table th {
            background: #4A90E2;
            color: #fff;
        }

        .row-actions a {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 6px;
            margin: 0 4px;
            color: #fff;
            font-weight: 700;
            transition: 0.2s;
        }

        .edit-btn {
            background: #4A90E2;
        }

        .edit-btn:hover {
            background: #3c74b5;
            transform: translateY(-2px);
        }

        .del-btn {
            background: #f44336;
        }

        .del-btn:hover {
            background: #d32f2f;
            transform: translateY(-2px);
        }

        .form-group {
            margin-bottom: 10px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            color: #333;
            font-weight: 600;
        }

        input[type=text],
        input[type=number] {
            width: 100%;
            padding: 8px;
            border: 1px solid #aaa;
            border-radius: 6px;
        }

        textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #aaa;
            border-radius: 6px;
            resize: none;
        }

        .btn-save {
            background: #4A90E2;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .btn-save:hover {
            background: #3b75b6ff;
        }

        .btn-cancel {
            background: #f44336;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .btn-cancel:hover {
            background: #d32f2f;
        }

        .small {
            font-size: 13px;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="menu">
            <a href="index.php"><i class="fas fa-list"></i> Manage Bookings</a>
            <a href="services.php" class="active"><i class="fas fa-tools"></i> Edit Services</a>
            <a href="about.php"><i class="fas fa-info-circle"></i> Edit About Info</a>
            <a href="income.php"><i class="fas fa-coins"></i> Income</a>
        </div>
        <a href="../logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="main">
        <div class="card">
            <h2>Edit Services</h2>

            <div style="max-width:760px;margin:0 auto 18px;">
                <form method="post">
                    <input type="hidden" name="id" value="<?= $editRow ? intval($editRow['id']) : '' ?>">
                    <div class="form-group">
                        <label>Service name</label>
                        <input type="text" name="service_name" required value="<?= $editRow ? htmlspecialchars($editRow['service_name']) : '' ?>">
                    </div>
                    <div class="form-group">
                        <label>Image filename (e.g. serv1.png)</label>
                        <input type="text" name="image" value="<?= $editRow ? htmlspecialchars($editRow['image']) : '' ?>">
                    </div>
                    <div class="form-group">
                        <label>Price (PHP)</label>
                        <input type="number" name="price" min="0" required step="1" value="<?= $editRow ? htmlspecialchars($editRow['price']) : '' ?>">
                    </div>
                    <div class="form-group">
                        <label>Best for (short text)</label>
                        <input type="text" name="best_for" value="<?= $editRow ? htmlspecialchars($editRow['best_for']) : '' ?>">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" rows="4"><?= $editRow ? htmlspecialchars($editRow['description']) : '' ?></textarea>
                    </div>

                    <div style="display:flex;gap:8px;justify-content:center">
                        <button type="submit" name="save_service" class="btn-save"><?= $editRow ? 'Save changes' : 'Add service' ?></button>
                        <?php if ($editRow): ?>
                            <a href="services.php" class="btn-cancel">Cancel</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <table class="table">
                <tr>
                    <th>ID</th>
                    <th>Service</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Best for</th>
                    <th>Actions</th>
                </tr>
                <?php if ($services && $services->num_rows): ?>
                    <?php while ($s = $services->fetch_assoc()): ?>
                        <tr>
                            <td><?= intval($s['id']) ?></td>
                            <td><?= htmlspecialchars($s['service_name']) ?></td>
                            <td class="small"><?= htmlspecialchars($s['image']) ?></td>
                            <td>₱ <?= number_format($s['price'], 0) ?></td>
                            <td><?= htmlspecialchars($s['best_for']) ?></td>
                            <td class="row-actions">
                                <a class="edit-btn" href="services.php?action=edit&id=<?= intval($s['id']) ?>">Edit</a>
                                <a class="del-btn" href="services.php?action=delete&id=<?= intval($s['id']) ?>" onclick="return confirm('Delete this service?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No services found.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>

    <script src="../assets/toastify.js"></script>
    <?php
    if (isset($_SESSION['error_message'])) {
        echo "
        <script>
        window.addEventListener('DOMContentLoaded', () => {
            Toastify({
                text: '" . addslashes($_SESSION['error_message']) . "',
                duration: 3000,
                gravity: 'top',
                position: 'center',
                close: true,
                style: {
                    background: 'linear-gradient(to right, #ff5f6d, #ffc371)',
                    borderRadius: '10px',
                    color: '#fff',
                    textAlign: 'center'
                }
            }).showToast();
        });
        </script>";
        unset($_SESSION['error_message']);
    }

    if (isset($_SESSION['success_message'])) {
        echo "
        <script>
        window.addEventListener('DOMContentLoaded', () => {
            Toastify({
                text: '" . addslashes($_SESSION['success_message']) . "',
                duration: 3000,
                gravity: 'top',
                position: 'center',
                close: true,
                style: {
                    background: 'linear-gradient(to right, #00b09b, #96c93d)',
                    borderRadius: '12px',
                    fontSize: '16px',
                    textAlign: 'center'
                }
            }).showToast();
        });
        </script>";
        unset($_SESSION['success_message']);
    }
    ?>
</body>

</html>