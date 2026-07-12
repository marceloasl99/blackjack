<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    header('Allow: GET');
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

if (isset($_GET['ping'])) {
    echo json_encode(['success' => true, 'storage' => 'data.txt']);
    exit;
}

$file = __DIR__ . DIRECTORY_SEPARATOR . 'data.txt';
if (!is_file($file)) {
    echo json_encode([]);
    exit;
}

$handle = fopen($file, 'r');
if ($handle === false) {
    http_response_code(500);
    echo json_encode(['error' => 'Unable to read data.txt']);
    exit;
}

flock($handle, LOCK_SH);
$scores = [];
while (($line = fgets($handle)) !== false) {
    $row = json_decode(trim($line), true);
    if (!is_array($row)) {
        continue;
    }
    $scores[] = [
        'name' => (string)($row['name'] ?? 'Unknown'),
        'balance' => (int)($row['balance'] ?? 0),
        'wins' => (int)($row['wins'] ?? 0),
        'losses' => (int)($row['losses'] ?? 0),
        'draws' => (int)($row['draws'] ?? 0),
        'created_at' => (string)($row['created_at'] ?? '')
    ];
}
flock($handle, LOCK_UN);
fclose($handle);

usort($scores, static function (array $a, array $b): int {
    return ($b['balance'] <=> $a['balance'])
        ?: ($b['wins'] <=> $a['wins'])
        ?: strcmp($a['created_at'], $b['created_at']);
});

echo json_encode(array_slice($scores, 0, 100), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
