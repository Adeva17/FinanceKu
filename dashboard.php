<?php
session_start();
include('dbconn.php');

// Periksa apakah pengguna sudah berhasil login
if (!isset($_SESSION['userId']) || !isset($_SESSION['nickname'])) {
    // Redirect to login page if not logged in
    header('Location: login.php');
    exit();
}

// Ambil nama pengguna dari sesi
$nickname = $_SESSION['nickname'];
$userId = $_SESSION['userId'];

// Buat Koneksi
$conn = getConnection();

// Menangani pengiriman formulir untuk memperbarui anggaran
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['budget'])) {
    $newBudget = floatval($_POST['budget']);
    $currentYear = date('Y');
    $currentMonth = date('n');

    // Memperbarui budget dalam database
    $BudgetQuery = "INSERT INTO budgets (userId, year, month, amount) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE amount = VALUES(amount)";
    $stmt = $conn->prepare($updateBudgetQuery);
    $stmt->bind_param("iiid", $userId, $currentYear, $currentMonth, $newBudget);
    $stmt->execute();
    $stmt->close();
}

// Ambil data pemasukan untuk pengguna
$incomeQuery = "SELECT SUM(amount) AS totalIncome FROM income WHERE userId = ?";
$stmt = $conn->prepare($incomeQuery);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$totalIncome = isset($row['totalIncome']) ? $row['totalIncome'] : 0.00;
$stmt->close();

// Ambil data pengeluaran untuk pengguna
$expenseQuery = "SELECT SUM(amount) AS totalExpenses FROM expense WHERE userId = ?";
$stmt = $conn->prepare($expenseQuery);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$totalExpenses = isset($row['totalExpenses']) ? $row['totalExpenses'] : 0.00;
$stmt->close();

// Ambil anggaran bulan ini untuk pengguna
$currentYear = date('Y');
$currentMonth = date('n');
$budgetQuery = "SELECT amount FROM budgets WHERE userId = ? AND year = ? AND month = ?";
$stmt = $conn->prepare($budgetQuery);
$stmt->bind_param("iii", $userId, $currentYear, $currentMonth);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$currentBudget = isset($row['amount']) ? $row['amount'] : 0.00;
$stmt->close();

// Menghitung Saldo Akhir
$saldoAkhir = $currentBudget + $totalIncome - $totalExpenses;

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(180deg, #FFFFFF 0%, #D0D0D0 100%);
            background-attachment: fixed;
            overflow-x: hidden;
        }

        .dashboard {
            position: relative;
            width: 100%;
            height: 100%;
            padding: 20px;
            box-sizing: border-box;
        }

        .head-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0;
            margin-bottom: 20px;
            margin-top: 15px;
        }

        .title {
            font-size: 35px;
            font-weight: 700;
            color: #000000;
            margin-left: 20px;
        }

        .menu {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .menu img {
            width: 24px;
            height: 24px;
            cursor: pointer;
        }

        .logout {
            display: flex;
            align-items: center;
            cursor: pointer;
            margin-right: 20px;
            background-color: #000;
            color: #fff;
            border: none;
            border-radius: 15px;
            padding: 8px 16px;
            font-size: 16px;
            font-weight: 500;
            text-decoration: none;
        }

        .logout a {
            color: #fff;
            text-decoration: none;
        }

        .hero {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 12px;
            width: 100%;
            margin-bottom: 20px;
            margin-top: 60px;
        }

        .hero .hello {
            font-weight: 500;
            font-size: 40px;
            text-align: center;
            color: #000000;
        }

        .hero .budget-info {
            font-weight: 400;
            font-size: 16px;
            text-align: center;
            color: #828282;
        }

        .hero .budget-amount {
            font-weight: 700;
            font-size: 85px;
            text-align: center;
            color: #000000;
        }

        .frame-2 {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 16px;
            width: 300px;
            height: 40px;
            margin: auto;
        }

        .primary-button {
            background-color: #000;
            color: #fff;
            border-radius: 15px;
            padding: 8px 16px;
            cursor: pointer;
        }

        .primary-button a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            font-size: 16px;
        }

        .recap-keuangan {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            width: 100%;
            max-width: 1457px;
            margin: auto;
            margin-top: 70px;
            padding: 0 150px;
            box-sizing: border-box;
        }

        .frame-7 {
            display: grid;
            grid-template-columns: 1fr auto;
            width: 100%;
            box-sizing: border-box;
            padding: 0 43px;
        }

        .frame-7 .mei-2024,
        .frame-7 .lihat-detail {
            font-weight: 700;
            color: #828282;
        }

        .frame-7 .mei-2024 {
            font-size: 18px;
        }

        .frame-7 .lihat-detail {
            font-size: 16px;
            text-decoration: underline;
            cursor: pointer;
        }

        .frame-6 {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            gap: 20px;
            width: 100%;
            padding: 0 20px;
            box-sizing: border-box;
        }

        .budgetting {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 16px;
            gap: 16px;
            width: 200px;
            background: #F6F6F6;
            box-shadow: -4px 8px 20px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            margin-right: 20px; 
            margin-left: 20px;
        }

        .budgetting .amount {
            font-weight: 700;
            font-size: 24px;
            color: #000000;
        }

        .budgetting .details {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .budgetting .details .edit {
            font-weight: 400;
            font-size: 14px;
            text-decoration: underline;
            color: #828282;
            cursor: pointer;
        }

        .budgetting .details .text {
            font-weight: 400;
            font-size: 14px;
            color: #000000;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <div class="head-bar">
            <div class="title">Financeku.</div>
            <div class="menu">
                <a href="aturBudget.php">
                    <img src="img/plus.png" alt="Add Icon">
                </a>
                <a href="halaman_laporan.php">
                    <img src="img/report.png" alt="Report Icon">
                </a>
                <button class="logout">
                    <a href="logout.php">Log out</a>
                </button>
            </div>
        </div>
        <div class="hero">
            <div class="hello" id="hello">Hello, <?php echo htmlspecialchars($nickname); ?></div>
            <div class="budget-info">Budget bulanan anda tersisa:</div>
            <div class="budget-amount" id="budget-amount">Rp <?php echo number_format($saldoAkhir, 2); ?></div>
            <div class="frame-2">
                <div class="primary-button">
                    <a href="pemasukan.php">Pemasukan</a>
                </div>
                <div class="primary-button">
                    <a href="pengeluaran.php">Pengeluaran</a>
                </div>
            </div>
        </div>
        <div class="recap-keuangan">
            <div class="frame-7">
                <div class="mei-2024" id="current-month-year">Mei 2024</div>
                <a href="halaman_laporan.php" class="lihat-detail-link">
                    <div class="lihat-detail">Lihat Detail</div>
                </a>
            </div>
            <div class="frame-6">
                <div class="budgetting">
                    <div class="amount" id="saldo-awal">Rp <?php echo number_format($currentBudget, 2); ?></div>
                    <div class="details">
                        <div class="edit">Edit</div>
                        <div class="text">Saldo Awal</div>
                    </div>
                </div>
                <div class="budgetting">
                    <div class="amount" id="pemasukan">Rp <?php echo number_format($totalIncome, 2); ?></div>
                    <div class="details">
                        <div class="edit">Edit</div>
                        <div class="text">Pemasukan</div>
                    </div>
                </div>
                <div class="budgetting">
                    <div class="amount" id="pengeluaran">Rp <?php echo number_format($totalExpenses, 2); ?></div>
                    <div class="details">
                        <div class="edit">Edit</div>
                        <div class="text">Pengeluaran</div>
                    </div>
                </div>
                <div class="budgetting">
                    <div class="amount" id="saldo-akhir">Rp <?php echo number_format($saldoAkhir, 2); ?></div>
                    <div class="details">
                        <div class="edit">Edit</div>
                        <div class="text">Saldo Akhir</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
            const now = new Date();
            const currentMonth = monthNames[now.getMonth()];
            const currentYear = now.getFullYear();
            $('#current-month-year').text(`${currentMonth} ${currentYear}`);
        });
    </script>
</body>
</html>
