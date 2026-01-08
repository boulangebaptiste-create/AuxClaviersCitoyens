<?php
function api_request(string $method, string $path, ?string $token = null, $body = null): array {
  $url = rtrim(API_BASE_URL, '/') . '/' . ltrim($path, '/');

  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));

  $headers = [];
  if ($token) $headers[] = "Authorization: Bearer $token";

  if ($body !== null) {
    $headers[] = "Content-Type: application/json; charset=utf-8";
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
  }

  if (!empty($headers)) curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  $resp = curl_exec($ch);
  $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  $err = curl_error($ch);
  curl_close($ch);

  if ($resp === false) {
    return ['status' => 0, 'data' => null, 'error' => $err ?: 'Erreur cURL'];
  }

  $data = null;
  if (strlen($resp) > 0) {
    $decoded = json_decode($resp, true);
    $data = (json_last_error() === JSON_ERROR_NONE) ? $decoded : $resp;
  }

  return ['status' => $status, 'data' => $data, 'error' => null];
}

function json_out(int $status, $payload): void {
  http_response_code($status);
  header("Content-Type: application/json; charset=utf-8");
  echo json_encode($payload);
  exit;
}

function bearer_token(): ?string {
  $auth = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
  if (preg_match('/Bearer\s+(.*)$/i', $auth, $m)) return trim($m[1]);
  return null;
}

function read_json_body(): array {
  $raw = file_get_contents('php://input');
  if (!$raw) return [];
  $decoded = json_decode($raw, true);
  if (json_last_error() !== JSON_ERROR_NONE) json_out(400, ['message' => 'JSON invalide']);
  return $decoded ?? [];
}
