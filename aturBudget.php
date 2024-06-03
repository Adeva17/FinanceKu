<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemasukan</title>
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

        .pemasukan {
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

        .pemasukan-content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 12px;
            width: 100%;
            margin-bottom: 20px;
            margin-top: 200px;
        }

        .pemasukan-content .atur {
            font-weight: 500;
            font-size: 40px;
            text-align: center;
            color: #000000;  
            font-weight: bold; 
        }

        .pemasukan-content .berapa {
            font-weight: 400;
            font-size: 16px;
            text-align: center;
            color: #828282;
        }

        input[type="nominal"] {
            font-size: 16px;
            padding: 8px;
            border: 1px solid #828282;
            border-radius: 8px;
        }

        .pemasukan-content .tambahkan-button {
            background-color: #000;
            color: #fff;
            border-radius: 15px;
            padding: 8px 16px;
            cursor: pointer;
        }

        .pemasukan-content .tambahkan-button a {
            color: #fff;
            text-decoration: none;
            display: block;
        }

    </style>
</head>
<body>
    <div class="pemasukan">
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
        <div class="pemasukan-content">
            <div class="atur">Atur Budget Bulanan</div>
            <div class="berapa">Berapa budget anda dalam 1 bulan yang ingin anda terapkan?</div>
            <input type="nominal" placeholder="Nominal">
            <div class="tambahkan-button">
                <a href="tambahkan.php">Tambahkan</a>
            </div>
        </div>
    </div>

</body>
</html>
