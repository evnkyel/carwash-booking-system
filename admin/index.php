<?php
session_start();
include '../config/config.php';
include '../classes/Booking.php';

$booking = new Booking($conn);

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Handle POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['id'])) {
    $booking_id = intval($_POST['id']);
    $action = $_POST['action'];

    if ($action === 'delete') {
        if ($booking->deleteBooking($booking_id)) {
            $_SESSION['success_message'] = "Booking deleted successfully!";
        }
    } elseif ($action === 'confirm') {
        $booking->updateStatus($booking_id, 'Confirmed');
        $_SESSION['success_message'] = "Booking confirmed successfully!";
    } elseif ($action === 'cancel') {
        $booking->updateStatus($booking_id, 'Cancelled');
        $_SESSION['success_message'] = "Booking cancelled successfully!";
    } elseif ($action === 'complete') {
        $booking->updateStatus($booking_id, 'Completed');
        $_SESSION['success_message'] = "Booking completed successfully!";
    }

    header("Location: index.php");
    exit();
}

$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$status = isset($_GET['status']) ? $_GET['status'] : 'all';
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$perPage = 8;
$offset = ($page - 1) * $perPage;

$search = $conn->real_escape_string($q);
$where = [];

if ($search !== '') {
    if (is_numeric($search)) {
        $where[] = "(u.name LIKE '%$search%' OR u.email LIKE '%$search%' OR b.booking_id = " . intval($search) . " )";
    } else {
        $where[] = "(u.name LIKE '%$search%' OR u.email LIKE '%$search%' OR b.service_type LIKE '%$search%')";
    }
}
if ($status !== 'all') {
    $where[] = "b.status = '" . $conn->real_escape_string($status) . "'";
}

$whereSQL = $where ? "WHERE " . implode(" AND ", $where) : "";

$countRes = $conn->query("SELECT COUNT(*) AS total FROM bookings b JOIN users u ON b.user_id=u.user_id $whereSQL");
$totalRows = $countRes->fetch_assoc()['total'];
$totalPages = max(1, ceil($totalRows / $perPage));

$sql = "SELECT b.booking_id,b.service_type,b.appointment_date,b.appointment_time,b.status,u.name,u.email
        FROM bookings b JOIN users u ON b.user_id=u.user_id
        $whereSQL
        ORDER BY b.booking_id DESC
        LIMIT $perPage OFFSET $offset";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Bookings</title>
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

        a {
            text-decoration: none;
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

        .main {
            flex: 1;
            padding: 30px;
        }

        .bookings-container {
            min-width: 950px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.6);
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #4d4d4d;
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            cursor: default;
            text-align: center;
            padding: 12px;
            border-bottom: 1px solid #ddd;
            vertical-align: middle;
        }

        th {
            background: #4A90E2;
            color: white;
        }

        tr:hover {
            background: #c4f0ff86;
        }

        .status {
            display: inline-flex;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 600;
            color: white;
            min-width: 90px;
            justify-content: center;
        }

        .status.Pending {
            background: #ffb300;
        }

        .status.Confirmed {
            background: #4caf50;
        }

        .status.Completed {
            background: #2196f3;
        }

        .status.Cancelled {
            background: #f44336;
        }

        .action-btn {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 13px;
            transition: 0.25s;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
            border: none;
            cursor: pointer;
            margin: 0 4px;
        }

        .action-btn.primary {
            background: #4A90E2;
            color: white;
        }

        .action-btn.primary:hover {
            background: #3c74b5;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
        }

        .action-btn.danger {
            background: #f44336;
            color: white;
        }

        .action-btn.danger:hover {
            background: #d32f2f;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="menu">
            <a href="index.php" class="active">
                <i class="fas fa-list"></i> Manage Bookings
            </a>
            <a href="services.php">
                <i class="fas fa-tools"></i> Edit Services
            </a>
            <a href="about.php">
                <i class="fas fa-info-circle"></i> Edit About Info
            </a>
            <a href="income.php">
                <i class="fas fa-coins"></i> Income
            </a>
        </div>
        <a href="../logout.php" class="logout">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>

    <div class="main">
        <div class="bookings-container">
            <h2>Manage Bookings</h2>

            <form method="get" style="text-align:center; margin-bottom:18px;">
                <input type="text" name="q" placeholder="Search..." value="<?= htmlspecialchars($q) ?>"
                    style="padding:8px; width:200px; border:1px solid #aaa; border-radius:4px;">
                <select name="status" onchange="this.form.submit()"
                    style="padding:8px; border:1px solid #aaa; border-radius:4px;">
                    <option value="all" <?= $status === 'all' ? 'selected' : '' ?>>All</option>
                    <option value="Pending" <?= $status === 'Pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="Confirmed" <?= $status === 'Confirmed' ? 'selected' : '' ?>>Confirmed</option>
                    <option value="Completed" <?= $status === 'Completed' ? 'selected' : '' ?>>Completed</option>
                    <option value="Cancelled" <?= $status === 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                </select>
                <button type="submit"
                    style="padding:8px 14px; border:none; background:#4A90E2; color:white; border-radius:6px; cursor:pointer;">
                    Search
                </button>
            </form>

            <?php if ($result && $result->num_rows > 0): ?>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Email</th>
                        <th>Service</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>

                    <?php while ($row = $result->fetch_assoc()): ?>
                        <?php
                        $date = date("M j, Y", strtotime($row['appointment_date']));
                        $time = date("g:i A", strtotime($row['appointment_time']));
                        ?>
                        <tr>
                            <td><?= $row['booking_id'] ?></td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= htmlspecialchars($row['service_type']) ?></td>
                            <td><?= $date ?></td>
                            <td><?= $time ?></td>
                            <td><span class="status <?= $row['status'] ?>"><?= $row['status'] ?></span></td>
                            <td>
                                <?php if ($row['status'] === 'Pending'): ?>
                                    <button class="action-btn primary" onclick="confirmAction('confirm', <?= $row['booking_id'] ?>)">Confirm</button>
                                    <button class="action-btn danger" onclick="confirmAction('cancel', <?= $row['booking_id'] ?>)">Cancel</button>

                                <?php elseif ($row['status'] === 'Confirmed'): ?>
                                    <button class="action-btn primary" onclick="confirmAction('complete', <?= $row['booking_id'] ?>)">Complete</button>
                                    <button class="action-btn danger" onclick="confirmAction('cancel', <?= $row['booking_id'] ?>)">Cancel</button>

                                <?php else: ?>
                                    <button class="action-btn danger" onclick="confirmAction('delete', <?= $row['booking_id'] ?>)">Delete</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>

                <div style="text-align:center;">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?= $i ?>&q=<?= urlencode($q) ?>&status=<?= urlencode($status) ?>"
                            style="margin:0 4px; padding:6px 10px; border:1px solid #999; border-radius:4px;
                              background:<?= $i == $page ? '#4A90E2' : 'white' ?>; color:<?= $i == $page ? 'white' : 'black' ?>;">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>
                </div>

            <?php else: ?>
                <p style="text-align:center; color:#777;">No bookings found.</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="../assets/toastify.js"></script>
    <script>
        function confirmAction(action, bookingId) {
            const messages = {
                delete: 'Are you sure you want to delete this booking?',
                confirm: 'Are you sure you want to confirm this booking?',
                cancel: 'Are you sure you want to cancel this booking?',
                complete: 'Are you sure you want to mark this booking as completed?'
            };

            const toastDiv = document.createElement('div');
            toastDiv.style.display = 'flex';
            toastDiv.style.flexDirection = 'column';
            toastDiv.style.alignItems = 'center';
            toastDiv.innerHTML = `
                <p style="margin-bottom:8px; font-weight:500;">${messages[action]}</p>
                <div style="display:flex; gap:10px;">
                    <button class="yes-btn" style="background:#f44336;color:white;border:none;padding:5px 12px;border-radius:6px;cursor:pointer;">Yes</button>
                    <button class="no-btn" style="background:#4caf50;color:white;border:none;padding:5px 12px;border-radius:6px;cursor:pointer;">No</button>
                </div>
            `;

            const toast = Toastify({
                node: toastDiv,
                duration: -1,
                close: false,
                gravity: "top",
                position: "center",
                style: {
                    background: "#4d4d4d",
                    borderRadius: "10px",
                    padding: "12px 16px",
                    color: "#fff",
                    textAlign: "center",
                    minWidth: "280px"
                }
            }).showToast();

            toastDiv.querySelector('.yes-btn').addEventListener('click', () => {
                submitAction(action, bookingId);
                toast.hideToast();
            });

            toastDiv.querySelector('.no-btn').addEventListener('click', () => {
                toast.hideToast();
            });
        }

        function submitAction(action, bookingId) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'index.php';

            const actionInput = document.createElement('input');
            actionInput.type = 'hidden';
            actionInput.name = 'action';
            actionInput.value = action;

            const idInput = document.createElement('input');
            idInput.type = 'hidden';
            idInput.name = 'id';
            idInput.value = bookingId;

            form.appendChild(actionInput);
            form.appendChild(idInput);
            document.body.appendChild(form);
            form.submit();
        }
    </script>

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