<?php
session_start();
include '../config/config.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$about = $conn->query("SELECT * FROM about_info WHERE id = 1 LIMIT 1");
$aboutRow = $about && $about->num_rows ? $about->fetch_assoc() : ['title' => 'About', 'description' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_about'])) {
    $title = trim($_POST['title']);
    $desc = trim($_POST['description']);

    $exists = $conn->query("SELECT id FROM about_info WHERE id = 1 LIMIT 1");
    if ($exists && $exists->num_rows) {
        $stmt = $conn->prepare("UPDATE about_info SET title = ?, description = ? WHERE id = 1");
        $stmt->bind_param("ss", $title, $desc);
        $stmt->execute();
        $stmt->close();
        $_SESSION['success_message'] = "About information updated successfully!";
    } else {
        $stmt = $conn->prepare("INSERT INTO about_info (title, description) VALUES (?, ?)");
        $stmt->bind_param("ss", $title, $desc);
        $stmt->execute();
        $stmt->close();
        $_SESSION['success_message'] = "About information saved successfully!";
    }
    header("Location: about.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Edit About Info</title>
    <link rel="stylesheet" href="../assets/toastify.css">
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to bottom, #B2EBF2, #E0F7FA);
            min-height: 100vh;
            margin: 0;
            display: flex
        }

        .sidebar {
            width: 180px;
            background: #4A90E2;
            color: white;
            padding: 20px 10px;
            display: flex;
            flex-direction: column;
            justify-content: space-between
        }

        .sidebar .menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            color: white;
            padding: 10px;
            border-radius: 6px;
            font-size: 14px;
            margin-bottom: 6px
        }

        .sidebar .menu a.active {
            background: white;
            color: #4A90E2;
            font-weight: 600
        }

        .sidebar .logout {
            padding: 10px;
            background: #d64545;
            text-align: center;
            border-radius: 6px;
            color: white;
            font-weight: 600;
            margin-top: 10px
        }
        
        a {
            text-decoration: none;
        }

        .main {
            flex: 1;
            padding: 30px
        }

        .card {
            min-width: 900px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.6);
            padding: 24px;
            border-radius: 12px
        }

        h2 {
            text-align: center;
            color: #4d4d4d;
            margin-bottom: 18px
        }

        .form-group {
            margin-bottom: 12px
        }

        label {
            display: block;
            margin-bottom: 6px;
            color: #333;
            font-weight: 600
        }

        textarea {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #aaa;
            min-height: 200px
        }

        input[type=text] {
            width: 100%;
            padding: 8px;
            border-radius: 6px;
            border: 1px solid #aaa
        }

        .btn-save {
            background: #4A90E2;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer
        }

        .btn-save:hover {
            background: #3b75b6ff;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="menu">
            <a href="index.php"><i class="fas fa-list"></i> Manage Bookings</a>
            <a href="services.php"><i class="fas fa-tools"></i> Edit Services</a>
            <a href="about.php" class="active"><i class="fas fa-info-circle"></i> Edit About Info</a>
            <a href="income.php"><i class="fas fa-coins"></i> Income</a>
        </div>
        <a href="../logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="main">
        <div class="card">
            <h2>Edit About Info</h2>
            <form method="post" style="max-width:800px;margin:0 auto">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" required value="<?= htmlspecialchars($aboutRow['title']) ?>">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description"><?= htmlspecialchars($aboutRow['description']) ?></textarea>
                </div>
                <div style="text-align:center">
                    <button class="btn-save" name="save_about" type="submit">Save About</button>
                </div>
            </form>
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
        </script>
        ";
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
        </script>
        ";
        unset($_SESSION['success_message']);
    }
    ?>
</body>
</html>