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

  public function importCompaniesFromCsv(UploadedFile $file, $user)
  {
    $items = array();
    $row = 0;

    if (($handle = fopen($file->getPathname(), 'r')) !== false) {
      fgetcsv($handle, 1000, ";");
      while (($data = fgetcsv($handle, 1000, ";")) !== false) {
        $companyName = $data[3];
        $postalCode = intval($data[10]);

        $existingCompany = $this->em->getRepository(Company::class)->findOneBy([
          'name' => $companyName,
          'cp' => $postalCode,
          'handler' => $user,
        ]);

        if ($existingCompany) {
          continue;
        }

        $num = count($data);
        $row++;
        for ($c = 1; $c < $num; $c++) {
          $items[$row] = array(
            "Civ" => $data[0],
            "Prénom du contact" => $data[1],
            "Nom du contact" => $data[2],
            "Société" => $data[3],
            "Categorie" => $data[4],
            "Téléphone" => $data[5],
            "Mobile" => $data[6],
            "Mail" => $data[7],
            "Adresse 1" => $data[8],
            "Adresse 2" => $data[9],
            "CP" => intval($data[10]),
            "Ville" => $data[11],
          );
        }
      }
    }

    foreach ($items as $item) {
      $newCompany = new Company();

      $categoryName = $item["Categorie"];
      $category = $this->em->getRepository(Category::class)->findOneBy(['name' => $categoryName]);
      if (!$category) {
        throw new \Exception("La catégorie avec le nom '" . $categoryName . "' n'existe pas.");
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
    }
    fclose($handle);
    $this->em->flush();
    $this->deleteFile($file);
  }

  private function getCsvWriter(string $fileName): CsvWriter
  {
    // Create the CSV writer
    $csvWriter = CsvWriter::createFromPath('php://memory', 'w+');
    $csvWriter->setOutputBOM(CsvWriter::BOM_UTF8); // Set the encoding to UTF-8 if needed
    $csvWriter->setDelimiter(';'); // Set the delimiter character if needed

    return $csvWriter;
  }

  private function deleteFile(string $filename)
  {
    $filesystem = new Filesystem();
    $filesystem->remove(['uploads/csv/' . $filename]);
  }
}
