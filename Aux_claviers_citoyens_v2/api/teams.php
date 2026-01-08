<?php
require_once __DIR__.'/config.php';
require_once __DIR__.'/http.php';

$token = bearer_token();

$tournamentId = isset($_GET['tournamentId']) ? intval($_GET['tournamentId']) : 0;
$teamId = isset($_GET['teamId']) ? intval($_GET['teamId']) : 0;

if ($tournamentId <= 0) json_out(400, ['message' => 'tournamentId manquant']);

$method = $_SERVER['REQUEST_METHOD'];
$input = in_array($method, ['POST','PUT','PATCH'], true) ? read_json_body() : [];

$base = "tournaments/$tournamentId/teams";

if ($method === 'GET') {
  $path = $teamId > 0 ? "$base/$teamId" : $base;
  $r = api_request('GET', $path, $token);
  json_out($r['status'] ?: 500, $r['data'] ?? ['message' => $r['error']]);
}

if ($method === 'POST') {
  $name = trim((string)($input['name'] ?? ''));
  if ($name === '' || strlen($name) < 2) json_out(400, ['message' => 'Nom d\'équipe invalide']);
  $r = api_request('POST', $base, $token, ['name' => $name]);
  json_out($r['status'] ?: 500, $r['data'] ?? ['message' => $r['error']]);
}

if ($method === 'PATCH' || $method === 'PUT') {
  if ($teamId <= 0) json_out(400, ['message' => 'teamId manquant']);
  $payload = [];
  if (array_key_exists('name', $input)) {
    $name = trim((string)$input['name']);
    if ($name === '' || strlen($name) < 2) json_out(400, ['message' => 'Nom d\'équipe invalide']);
    $payload['name'] = $name;
  }
  $r = api_request('PATCH', "$base/$teamId", $token, $payload);
  json_out($r['status'] ?: 500, $r['data'] ?? ['message' => $r['error']]);
}

if ($method === 'DELETE') {
  if ($teamId <= 0) json_out(400, ['message' => 'teamId manquant']);
  $r = api_request('DELETE', "$base/$teamId", $token);
  json_out($r['status'] ?: 500, $r['data'] ?? ['message' => $r['error']]);
}

json_out(405, ['message' => 'Méthode non supportée']);
