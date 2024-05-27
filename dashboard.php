<?php
session_start();

// Ambil nama pengguna dari sesi
$username = $_SESSION['username'];
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
            margin-right: 20px; /* Atur jarak kanan antara setiap kotak */
            margin-left: 20px; /* Atur jarak kiri antara setiap kotak */
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
                <a href="halaman_tambah.php">
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
        <div class="hero">
            <div class="hello" id="hello">Hello, <?php echo $username; ?></div>
            <div class="budget-info">Budget bulanan anda tersisa:</div>
            <div class="budget-amount" id="budget-amount">Rp 0.00</div>
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
                <div class="lihat-detail">Lihat Detail</div>
            </div>
            <div class="frame-6">
                <div class="budgetting">
                    <div class="amount" id="saldo-awal">Rp 0.00</div>
                    <div class="details">
                        <div class="edit">Edit</div>
                        <div class="text">Saldo Awal</div>
                    </div>
                </div>
                <div class="budgetting">
                    <div class="amount" id="pemasukan">Rp 0.00</div>
                    <div class="details">
                        <div class="edit">Edit</div>
                        <div class="text">Pemasukan</div>
                    </div>
                </div>
                <div class="budgetting">
                    <div class="amount" id="pengeluaran">Rp 0.00</div>
                    <div class="details">
                        <div class="edit">Edit</div>
                        <div class="text">Pengeluaran</div>
                    </div>
                </div>
                <div class="budgetting">
                    <div class="amount" id="saldo-akhir">Rp 0.00</div>
                    <div class="details">
                        <div class="edit">Edit</div>
                        <div class="text">Saldo Akhir</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('ambil_data_user.php')
            .then(response => response.json())
            .then(data => {
                document.getElementById('hello').textContent = `Hello, ${data.username}`;
                document.getElementById('budget-amount').textContent = `Rp ${data.monthly_budget || '0.00'}`;
                document.getElementById('saldo-awal').textContent = `Rp ${data.income || '0.00'}`;
                document.getElementById('pemasukan').textContent = `Rp ${data.income || '0.00'}`;
                document.getElementById('pengeluaran').textContent = `Rp ${data.expenses || '0.00'}`;
                document.getElementById('saldo-akhir').textContent = `Rp ${(data.income - data.expenses) || '0.00'}`;
            })
            .catch(error => console.error('Error fetching user data:', error));

            const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
            const now = new Date();
            const currentMonth = monthNames[now.getMonth()];
            const currentYear = now.getFullYear();
            document.getElementById('current-month-year').textContent = `${currentMonth} ${currentYear}`;
        });
    </script>
</body>
</html>