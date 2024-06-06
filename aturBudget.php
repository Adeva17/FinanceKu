<?php
session_start();
include('dbconn.php');

$status = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get userId from session
    $userId = $_SESSION['userId'];
    // Get current year and month
    $year = date('Y');
    $month = date('n'); // Numeric representation of a month, without leading zeros
    $amount = $_POST['amount'];

    // Create a connection
    $conn = getConnection();

    // Prepare the SQL statement to avoid SQL injection
    $stmt = $conn->prepare("INSERT INTO budgets (userId, year, month, amount) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiid", $userId, $year, $month, $amount);

    if ($stmt->execute()) {
        $status = 'ok';
    } else {
        $status = 'err';
    }

    $stmt->close();
    $conn->close();

    header('Location: dashboard.php?status=' . $status);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Budget</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(180deg, #FFFFFF 0%, #D0D0D0 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            min-height: 100vh;
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

        .financeku {
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

        .frame-1 {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center; /* Center content vertically */
            gap: 25px;
            max-width: 600px;
            width: 100%;
            text-align: center;
            margin: auto;
            padding: 20px;
            box-sizing: border-box;
            min-height: calc(87vh - 120px); /* sesuaikan tinggi */
        }

        .title {
            font-weight: 700;
            font-size: 45px;
            line-height: 58px;
            letter-spacing: -0.02em;
            color: #000000;
        }

        .subtitle {
            font-weight: 400;
            font-size: 17px;
            line-height: 100%;
            text-align: center;
            color: #828282;
        }

        .field {
            box-sizing: border-box;
            display: flex;
            flex-direction: row;
            align-items: center;
            padding: 16px;
            gap: 10px;
            width: 245px;
            height: 50px;
            background: #FFFFFF;
            border: 1px solid #828282;
            box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
        }

        .input {
            width: 100%;
            border: none;
            outline: none;
            font-size: 16px;
            color: #828282;
        }

        .sign-up-button {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 115px;
            height: 38px;
            background: #000000;
            box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
            cursor: pointer;
        }

        .tambahkan {
            font-weight: 500;
            font-size: 16px;
            line-height: 100%;
            color: #FFFFFF;
        }
        
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            width: 100%;
        }
    </style>
</head>
<body>
<div class="dashboard">
    <div class="head-bar">
        <div class="financeku">Financeku.</div>
        <div class="menu">
            <a href="aturBudget.php">
                <img src="img/plus.png" alt="Add Icon">
            </a>
            <a href="halaman_laporan.php">
                <img src="img/report.png" alt="Report Icon">
            </a>
            <a href="halaman_pengaturan.php">
                <img src="img/config.png" alt="Settings Icon">
            </a>
            <button class="logout">
                <a href="logout.php">Log out</a>
            </button>
        </div>
    </div>
    <div class="frame-1">
        <div class="title">Atur Budget Bulanan</div>
        <div class="subtitle">Berapa budget anda dalam 1 bulan yang ingin anda terapkan?</div>
        <form method="post">
            <div class="field">
                <input type="number" name="amount" class="input" placeholder="Nominal" required>
            </div>
            <button type="submit" class="sign-up-button">
                <div class="tambahkan">Tambahkan</div>
            </button>
        </form>
    </div>
</div>
</body>
</html>
