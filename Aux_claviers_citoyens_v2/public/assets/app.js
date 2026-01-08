function out(x) {
  document.getElementById("out").textContent =
    typeof x === "string" ? x : JSON.stringify(x, null, 2);
}
function token() {
  return document.getElementById("token").value.trim();
}
function tid() {
  return Number(document.getElementById("tid").value);
}

async function loadTeams() {
  const r = await fetch(`../api/teams.php?tournamentId=${tid()}`, {
    headers: token() ? { Authorization: `Bearer ${token()}` } : {},
  });
  out(await r.json());
}

async function createTeam() {
  const name = document.getElementById("newName").value.trim();
  const r = await fetch(`../api/teams.php?tournamentId=${tid()}`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      ...(token() ? { Authorization: `Bearer ${token()}` } : {}),
    },
    body: JSON.stringify({ name }),
  });
  out(await r.json());
}
