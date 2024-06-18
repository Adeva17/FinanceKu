<?php
session_start();
include('dbconn.php');

$nickname = $_SESSION['nickname'];
$userId = $_SESSION['userId'];

$selectedYear = isset($_GET['year']) ? $_GET['year'] : date ("Y");
$selectedMonth = isset($_GET["month"]) ? $_GET['month'] : date ('m');
$selectedType = isset($_GET['type']) ? $_GET['type'] : 'semua';

// Create a connection
$conn = getConnection();

// Fetch income data
$incomeQuery = "SELECT id, date, incomeSource, amount FROM income WHERE userId = ? AND YEAR(date) = ? AND MONTH(date) = ?";
$stmtIncome = mysqli_prepare($conn, $incomeQuery);
mysqli_stmt_bind_param($stmtIncome, "iii", $userId, $selectedYear, $selectedMonth);
mysqli_stmt_execute($stmtIncome);
$resultIncome = mysqli_stmt_get_result($stmtIncome);
$incomes = mysqli_fetch_all($resultIncome, MYSQLI_ASSOC);
mysqli_stmt_close($stmtIncome);

// Fetch expense data   
$expenseQuery = "SELECT id, date, expenseCategory, description, amount FROM expense WHERE userId = ? AND YEAR(date) = ? AND MONTH(date) = ?";
$stmtExpense = mysqli_prepare($conn, $expenseQuery);
mysqli_stmt_bind_param($stmtExpense, "iii", $userId, $selectedYear, $selectedMonth);
mysqli_stmt_execute($stmtExpense);
$resultExpense = mysqli_stmt_get_result($stmtExpense);
$expenses = mysqli_fetch_all($resultExpense, MYSQLI_ASSOC);
mysqli_stmt_close($stmtExpense);

// Close the connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
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
            padding: 0 20px;
            margin-bottom: 20px;
            margin-top: 15px;
        }

        .title {
            font-size: 35px;
            font-weight: 700;
            text-decoration: none;
        }

        .title a {
            text-decoration: none;
            color: #000000;
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

        .summary {
            display: flex;
            justify-content: space-around;
            margin: 20px 0;
            font-family: 'Inter', sans-serif;
            font-size: 24px;
            font-weight: 600;
            margin-top: 65px;
            color: black;
        }

        .summary div {
            padding: 10px 20px;
            border-radius: 10px;
            text-align: center;
        }

        .summary .income-label {
            font-size: 25px;
            font-weight: 600;
        }

        .summary .income-amount {
            font-size: 33px;
            font-weight: 700;
        }

        .summary .expense-label {
            font-size: 25px;
            font-weight: 600;
        }

        .summary .expense-amount {
            font-size: 33px;
            font-weight: 700;
        }

        .filter-bar {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin: 20px auto;
            margin-top: 50px;
            padding: 15px;
            background-color: #f4f4f4;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: fit-content;
        }

        .filter-bar select {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        .tab-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 100%;
            margin: 20px auto;
            width: 1200px;
        }

        .tab {
            display: flex;
            gap: 5px;
        }

        .tab button {
            background-color: #f1f1f1;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 20px;
            transition: background-color 0.3s;
            border-radius: 5px;
            font-size: 17px;
        }

        .tab button:hover {
            background-color: #ddd;
        }

        .tab button.active {
            background-color: #ccc;
        }

        .tabcontent {
            display: block;
            padding: 0 20px;
            margin-top: -1px;
            width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px auto;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        table th {
            padding: 10px 15px;
            border-bottom: 1px solid #ddd;
            border-right: 1px solid #ddd;
            text-align: center;
            background: #f4f4f4;
            font-weight: 700;
        }

        table td {
            padding: 10px 15px;
            border-bottom: 1px solid #ddd;
            border-right: 1px solid #ddd;
            text-align: left;
        }

        table tr:last-child td {
            border-bottom: none;
        }

        table tr td:last-child, table tr th:last-child {
            border-right: none;
        }

        .actions {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .actions img {
            width: 27px;
            height: 27px;
            cursor: pointer;
        }

        .actions-column {
            width: 100px;
            text-align: center;
        }

        .number-column {
            width: 40px;
            text-align: center;
        }

        .date-column {
            width: 150px;
            text-align: center;
        }

        .search-bar {
            text-align: right;
            flex-grow: 1;
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .search-bar input {
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 200px;
        }
        .message {
            color: green;
            font-size: 18px;
            margin-bottom: 15px;
            text-align: center;
        }    </style>
</head>
<body>
    <div class="dashboard">
        <div class="head-bar">
            <div class="title">
                <a href="dashboard.php">Financeku.</a>
            </div>
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
        <?php if (isset($_SESSION['update_message'])): ?>
            <div class="message"><?php echo $_SESSION['update_message']; unset($_SESSION['update_message']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['delete_message'])): ?>
            <div class="message"><?php echo $_SESSION['delete_message']; unset($_SESSION['delete_message']); ?></div>
        <?php endif; ?>
        <div class="summary">
            <div>
                <div class="income-label">Pemasukan</div>
                <div class="income-amount">Rp<?php echo number_format(array_sum(array_column($incomes, 'amount')), 2, ',', '.'); ?></div>
            </div>
            <div>
                <div class="expense-label">Pengeluaran</div>
                <div class="expense-amount">Rp<?php echo number_format(array_sum(array_column($expenses, 'amount')), 2, ',', '.'); ?></div>
            </div>
        </div>
        <div class="filter-bar">
            <form method="GET" action="halaman_laporan.php">
                <select name="year" id="yearSelect">
                    <?php
                    $currentYear = date("Y");
                    for ($year = $currentYear; $year >= 2000; $year--) {
                        echo "<option value=\"$year\">$year</option>";
                    }
                    ?>
                </select>
                <select name="month" id="monthSelect">
                    <option value="01">January</option>
                    <option value="02">February</option>
                    <option value="03">March</option>
                    <option value="04">April</option>
                    <option value="05">Mei</option>
                    <option value="06">June</option>
                    <option value="07">July</option>
                    <option value="08">August</option>
                    <option value="09">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
                <select name="type" id="typeSelect">
                <option value="semua" <?php echo ($selectedType == 'semua') ? 'selected' : ''; ?>>Semua</option>
                </select>
                <button type="submit">Filter</button>
            </form>
        </div>
   
        <div class="tab-container">
            <div class="tab">
                <button class="tablinks" onclick="openTab(event, 'Pemasukan')">Pemasukan</button>
                <button class="tablinks" onclick="openTab(event, 'Pengeluaran')">Pengeluaran</button>
            </div>
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Cari...">
            </div>
        </div>
        <div id="Pemasukan" class="tabcontent">
            <table id="pemasukanTable">
                <thead>
                    <tr>
                        <th class="number-column">No.</th>
                        <th class="date-column">Tanggal</th>
                        <th>Sumber</th>
                        <th>Jumlah</th>
                        <th class="actions-column">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($incomes as $index => $income) : ?>
                    <tr>
                        <td class="number-column"><?php echo $index + 1; ?></td>
                        <td class="date-column"><?php echo $income['date']; ?></td>
                        <td><?php echo $income['incomeSource']; ?></td>
                        <td>Rp<?php echo number_format($income['amount'], 2, ',', '.'); ?></td>
                        <td class="actions-column">
                            <div class="actions">
                                <a href="editincome.php?id=<?php echo $income['id']; ?>"><img src="img/edit.png" alt="Edit Icon"></a>
                                <a href="delete_income.php?id=<?php echo $income['id']; ?>"><img src="img/delete.png" alt="Delete Icon"></a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div id="Pengeluaran" class="tabcontent">
            <table id="pengeluaranTable">
                <thead>
                    <tr>
                        <th class="number-column">No.</th>
                        <th class="date-column">Tanggal</th>
                        <th>Kategori</th>
                        <th>Deskripsi</th>
                        <th>Jumlah</th>
                        <th class="actions-column">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($expenses as $index => $expense) : ?>
                    <tr>
                        <td class="number-column"><?php echo $index + 1; ?></td>
                        <td class="date-column"><?php echo $expense['date']; ?></td>
                        <td><?php echo $expense['expenseCategory']; ?></td>
                        <td><?php echo $expense['description']; ?></td>
                        <td>Rp<?php echo number_format($expense['amount'], 2, ',', '.'); ?></td>
                        <td class="actions-column">
                            <div class="actions">
                                <a href="editexpense.php?id=<?php echo $expense['id']; ?>"><img src="img/edit.png" alt="Edit Icon"></a>
                                <a href="delete_expense.php?id=<?php echo $expense['id']; ?>"><img src="img/delete.png" alt="Delete Icon"></a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            // Mempertahankan opsi yang dipilih setelah filter
            const urlParams = new URLSearchParams(window.location.search);
            const selectedYear = urlParams.get('year');
            const selectedMonth = urlParams.get('month');
            const selectedType = urlParams.get('type');

            if (selectedYear) {
                document.getElementById('yearSelect').value = selectedYear;
            }
            if (selectedMonth) {
                document.getElementById('monthSelect').value = selectedMonth; 
            }
            if (selectedType) {
                document.getElementById('typeSelect').value = selectedType;
            }

            // Tab dan search
            document.querySelector('.tab button:first-child').click();
            document.getElementById('searchInput').addEventListener('keyup', function() {
                var searchValue = this.value.toLowerCase();
                var tables = document.querySelectorAll('.tabcontent table tbody');
                tables.forEach(function(tbody) {
                    var rows = tbody.getElementsByTagName('tr');
                    for (var i = 0; i < rows.length; i++) {
                        var cells = rows[i].getElementsByTagName('td');
                        var found = false;
                        for (var j = 0; j < cells.length; j++) {
                            var cellValue = cells[j].textContent || cells[j].innerText;
                            cellValue = cellValue.toLowerCase();
                            if (cellValue.indexOf(searchValue) > -1) {
                                found = true;
                                break;
                            }
                        }
                        if (found) {
                            rows[i].style.display = '';
                        } else {
                            rows[i].style.display = 'none';
                        }
                    }
                });
            });
        });

        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }
    </script>
</body>
</html>
