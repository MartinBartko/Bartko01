<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Uloha 02</title>
</head>
<body>

<?php
require_once "connect.php";

// Function to print results in a table
function print_results_table($result) {
    if ($result->num_rows > 0) {
        echo "<table border='1'><tr>";
        // Print table headers
        $field_info = $result->fetch_fields();
        foreach ($field_info as $field) {
            echo "<th>{$field->name}</th>";
        }
        echo "</tr>";
        // Print table rows
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $cell) {
                echo "<td>{$cell}</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No data found</p>";
    }
}

// požiadavka 01
echo "<h1>požiadavka 01</h1>";
$sql = "SELECT orders.*, customers.CompanyName 
        FROM orders 
        JOIN customers ON orders.CustomerID = customers.CustomerID 
        WHERE YEAR(OrderDate) = 1996";
$result = $conn->query($sql);
print_results_table($result);

// požiadavka 02
echo "<h1>požiadavka 02</h1>";
$sql = "SELECT e.City, 
               COUNT(DISTINCT e.EmployeeID) AS EmployeeCount, 
               COUNT(DISTINCT c.CustomerID) AS CustomerCount 
        FROM employees e 
        JOIN customers c ON e.City = c.City 
        GROUP BY e.City";
$result = $conn->query($sql);
print_results_table($result);

// požiadavka 03
echo "<h1>požiadavka 03</h1>";
$sql = "SELECT c.City, 
               COUNT(DISTINCT e.EmployeeID) AS EmployeeCount, 
               COUNT(DISTINCT c.CustomerID) AS CustomerCount 
        FROM customers c 
        LEFT JOIN employees e ON c.City = e.City 
        GROUP BY c.City";
$result = $conn->query($sql);
print_results_table($result);

// požiadavka 04
echo "<h1>požiadavka 04</h1>";
$sql = "SELECT City, 
               COUNT(DISTINCT EmployeeID) AS EmployeeCount, 
               COUNT(DISTINCT CustomerID) AS CustomerCount 
        FROM (
            SELECT City, EmployeeID, NULL AS CustomerID FROM employees
            UNION ALL
            SELECT City, NULL AS EmployeeID, CustomerID FROM customers
        ) AS combined 
        GROUP BY City";
$result = $conn->query($sql);
print_results_table($result);

?>

<h1>požiadavka 05</h1>
<form method="POST">
    <label for="date">Zadajte dátum (YYYY-MM-DD):</label>
    <input type="date" id="date" name="date">
    <input type="submit" value="Odoslať">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["date"])) {
    $date = $_POST["date"];
    $sql = "SELECT orders.OrderID, employees.FirstName, employees.LastName 
            FROM orders 
            JOIN employees ON orders.EmployeeID = employees.EmployeeID 
            WHERE ShippedDate > '$date'";
    $result = $conn->query($sql);
    print_results_table($result);
}

echo "<h1>požiadavka 06</h1>";
$sql = "SELECT ProductID, SUM(Quantity) AS TotalQuantity 
        FROM `order details` 
        GROUP BY ProductID 
        HAVING SUM(Quantity) < 200";
$result = $conn->query($sql);
print_results_table($result);

echo "<h1>požiadavka 07</h1>";
$sql = "SELECT CustomerID, COUNT(OrderID) AS OrderCount 
        FROM orders 
        WHERE OrderDate > '1994-12-31' 
        GROUP BY CustomerID 
        HAVING COUNT(OrderID) > 15";
$result = $conn->query($sql);
print_results_table($result);

$conn->close();
?>

</body>
</html>
