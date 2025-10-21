<?php

// Script de diagnostic pour analyser un fichier CSV

if ($argc < 2) {
  echo "Usage: php debug_csv.php <chemin_fichier.csv>\n";
  exit(1);
}

$filePath = $argv[1];

if (!file_exists($filePath)) {
  echo "Erreur: Le fichier '$filePath' n'existe pas.\n";
  exit(1);
}

echo "=== DIAGNOSTIC DU FICHIER CSV ===\n\n";

// 1. Informations sur le fichier
echo "1. INFORMATIONS FICHIER:\n";
echo "   - Chemin: $filePath\n";
echo "   - Taille: " . filesize($filePath) . " octets\n";
echo "   - Encodage détecté: " . mb_detect_encoding(file_get_contents($filePath), ['UTF-8', 'ISO-8859-1', 'Windows-1252'], true) . "\n\n";

// 2. Premières lignes brutes
echo "2. PREMIÈRES LIGNES BRUTES (5 lignes):\n";
$handle = fopen($filePath, 'r');
for ($i = 0; $i < 5 && !feof($handle); $i++) {
  $line = fgets($handle);
  echo "   Ligne $i: " . trim($line) . "\n";
}
fclose($handle);
echo "\n";

// 3. Analyse avec séparateur point-virgule
echo "3. ANALYSE AVEC SÉPARATEUR ';' :\n";
$handle = fopen($filePath, 'r');
$header = fgetcsv($handle, 1000, ";");
echo "   En-tête trouvé (" . count($header) . " colonnes): \n";
foreach ($header as $i => $col) {
  echo "      [$i] => '$col'\n";
}

$rowCount = 0;
$dataRows = [];
while (($data = fgetcsv($handle, 1000, ";")) !== false && $rowCount < 3) {
  $rowCount++;
  $dataRows[] = $data;
  echo "\n   Ligne $rowCount (" . count($data) . " colonnes):\n";
  foreach ($data as $i => $value) {
    echo "      [$i] => '$value'\n";
  }
}
fclose($handle);

// 4. Vérification des catégories
if (count($dataRows) > 0) {
  echo "\n4. CATÉGORIES TROUVÉES DANS LE FICHIER:\n";
  $categories = [];
  foreach ($dataRows as $row) {
    if (isset($row[4]) && !empty($row[4])) {
      $categories[$row[4]] = true;
    }
  }
  foreach (array_keys($categories) as $cat) {
    echo "   - '$cat'\n";
  }
}

echo "\n5. FORMAT ATTENDU:\n";
echo "   Civ;Prénom du contact;Nom du contact;Société;Categorie;Téléphone;Mobile;Mail;Adresse 1;Adresse 2;CP;Ville\n";
echo "   [0];[1];[2];[3];[4];[5];[6];[7];[8];[9];[10];[11]\n\n";

echo "6. CATÉGORIES VALIDES EN BASE:\n";
echo "   - Client\n";
echo "   - Prospect\n";
echo "   - Fournisseur\n";
echo "   - Partenaire\n";
echo "   - Comédien\n\n";

echo "=== FIN DU DIAGNOSTIC ===\n";
