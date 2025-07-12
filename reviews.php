<?php
$filename = 'reviews.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!isset($input['name']) || !isset($input['text'])) {
        echo json_encode(['success' => false]);
        exit;
    }

    $newReview = [
        'name' => htmlspecialchars($input['name']),
        'text' => htmlspecialchars($input['text']),
        'time' => time()
    ];

    $existing = file_exists($filename) ? json_decode(file_get_contents($filename), true) : [];
    $existing[] = $newReview;
    file_put_contents($filename, json_encode($existing, JSON_PRETTY_PRINT));
    echo json_encode(['success' => true]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (file_exists($filename)) {
        echo file_get_contents($filename);
    } else {
        echo json_encode([]);
    }
    exit;
}
?>
