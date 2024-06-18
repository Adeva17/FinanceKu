<?php
session_start();
include('dbconn.php');

$status = '';
$result = '';
$data = null;

// Check if there is a GET variable
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $idToUpdate = $_GET['id'];
        $conn = getConnection();
        
        if ($conn) {
            $stmt = $conn->prepare("SELECT * FROM income WHERE id = ?");
            $stmt->bind_param("i", $idToUpdate);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $data = $result->fetch_assoc();
            }

            $stmt->close();
            $conn->close();
        }
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['userId'])) {
        // Get userId from session
        $userId = $_SESSION['userId'];
        // Get form data
        $date = $_POST['date'];
        $amount = $_POST['amount'];
        $incomeSource = $_POST['incomeSource'];
        $incomeId = $_POST['incomeId'];

        // Create a connection
        $conn = getConnection();

        if ($conn) {
            // Prepare the SQL statement to avoid SQL injection
            $stmt = $conn->prepare("UPDATE income SET date = ?, amount = ?, incomeSource = ? WHERE id = ? AND userId = ?");
            $stmt->bind_param("sdssi", $date, $amount, $incomeSource, $incomeId, $userId);

            if ($stmt->execute()) {
                $_SESSION['update_message'] = 'Data berhasil diperbarui.';
                header('Location: halaman_laporan.php');
                exit();
            } else {
                $_SESSION['update_message'] = 'Data gagal diperbarui.';
            }

            $stmt->close();
            $conn->close();
        } else {
            echo "Connection error: " . mysqli_connect_error();
        }
    } else {
        echo "User not authenticated.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemasukan</title>
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

        .content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 15px;
            position: fixed; /* Fixed positioning */
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .content .title {
            font-weight: 700;
            font-size: 45px;
            line-height: 58px;
            letter-spacing: -0.02em;
            color: #000000;
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

        .field input {
            width: 100%;
            border: none;
            outline: none;
            font-size: 16px;
            color: #828282;
        }

        .add-button {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 115px;
            height: 38px;
            background: #000000;
            box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
            cursor: pointer;
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

        <div class="content">
            <form action="editincome.php" method="POST">
                <?php if ($data): ?>
                <div class="title">Update Pemasukan</div>
                <input type="hidden" name="incomeId" value="<?php echo $data['id']; ?>">
                <div class="field">
                    <input type="date" name="date" value="<?php echo $data['date']; ?>" placeholder="Tanggal" required>
                </div>
                <div class="field">
                    <input type="text" name="incomeSource"value="<?php echo $data['incomeSource']; ?>" placeholder="Sumber" required>
                </div>
                <div class="field">
                    <input type="text" name="amount" value="<?php echo $data['amount']; ?>" placeholder="Nominal" required>
                </div>
                <button class="add-button" type="submit">Update</button>
                <?php else: ?>
                <div class="title">Pengeluaran tidak ditemukan</div>
                <?php endif; ?>
            </form>
        </div>
    </div>
</body>
</html>

