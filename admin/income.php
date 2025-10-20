<?php
session_start();
include '../config/config.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

date_default_timezone_set('Asia/Manila');
$today = date('Y-m-d');

$todaySql = "SELECT IFNULL(SUM(s.price),0) AS total
             FROM bookings b
             JOIN services s ON b.service_type = s.service_name
             WHERE b.status = 'Completed' AND DATE(b.completed_at) = '$today'";
$todayRes = $conn->query($todaySql);
$todayTotal = $todayRes ? floatval($todayRes->fetch_assoc()['total']) : 0;

$monthSql = "SELECT IFNULL(SUM(s.price),0) AS total
             FROM bookings b
             JOIN services s ON b.service_type = s.service_name
             WHERE b.status = 'Completed' AND YEAR(b.appointment_date) = YEAR(CURDATE()) AND MONTH(b.appointment_date) = MONTH(CURDATE())";
$monthRes = $conn->query($monthSql);
$monthTotal = $monthRes ? floatval($monthRes->fetch_assoc()['total']) : 0;

$allSql = "SELECT IFNULL(SUM(s.price),0) AS total
           FROM bookings b
           JOIN services s ON b.service_type = s.service_name
           WHERE b.status = 'Completed'";
$allRes = $conn->query($allSql);
$allTotal = $allRes ? floatval($allRes->fetch_assoc()['total']) : 0;

$listSql = "SELECT b.booking_id, b.appointment_date, b.appointment_time, b.service_type, u.name, s.price
            FROM bookings b
            JOIN services s ON b.service_type = s.service_name
            JOIN users u ON b.user_id = u.user_id
            WHERE b.status = 'Completed'
            ORDER BY b.appointment_date DESC, b.appointment_time DESC
            LIMIT 200";
$list = $conn->query($listSql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Income</title>
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

        .kpi {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-bottom: 18px
        }

        .kpi .box {
            background: #fff;
            padding: 12px;
            border-radius: 8px;
            min-width: 180px;
            border: 1px solid #ddd;
            text-align: center
        }

        .kpi .box h3 {
            margin: 6px 0;
            color: #4A90E2
        }

        .table {
            width: 100%;
            border-collapse: collapse
        }

        .table th,
        .table td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ddd
        }

        .table th {
            background: #4A90E2;
            color: #fff
        }

        .small {
            font-size: 13px;
            color: #444
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="menu">
            <a href="index.php"><i class="fas fa-list"></i> Manage Bookings</a>
            <a href="services.php"><i class="fas fa-tools"></i> Edit Services</a>
            <a href="about.php"><i class="fas fa-info-circle"></i> Edit About Info</a>
            <a href="income.php" class="active"><i class="fas fa-coins"></i> Income</a>
        </div>
        <a href="../logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="main">
        <div class="card">
            <h2>Income Reports</h2>

            <div class="kpi">
                <div class="box">
                    <div class="small">Today's total</div>
                    <h3>₱ <?= number_format($todayTotal, 0) ?></h3>
                </div>
                <div class="box">
                    <div class="small">This month</div>
                    <h3>₱ <?= number_format($monthTotal, 0) ?></h3>
                </div>
                <div class="box">
                    <div class="small">All time</div>
                    <h3>₱ <?= number_format($allTotal, 0) ?></h3>
                </div>
            </div>

            <h3 style="text-align:center;margin-top:8px;color:#444">Completed Bookings (recent)</h3>

            <table class="table" style="margin-top:12px">
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Service</th>
                    <th>Price</th>
                    <th>Date</th>
                    <th>Time</th>
                </tr>
                <?php if ($list && $list->num_rows): ?>
                    <?php while ($r = $list->fetch_assoc()): ?>
                        <tr>
                            <td><?= intval($r['booking_id']) ?></td>
                            <td><?= htmlspecialchars($r['name']) ?></td>
                            <td><?= htmlspecialchars($r['service_type']) ?></td>
                            <td>₱ <?= number_format($r['price'], 0) ?></td>
                            <td><?= htmlspecialchars(date("M j, Y", strtotime($r['appointment_date']))) ?></td>
                            <td><?= htmlspecialchars(date("g:i A", strtotime($r['appointment_time']))) ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No completed bookings yet.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</body>
</html>