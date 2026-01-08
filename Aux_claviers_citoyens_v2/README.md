# Aux Claviers Citoyens — Proxy PHP (Wamp)

Dézippe dans :
`C:\wamp64\www\baptiste\Aux claviers citoyens\`

Ouvre ensuite :
`http://localhost/baptiste/Aux%20claviers%20citoyens/public/`

## À faire avant tout
- Modifie `api/config.php` et renseigne `API_BASE_URL` avec l'URL réelle de l'API fournie.

## Routes locales (stables) — à conserver pour que les merges Github se passent bien

### Teams
- `GET    /api/teams.php?tournamentId=1`
- `POST   /api/teams.php?tournamentId=1` body: `{ "name": "..." }`
- `GET    /api/teams.php?tournamentId=1&teamId=2`
- `PATCH  /api/teams.php?tournamentId=1&teamId=2` body: `{ "name": "..." }`
- `DELETE /api/teams.php?tournamentId=1&teamId=2`

### Tournaments (placeholder)
- `GET    /api/tournaments.php`
- `POST   /api/tournaments.php`
- `GET    /api/tournaments.php?tournamentId=1`
- `PATCH  /api/tournaments.php?tournamentId=1`
- `DELETE /api/tournaments.php?tournamentId=1`

### Matches (placeholder)
- `GET    /api/matches.php?tournamentId=1`
- `GET    /api/matches.php?tournamentId=1&matchId=10`
- `PATCH  /api/matches.php?tournamentId=1&matchId=10`

## Auth
Le front de test envoie le token en `Authorization: Bearer <token>`.
Les endpoints PHP récupèrent ce header et le repassent à l'API distante.
