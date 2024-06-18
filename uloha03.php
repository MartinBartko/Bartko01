<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Úloha 03</title>
    <link rel="stylesheet" href="uloha01.css">
</head>
<body>

<?php
require_once "connect.php";
?>

<h1>požiadavka 01</h1>
<?php
$sql = "
    SELECT SUM(od.UnitPrice * od.Quantity) as TotalRevenue
    FROM `order details` od
    JOIN orders o ON od.OrderID = o.OrderID
    WHERE YEAR(o.OrderDate) = 1994
";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
echo "Celkové príjmy v roku 1994: " . $row['TotalRevenue'] . " USD";
?>

<h1>požiadavka 02</h1>
<?php
$sql = "
    SELECT c.CustomerID, c.CompanyName, SUM(od.UnitPrice * od.Quantity) as TotalPaid
    FROM customers c
    JOIN orders o ON c.CustomerID = o.CustomerID
    JOIN `order details` od ON o.OrderID = od.OrderID
    GROUP BY c.CustomerID, c.CompanyName
";
$result = $conn->query($sql);
echo "<table style='border-collapse: collapse; width: 100%;'>";
echo "<tr><th style='border: 1px solid black; padding: 8px;'>Customer ID</th><th style='border: 1px solid black; padding: 8px;'>Company Name</th><th style='border: 1px solid black; padding: 8px;'>Total Paid</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr><td style='border: 1px solid black; padding: 8px;'>{$row['CustomerID']}</td><td style='border: 1px solid black; padding: 8px;'>{$row['CompanyName']}</td><td style='border: 1px solid black; padding: 8px;'>{$row['TotalPaid']}</td></tr>";
}
echo "</table>";
?>

<h1>požiadavka 03</h1>
<?php
$sql = "
    SELECT p.ProductID, p.ProductName, SUM(od.Quantity) as TotalSold
    FROM products p
    JOIN `order details` od ON p.ProductID = od.ProductID
    GROUP BY p.ProductID, p.ProductName
    ORDER BY TotalSold DESC
    LIMIT 10
";
$result = $conn->query($sql);
echo "<table style='border-collapse: collapse; width: 100%;'>";
echo "<tr><th style='border: 1px solid black; padding: 8px;'>Product ID</th><th style='border: 1px solid black; padding: 8px;'>Product Name</th><th style='border: 1px solid black; padding: 8px;'>Total Sold</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr><td style='border: 1px solid black; padding: 8px;'>{$row['ProductID']}</td><td style='border: 1px solid black; padding: 8px;'>{$row['ProductName']}</td><td style='border: 1px solid black; padding: 8px;'>{$row['TotalSold']}</td></tr>";
}
echo "</table>";
?>

<h1>požiadavka 04</h1>
<?php
$sql = "
    SELECT c.CustomerID, c.CompanyName, SUM(od.UnitPrice * od.Quantity) as TotalRevenue
    FROM customers c
    JOIN orders o ON c.CustomerID = o.CustomerID
    JOIN `order details` od ON o.OrderID = od.OrderID
    GROUP BY c.CustomerID, c.CompanyName
";
$result = $conn->query($sql);
echo "<table style='border-collapse: collapse; width: 100%;'>";
echo "<tr><th style='border: 1px solid black; padding: 8px;'>Customer ID</th><th style='border: 1px solid black; padding: 8px;'>Company Name</th><th style='border: 1px solid black; padding: 8px;'>Total Revenue</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr><td style='border: 1px solid black; padding: 8px;'>{$row['CustomerID']}</td><td style='border: 1px solid black; padding: 8px;'>{$row['CompanyName']}</td><td style='border: 1px solid black; padding: 8px;'>{$row['TotalRevenue']}</td></tr>";
}
echo "</table>";
?>

<h1>požiadavka 05</h1>
<?php
$sql = "
    SELECT c.CustomerID, c.CompanyName, SUM(od.UnitPrice * od.Quantity) as TotalPaid
    FROM customers c
    JOIN orders o ON c.CustomerID = o.CustomerID
    JOIN `order details` od ON o.OrderID = od.OrderID
    WHERE c.Country = 'UK'
    GROUP BY c.CustomerID, c.CompanyName
    HAVING TotalPaid > 1000
";
$result = $conn->query($sql);
echo "<table style='border-collapse: collapse; width: 100%;'>";
echo "<tr><th style='border: 1px solid black; padding: 8px;'>Customer ID</th><th style='border: 1px solid black; padding: 8px;'>Company Name</th><th style='border: 1px solid black; padding: 8px;'>Total Paid</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr><td style='border: 1px solid black; padding: 8px;'>{$row['CustomerID']}</td><td style='border: 1px solid black; padding: 8px;'>{$row['CompanyName']}</td><td style='border: 1px solid black; padding: 8px;'>{$row['TotalPaid']}</td></tr>";
}
echo "</table>";
?>

<h1>požiadavka 06</h1>
<?php
$sql = "
    SELECT c.CustomerID, c.CompanyName, c.Country,
           SUM(od.UnitPrice * od.Quantity) as TotalPaid,
           SUM(CASE WHEN YEAR(o.OrderDate) = 1995 THEN od.UnitPrice * od.Quantity ELSE 0 END) as TotalPaid1995
    FROM customers c
    JOIN orders o ON c.CustomerID = o.CustomerID
    JOIN `order details` od ON o.OrderID = od.OrderID
    GROUP BY c.CustomerID, c.CompanyName, c.Country
";
$result = $conn->query($sql);
echo "<table style='border-collapse: collapse; width: 100%;'>";
echo "<tr><th style='border: 1px solid black; padding: 8px;'>Customer ID</th><th style='border: 1px solid black; padding: 8px;'>Company Name</th><th style='border: 1px solid black; padding: 8px;'>Country</th><th style='border: 1px solid black; padding: 8px;'>Total Paid</th><th style='border: 1px solid black; padding: 8px;'>Total Paid in 1995</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr><td style='border: 1px solid black; padding: 8px;'>{$row['CustomerID']}</td><td style='border: 1px solid black; padding: 8px;'>{$row['CompanyName']}</td><td style='border: 1px solid black; padding: 8px;'>{$row['Country']}</td><td style='border: 1px solid black; padding: 8px;'>{$row['TotalPaid']}</td><td style='border: 1px solid black; padding: 8px;'>{$row['TotalPaid1995']}</td></tr>";
}
echo "</table>";
?>

<h1>požiadavka 07</h1>
<?php
$sql = "
    SELECT COUNT(DISTINCT CustomerID) as TotalCustomers
    FROM orders
";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
echo "Celkový počet zákazníkov: " . $row['TotalCustomers'];
?>

<h1>požiadavka 08</h1>
<?php
$sql = "
    SELECT COUNT(DISTINCT o.CustomerID) as TotalCustomers1997
    FROM orders o
    WHERE YEAR(o.OrderDate) = 1997
";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
echo "Celkový počet zákazníkov v roku 1997: " . $row['TotalCustomers1997'];
?>

<?php $conn->close(); ?>

</body>
</html>
