<?php

declare(strict_types=1);

/**
 * MonKitLégal API v1 — exemple PHP (cURL, aucune dépendance).
 *
 * Récupère les 4 documents du kit et les écrit en fichiers .html
 * à côté du script. La clé ci-dessous est la clé de démonstration
 * publique (données fictives) — remplacez-la par la vôtre.
 */

const API = 'https://conformite.prigent.tech/api/v1';
const KEY = 'deadbeefdeadbeefdeadbeefdeadbeef'; // clé de démo

function apiGet(string $path): array
{
    $ch = curl_init(API . $path);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . KEY],
        CURLOPT_TIMEOUT        => 30,
    ]);
    $body = (string) curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    curl_close($ch);

    $json = json_decode($body, true);
    if (!is_array($json) || !($json['success'] ?? false)) {
        $message = is_array($json) ? ($json['message'] ?? 'erreur inconnue') : $body;
        throw new RuntimeException(sprintf('%d — %s', $code, $message));
    }
    return $json['data'];
}

foreach (['mentions-legales', 'confidentialite', 'cgu', 'cgv'] as $type) {
    try {
        $doc = apiGet('/documents/' . $type);
        $file = __DIR__ . '/' . $type . '.html';
        file_put_contents($file, $doc['html']);
        printf("✅ %s — %s (%d caractères)\n", $doc['title'], basename($file), strlen($doc['html']));
    } catch (RuntimeException $e) {
        // 404 « not_applicable » = document non inclus dans ce kit (ex. pas de CGV)
        printf("⏭️  %s : %s\n", $type, $e->getMessage());
    }
}
