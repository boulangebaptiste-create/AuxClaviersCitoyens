<?php

require __DIR__ . '/config.php';
require __DIR__ . '/http.php';

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// --------------------------------------
// 🔓 Route publique éventuelle (ex: token)
// --------------------------------------
if ($path === '/token') {
    require __DIR__ . '/token.php'; // si vous en ajoutez un plus tard
    exit;
}

// --------------------------------------
// 🔐 Sécurité : Bearer obligatoire
// --------------------------------------
$auth = $_SERVER['HTTP_AUTHORIZATION']
    ?? $_SERVER['REDIRECT_HTTP_AUTHORIZATION']
    ?? null;

if (!$auth || !preg_match('/^Bearer\s+(.*)$/i', $auth, $m)) {
    header('Content-Type: application/json');
    http_response_code(401);
    echo json_encode([
        'error' => 'invalid_request',
        'error_description' => 'Bearer token required'
    ]);
    exit;
}

$token = $m[1];


define('API_TOKEN', $token);

// Dispatch des routes

/**
 * TOURNAMENTS
 * /tournaments
 * /tournaments/{id}
 */
if (preg_match('#^/tournaments(?:/([0-9]+))?$#', $path, $m)) {
    $_GET['tournamentId'] = $m[1] ?? null;
    require __DIR__ . '/rest_tournaments.php';
    exit;
}

/**
 * TEAMS
 * /tournaments/{id}/teams
 * /tournaments/{id}/teams/{teamId}
 */
if (preg_match('#^/tournaments/([0-9]+)/teams(?:/([0-9]+))?$#', $path, $m)) {
    $_GET['tournamentId'] = (int)$m[1];
    $_GET['teamId'] = $m[2] ?? null;
    require __DIR__ . '/rest_teams.php';
    exit;
}

/**
 * MATCHES
 * /tournaments/{id}/matches
 * /tournaments/{id}/matches/{matchId}
 */
if (preg_match('#^/tournaments/([0-9]+)/matches(?:/([0-9]+))?$#', $path, $m)) {
    $_GET['tournamentId'] = (int)$m[1];
    $_GET['matchId'] = $m[2] ?? null;
    require __DIR__ . '/rest_matches.php';
    exit;
}

// --------------------------------------
// ❌ 404
// --------------------------------------
header('Content-Type: application/json');
http_response_code(404);
echo json_encode(['error' => 'not_found']);
