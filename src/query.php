<?php
header('Content-Type: application/json');

$input = file_get_contents('php://input');
$data = json_decode($input, true);
$action = $data['action'];

$dsn = "pgsql:host=postgres;port=5432;dbname=leppdb";
$pdo = new PDO($dsn, 'postgres', 'password');

if ($action == 'insert') {
    $number = $data['number'];
    $stmt = $pdo->prepare("INSERT INTO random_numbers (number) VALUES (:number) RETURNING id, number");
    $stmt->bindParam(':number', $number);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($result);
}
