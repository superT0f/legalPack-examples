/**
 * MonKitLégal API v1 — exemple JavaScript (fetch, navigateur ou Node 18+).
 *
 * Liste les documents du kit, puis injecte le HTML des mentions légales
 * dans <div id="mentions-legales"></div>.
 *
 * ⚠️ En navigateur, une vraie clé client ne doit JAMAIS être embarquée dans
 * le code public : passez par votre backend. La clé ci-dessous est la clé
 * de démonstration publique (données fictives), sans risque.
 */

const API = 'https://conformite.prigent.tech/api/v1';
const KEY = 'deadbeefdeadbeefdeadbeefdeadbeef'; // clé de démo

async function apiGet(path) {
  const res = await fetch(`${API}${path}`, {
    headers: { Authorization: `Bearer ${KEY}` },
  });
  const body = await res.json();
  if (!body.success) {
    throw new Error(`${res.status} ${body.error}: ${body.message}`);
  }
  return body.data;
}

// 1. Lister les documents disponibles
const { documents } = await apiGet('/documents');
for (const doc of documents) {
  console.log(`${doc.ready ? '✅' : '⏳'} ${doc.title} → ${doc.html_url}`);
}

// 2. Récupérer les mentions légales et les afficher
const mentions = await apiGet('/documents/mentions-legales');
const slot = document.getElementById('mentions-legales');
if (slot) slot.innerHTML = mentions.html; // HTML généré côté serveur, sans script

// Variante Markdown (CGU) :
// const cguMd = await (await fetch(`${API}/documents/cgu.md`, {
//   headers: { 'X-API-Key': KEY },
// })).text();
