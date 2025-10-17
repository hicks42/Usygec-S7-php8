<?php

namespace App\Service;

use App\Entity\EntityBam\Company;
use App\Entity\EntityBam\Category;
use App\Repository\RepositoryBam\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use League\Csv\Writer as CsvWriter;

class CompanyCsvManager
{
  private $companyRepository;
  private $em;

  public function __construct(CompanyRepository $companyRepository, EntityManagerInterface $em)
  {
    $this->companyRepository = $companyRepository;
    $this->em = $em;
  }

  public function exportCompaniesToCsv($user): Response
  {
    $userCompanies = $this->companyRepository->findBy(['handler' => $user]);

    $fileName = 'ExportUsygec.csv';

    $csvWriter = $this->getCsvWriter($fileName);

    $csvWriter->insertOne(['Civ', 'Prénom du contact', 'Nom du contact', 'Société', 'Categorie', 'Téléphone', 'Mobile', 'Mail', 'Adresse 1', 'Adresse 2', 'CP', 'Ville']);

    foreach ($userCompanies as $company) {
      $csvWriter->insertOne([
        $company->getCiv(),
        $company->getContactFirstName(),
        $company->getContactLastName(),
        $company->getName(),
        $company->getCategoryAsString(),
        $company->getPhone(),
        $company->getMobile(),
        $company->getEmail(),
        $company->getAddress1(),
        $company->getAddress2(),
        $company->getCp(),
        $company->getCity(),
      ]);
    }

    $response = new Response($csvWriter->toString(), Response::HTTP_OK);

    $response->headers->set('Content-Type', 'text/csv');
    $response->headers->set('Content-Disposition', 'attachment; filename="' . $fileName . '"');

    return $response;
  }

  public function importCompaniesFromCsv(UploadedFile $file, $user): array
  {
    $items = array();
    $row = 0;
    $skipped = 0;
    $imported = 0;
    $totalLines = 0;
    $invalidLines = 0;
    $emptyLines = 0;
    $detectedSeparator = null;
    $detectedColumns = 0;
    $errors = []; // Tableau pour collecter toutes les erreurs détaillées
    $duplicates = []; // Tableau pour les doublons

    if (($handle = fopen($file->getPathname(), 'r')) !== false) {
      // Lire la première ligne pour analyse
      $firstLine = fgets($handle);
      rewind($handle);

      // Détecter le séparateur automatiquement
      $commaCount = substr_count($firstLine, ',');
      $semicolonCount = substr_count($firstLine, ';');

      // Choisir le séparateur qui donne le plus de colonnes (≥ 11)
      if ($semicolonCount >= 11) {
        $detectedSeparator = ';';
      } elseif ($commaCount >= 11) {
        $detectedSeparator = ',';
      } else {
        $detectedSeparator = 'inconnu';
      }

      // Lire l'en-tête avec le séparateur détecté
      $header = fgetcsv($handle, 1000, $detectedSeparator);
      $detectedColumns = count($header);

      // Vérifier que le format est correct
      if ($detectedSeparator === 'inconnu' || $detectedColumns < 12) {
        fclose($handle);
        $errors[] = [
          'type' => 'format',
          'message' => 'Format de fichier incorrect',
          'details' => sprintf(
            "Attendu : 12 colonnes | Trouvé : %d colonne(s) avec séparateur %s",
            $detectedColumns,
            $detectedSeparator === ',' ? 'virgule (,)' : ($detectedSeparator === ';' ? 'point-virgule (;)' : 'inconnu')
          ),
          'solution' => 'Format attendu : 12 colonnes séparées par ";" ou "," (Civ, Prénom du contact, Nom du contact, Société, Categorie, Téléphone, Mobile, Mail, Adresse 1, Adresse 2, CP, Ville)'
        ];
        return [
          'success' => false,
          'count' => 0,
          'errors' => $errors,
          'skipped' => 0,
          'duplicates' => [],
          'totalLines' => 0,
          'invalidLines' => 0,
          'emptyLines' => 0,
        ];
      }

      // Traiter les lignes avec le séparateur détecté
      while (($data = fgetcsv($handle, 1000, $detectedSeparator)) !== false) {
        $totalLines++;
        $lineNumber = $totalLines + 1; // +1 pour compter l'en-tête

        // Vérifier que la ligne a au moins 12 colonnes
        if (count($data) < 12) {
          $invalidLines++;
          $errors[] = [
            'type' => 'invalid_columns',
            'line' => $lineNumber,
            'message' => sprintf('Ligne %d : nombre de colonnes insuffisant', $lineNumber),
            'details' => sprintf('Trouvé : %d colonne(s) | Attendu : 12 colonnes', count($data))
          ];
          continue;
        }

        $companyName = $data[3] ?? '';
        $postalCode = isset($data[10]) ? intval($data[10]) : 0;

        // Ignorer les lignes vides
        if (empty($companyName)) {
          $emptyLines++;
          $errors[] = [
            'type' => 'empty_company',
            'line' => $lineNumber,
            'message' => sprintf('Ligne %d : nom de société vide', $lineNumber),
            'details' => 'La colonne "Société" est obligatoire'
          ];
          continue;
        }

        $existingCompany = $this->em->getRepository(Company::class)->findOneBy([
          'name' => $companyName,
          'cp' => $postalCode,
          'handler' => $user,
        ]);

        if ($existingCompany) {
          $skipped++;
          $duplicates[] = [
            'line' => $lineNumber,
            'company' => $companyName,
            'cp' => $postalCode
          ];
          continue;
        }

        $row++;
        $items[$row] = array(
          "Civ" => $data[0] ?? '',
          "Prénom du contact" => $data[1] ?? '',
          "Nom du contact" => $data[2] ?? '',
          "Société" => $data[3] ?? '',
          "Categorie" => $data[4] ?? '',
          "Téléphone" => $data[5] ?? '',
          "Mobile" => $data[6] ?? '',
          "Mail" => $data[7] ?? '',
          "Adresse 1" => $data[8] ?? '',
          "Adresse 2" => $data[9] ?? '',
          "CP" => isset($data[10]) ? intval($data[10]) : 0,
          "Ville" => $data[11] ?? '',
        );
      }
      fclose($handle);
    }

    foreach ($items as $lineNum => $item) {
      $newCompany = new Company();

      $categoryName = $item["Categorie"];
      $category = $this->em->getRepository(Category::class)->findOneBy(['name' => $categoryName]);
      if (!$category) {
        $errors[] = [
          'type' => 'category_not_found',
          'line' => $lineNum + 1,
          'message' => sprintf('Ligne %d : catégorie inexistante', $lineNum + 1),
          'details' => sprintf('La catégorie "%s" n\'existe pas en base de données', $categoryName),
          'solution' => 'Veuillez créer cette catégorie d\'abord ou utiliser une catégorie existante'
        ];
        continue;
      }

      $newCompany->setCiv($item["Civ"]);
      $newCompany->setContactFirstName($item["Prénom du contact"]);
      $newCompany->setContactLastName($item["Nom du contact"]);
      $newCompany->setName($item["Société"]);
      $newCompany->setCategory($category);
      $newCompany->setPhone($item["Téléphone"]);
      $newCompany->setMobile($item["Mobile"]);
      $newCompany->setEmail($item["Mail"]);
      $newCompany->setAddress1($item["Adresse 1"]);
      $newCompany->setAddress2($item["Adresse 2"]);
      $newCompany->setCp($item["CP"]);
      $newCompany->setCity($item["Ville"]);
      $newCompany->setHandler($user);

      $this->em->persist($newCompany);
      $imported++;
    }

    // Flush all at once
    $this->em->flush();

    // Delete temporary file
    $this->deleteFile($file->getPathname());

    return [
      'success' => $imported > 0,
      'count' => $imported,
      'skipped' => $skipped,
      'duplicates' => $duplicates,
      'totalLines' => $totalLines,
      'invalidLines' => $invalidLines,
      'emptyLines' => $emptyLines,
      'errors' => $errors,
    ];
  }

  private function getCsvWriter(string $fileName): CsvWriter
  {
    // Create the CSV writer
    $csvWriter = CsvWriter::createFromPath('php://memory', 'w+');
    $csvWriter->setOutputBOM(CsvWriter::BOM_UTF8); // Set the encoding to UTF-8 if needed
    $csvWriter->setDelimiter(';'); // Set the delimiter character if needed

    return $csvWriter;
  }

  private function deleteFile(string $filepath): void
  {
    $filesystem = new Filesystem();
    if (file_exists($filepath)) {
      $filesystem->remove($filepath);
    }
  }
}
