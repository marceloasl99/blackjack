<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

$raw = file_get_contents('php://input');
$input = json_decode($raw ?: '', true);

if (!is_array($input)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid JSON body']);
    exit;
}

$sessionId = trim((string)($input['session_id'] ?? ''));
$name = trim(preg_replace('/\s+/', ' ', (string)($input['name'] ?? '')));
$balance = filter_var($input['balance'] ?? null, FILTER_VALIDATE_INT);
$wins = filter_var($input['wins'] ?? null, FILTER_VALIDATE_INT);
$losses = filter_var($input['losses'] ?? null, FILTER_VALIDATE_INT);
$draws = filter_var($input['draws'] ?? null, FILTER_VALIDATE_INT);

if (
    $sessionId === '' || strlen($sessionId) > 100 ||
    $name === '' || mb_strlen($name) > 30 ||
    $balance === false || $balance < 0 || $balance > 100000000 ||
    $wins === false || $wins < 0 || $wins > 100000 ||
    $losses === false || $losses < 0 || $losses > 100000 ||
    $draws === false || $draws < 0 || $draws > 100000
) {
    http_response_code(422);
    echo json_encode(['success' => false, 'error' => 'Invalid score data']);
    exit;
}

$file = __DIR__ . DIRECTORY_SEPARATOR . 'data.txt';
$handle = fopen($file, 'c+');

if ($handle === false) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Unable to open data.txt']);
    exit;
}

if (!flock($handle, LOCK_EX)) {
    fclose($handle);
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Unable to lock data.txt']);
    exit;
}

rewind($handle);
$alreadyExists = false;
while (($line = fgets($handle)) !== false) {
    $existing = json_decode(trim($line), true);
    if (is_array($existing) && ($existing['session_id'] ?? '') === $sessionId) {
        $alreadyExists = true;
        break;
    }
}

if (!$alreadyExists) {
    $record = [
        'session_id' => $sessionId,
        'name' => $name,
        'balance' => $balance,
        'wins' => $wins,
        'losses' => $losses,
        'draws' => $draws,
        'created_at' => gmdate('c')
    ];

    fseek($handle, 0, SEEK_END);
    $line = json_encode($record, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . PHP_EOL;
    if (fwrite($handle, $line) === false) {
        flock($handle, LOCK_UN);
        fclose($handle);
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Unable to write data.txt']);
        exit;
    }
    fflush($handle);
}

flock($handle, LOCK_UN);
fclose($handle);

echo json_encode([
    'success' => true,
    'created' => !$alreadyExists,
    'message' => $alreadyExists ? 'Score already saved' : 'Score saved'
]);
