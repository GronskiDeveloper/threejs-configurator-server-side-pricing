<?php
// Authoritative pricing. This is the only price that should ever reach an order.
// The browser may show a preview for instant feel, but production recomputes here,
// from the server's own rules, and never trusts a number posted by the client.
//
// Swap PHP for any backend. The shape is what matters: validate the inputs,
// compute from server-held rules, return the price the server stands behind.

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // demo convenience; tighten in production

$body = json_decode(file_get_contents('php://input'), true) ?? [];

// 1. Validate. Never price something outside what you can actually make.
$width   = isset($body['width'])   ? (int) $body['width']   : 0;
$shelves = isset($body['shelves']) ? (int) $body['shelves'] : 0;
$finish  = isset($body['finish'])  ? (string) $body['finish'] : '';

$FINISH_MULT = ['oak' => 1.0, 'walnut' => 1.25, 'white' => 1.1]; // server-held rules

if ($width < 60 || $width > 240 || $width % 10 !== 0
    || $shelves < 2 || $shelves > 8
    || !isset($FINISH_MULT[$finish])) {
    http_response_code(422);
    echo json_encode(['error' => 'Invalid configuration']);
    exit;
}

// 2. Compute from server rules only. The client never sends a price, only a config.
$base     = 120;
$perCm    = 1.8 * $width;
$perShelf = 22 * $shelves;
$price    = (int) round(($base + $perCm + $perShelf) * $FINISH_MULT[$finish]);

echo json_encode([
    'price'    => $price,
    'currency' => 'EUR',
    'config'   => ['width' => $width, 'shelves' => $shelves, 'finish' => $finish],
]);
