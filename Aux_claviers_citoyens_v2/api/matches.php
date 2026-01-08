<?php
/**
 * PLACEHOLDER - Gestion des matchs & scores (à compléter par tes collaborateurs)
 *
 * Routes locales stables :
 *   GET   /api/matches.php?tournamentId=1                 -> liste des matchs du tournoi
 *   GET   /api/matches.php?tournamentId=1&matchId=10      -> détail match
 *   PATCH /api/matches.php?tournamentId=1&matchId=10      -> update score / infos
 *
 * Convention de proxy (à conserver) :
 *   API distante supposée :
 *     /tournaments/{id}/matches
 *     /tournaments/{id}/matches/{matchId}
 *     (ou endpoint "update match points" spécifique)
 */
require_once __DIR__.'/config.php';
require_once __DIR__.'/http.php';

$token = bearer_token();
$method = $_SERVER['REQUEST_METHOD'];
$input = in_array($method, ['POST','PUT','PATCH'], true) ? read_json_body() : [];

$tournamentId = isset($_GET['tournamentId']) ? intval($_GET['tournamentId']) : 0;
$matchId = isset($_GET['matchId']) ? intval($_GET['matchId']) : 0;

if ($tournamentId <= 0) json_out(400, ['message' => 'tournamentId manquant']);

$base = "tournaments/$tournamentId/matches";

if ($method === 'GET') {
  $path = $matchId > 0 ? "$base/$matchId" : $base;
  $r = api_request('GET', $path, $token);
  json_out($r['status'] ?: 500, $r['data'] ?? ['message' => $r['error']]);
}

if ($method === 'PATCH' || $method === 'PUT') {
  if ($matchId <= 0) json_out(400, ['message' => 'matchId manquant']);
  // Exemple: { teamId, points } ou { team1Point, team2Point } selon l'API
  $r = api_request('PATCH', "$base/$matchId", $token, $input);
  json_out($r['status'] ?: 500, $r['data'] ?? ['message' => $r['error']]);
}

json_out(405, ['message' => 'Méthode non supportée']);
