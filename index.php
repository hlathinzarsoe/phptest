<?php
// MySQL connection config
$host = "localhost";
$db = "payment";
$user = "root";
$pass = "";

// Connect using MySQLi
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from database
$sql = "SELECT category, sum_assured, premium FROM insurancepolicy";
$result = $conn->query($sql);

$insuranceData = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $insuranceData[$row['category']] = [
            'sum_assured' => $row['sum_assured'],
            'premium' => $row['premium']
        ];
    }
} else {
    echo "No insurance records found.";
}

$conn->close();
?>


<form>
    <label>Insurance Category:</label>
    <select id="category" onchange="updateValues()">
        <option value="">Select Category</option>
        <?php foreach ($insuranceData as $category => $values): ?>
            <option value="<?= htmlspecialchars($category) ?>"><?= htmlspecialchars($category) ?></option>
        <?php endforeach; ?>
    </select>

    <br><br>

    <label>Sum Assured:</label>
    <input type="text" id="sum_assured" readonly>

    <br><br>

    <label>Premium:</label>
    <input type="text" id="premium" readonly>

    <button type="submit">Submit</button>
</form>

<script>
    // Convert PHP associative array to JS object
    const insuranceData = <?= json_encode($insuranceData) ?>;

    function updateValues() {
        const selectedCategory = document.getElementById("category").value;

        if (selectedCategory && insuranceData[selectedCategory]) {
            document.getElementById("sum_assured").value = insuranceData[selectedCategory].sum_assured;
            document.getElementById("premium").value = insuranceData[selectedCategory].premium;
        } else {
            document.getElementById("sum_assured").value = '';
            document.getElementById("premium").value = '';
        }
    }
</script>