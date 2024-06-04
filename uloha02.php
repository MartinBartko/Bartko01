<?php
require_once "connect.php";

// Function to print results
function print_results($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<pre>" . print_r($row, true) . "</pre>";
        }
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
print_results($result);

// požiadavka 02
echo "<h1>požiadavka 02</h1>";
$sql = "SELECT e.City, 
               COUNT(DISTINCT e.EmployeeID) AS EmployeeCount, 
               COUNT(DISTINCT c.CustomerID) AS CustomerCount 
        FROM employees e 
        JOIN customers c ON e.City = c.City 
        GROUP BY e.City";
$result = $conn->query($sql);
print_results($result);

// požiadavka 03
echo "<h1>požiadavka 03</h1>";
$sql = "SELECT c.City, 
               COUNT(DISTINCT e.EmployeeID) AS EmployeeCount, 
               COUNT(DISTINCT c.CustomerID) AS CustomerCount 
        FROM customers c 
        LEFT JOIN employees e ON c.City = e.City 
        GROUP BY c.City";
$result = $conn->query($sql);
print_results($result);

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
print_results($result);

// požiadavka 05
echo "<h1>požiadavka 05</h1>";
$sql = "SELECT orders.OrderID, employees.FirstName, employees.LastName 
        FROM orders 
        JOIN employees ON orders.EmployeeID = employees.EmployeeID 
        WHERE ShippedDate > '1996-12-31'";
$result = $conn->query($sql);
print_results($result);

// požiadavka 06
echo "<h1>požiadavka 06</h1>";
$sql = "SELECT ProductID, SUM(Quantity) AS TotalQuantity 
        FROM `order details` 
        GROUP BY ProductID 
        HAVING SUM(Quantity) < 200";
$result = $conn->query($sql);
print_results($result);

// požiadavka 07
echo "<h1>požiadavka 07</h1>";
$sql = "SELECT CustomerID, COUNT(OrderID) AS OrderCount 
        FROM orders 
        WHERE OrderDate > '1996-12-31' 
        GROUP BY CustomerID 
        HAVING COUNT(OrderID) > 15";
$result = $conn->query($sql);
print_results($result);

$conn->close();
?>
