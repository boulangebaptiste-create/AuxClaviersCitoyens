<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>ACC - Proxy API (Teams)</title>
</head>
<body>
  <h1>ACC - Gestion des équipes (test)</h1>

  <p>Base site : <code>http://localhost/baptiste/Aux%20claviers%20citoyens/</code></p>

  <label>Token (Bearer): <input id="token" style="width:420px" /></label><br><br>

  <label>Tournament ID: <input id="tid" type="number" value="1" /></label>
  <button onclick="loadTeams()">Lister équipes</button>

  <h2>Créer équipe</h2>
  <input id="newName" placeholder="Nom équipe" />
  <button onclick="createTeam()">Créer</button>

  <h2>Résultat</h2>
  <pre id="out"></pre>

  <script src="assets/app.js"></script>
</body>
</html>
