<?php  
require_once __DIR__.'/config.php';
require_once __DIR__.'/http.php';

$token = bearer_token();
$method = $_SERVER['REQUEST_METHOD'];
$input = in_array($method, ['POST','PUT','PATCH'], true) ? read_json_body() : [];

$tournamentId = isset($_GET['tournamentId']) ? intval($_GET['tournamentId']) : 0;
$base = "tournaments";

if ($method === 'GET') {
  $path = $tournamentId > 0 ? "$base/$tournamentId" : $base;
  $r = api_request('GET', $path, $token);
  json_out($r['status'] ?: 500, $r['data'] ?? ['message' => $r['error']]);
}

if ($method === 'POST') {
  $r = api_request('POST', $base, $token, $input);
  json_out($r['status'] ?: 500, $r['data'] ?? ['message' => $r['error']]);
}

if ($method === 'PATCH' || $method === 'PUT') {
  if ($tournamentId <= 0) json_out(400, ['message' => 'tournamentId manquant']);
  $r = api_request('PATCH', "$base/$tournamentId", $token, $input);
  json_out($r['status'] ?: 500, $r['data'] ?? ['message' => $r['error']]);
}

if ($method === 'DELETE') {
  if ($tournamentId <= 0) json_out(400, ['message' => 'tournamentId manquant']);
  $r = api_request('DELETE', "$base/$tournamentId", $token);
  json_out($r['status'] ?: 500, $r['data'] ?? ['message' => $r['error']]);
}

json_out(405, ['message' => 'Méthode non supportée']);