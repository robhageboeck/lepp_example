<?php
header('Content-Type: application/json');

$input = file_get_contents('php://input');
$data = json_decode($input, true);
$action = $data['action'];

$dsn = "pgsql:host=postgres;port=5432;dbname=leppdb";
$pdo = new PDO($dsn, 'postgres', 'password');

if ($action == 'insert') {
    $number = $data['number'];
    $stmt = $pdo->prepare("INSERT INTO random_numbers (number) VALUES (:number) RETURNING id, number, created_at");
    $stmt->bindParam(':number', $number);
    $stmt->execute();
    $result = $stmt->fetch();
    echo json_encode($result);
}

if ($action == 'stats') {
    $stmt = $pdo->query("
        SELECT
            COUNT(*) as total,
            MIN(number) as min,
            MAX(number) as max,
            AVG(number)::numeric(10,2) as avg
        FROM random_numbers
    ");
    $stats = $stmt->fetch();

    $recent = $pdo->query("SELECT * FROM random_numbers ORDER BY created_at DESC LIMIT 10")->fetchAll();

    echo json_encode([
        'stats' => $stats,
        'recent' => $recent
    ]);
}
?>
