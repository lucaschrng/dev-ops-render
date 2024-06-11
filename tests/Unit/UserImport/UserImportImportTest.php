<?php

declare(strict_types=1);

namespace App\Tests\Unit\UserImport;

use App\Entity\Company;
use App\Entity\Profile;
use App\Entity\User;
use App\Entity\UserImport;
use App\Service\Common\UploadFileHelper;
use App\Service\MassUserImport\UserImportImporter;
use DG\BypassFinals;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ObjectRepository;
use Psr\Log\NullLogger;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Storage\StorageInterface;

/**
 *@group MassUserImport
 */
final class UserImportImportTest extends KernelTestCase
{
    public const FROM_DIRECTORY = 'fixtures/User-import';
    public const TO_DIRECTORY = 'fixtures/In';

    /**
     * @var EntityManager
     */
    private EntityManager $entityManager;

    /**
     * @var StorageInterface
     */
    private $storage;
    /**
     * @var UploadFileHelper
     */
    private $uploadFileHelper;

    /**
     * @var EntityRepository|ObjectRepository
     */
    private ObjectRepository|EntityRepository $profileRepository;

    /**
     * @var NullLogger;
     */
    private NullLogger $logger;

    /**
     * @var File;
     */
    private File $file;

    public function setUp(): void
    {
        BypassFinals::enable();
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->storage = $this->createMock(StorageInterface::class);
        $this->uploadFileHelper = $this->createMock(UploadFileHelper::class);
        $this->profileRepository = $this->entityManager->getRepository(Profile::class);
        $this->logger = new NullLogger();
    }

    private function initUserImport(string $fileName, string $companyLabel): UserImport
    {
        $userImport = new UserImport();
        $tmpFile = new File(__DIR__.'/../'.self::FROM_DIRECTORY.'/'.$fileName);
        copy($tmpFile->getPathname(), __DIR__.'/../'.self::TO_DIRECTORY.'/'.$fileName);
        $this->file = new File(__DIR__.'/../'.self::TO_DIRECTORY.'/'.$fileName);

        $userImport->setFile($this->file);
        $userImport->setFilePath($this->file->getFilename());

        $company = $this->entityManager->getRepository(Company::class)->findOneBy(['label' => $companyLabel]);
        $userImport->setCompany($company);
        $userImport->setProcessStartedAt(new \DateTime());
        $userImport->setStatus(UserImport::STATUS_WIP);

        return $userImport;
    }

    public function testImportCsvOkay()
    {
        $userImport = $this->initUserImport('user_import.csv', 'diot-siaci');

        $this->assertEquals(UserImport::STATUS_WIP, $userImport->getStatus());
        $this->assertInstanceOf(\DateTime::class, $userImport->getProcessStartedAt());

        $this->storage
            ->expects($this->once())
            ->method('resolvePath')
            ->willReturn($this->file->getPathname());

        $userImportImporter = new UserImportImporter(
            em: $this->entityManager,
            storage: $this->storage,
            usersImportLogger: $this->logger,
            uploadFileHelper: $this->uploadFileHelper,
            profileRepository: $this->profileRepository
        );

        $resultUserImport = $userImportImporter->import($userImport, ignoreRemoveFile: true);
        //persist
        $this->entityManager->persist($resultUserImport);
        $this->entityManager->flush();

        $this->assertEquals(1, $resultUserImport->getProcessed());
        $this->assertEquals(3, $resultUserImport->getSuccessCount());
        $this->assertEquals(2, $resultUserImport->getFailedCount());
        $failedResult = $resultUserImport->getFailedLines();
        $this->assertCount(2, $failedResult);
        $this->assertSame('bad.company.id@gmail.com', $failedResult[0]['email']);
        $this->assertSame('Aucun email founi !', $failedResult[1]['email']);
        $this->assertStringContainsString("La valeur fournie bad.emailarobasee@@gmail.com n'est pas un email valide", $failedResult[1]['error']);

        $user = $this->entityManager->getRepository(User::class)->findOneBy([
            'email' => 'qhxpfojhpr.ydrexredpc_2@gmail.com',
        ]);

        $profile = $user->getProfile();

        $this->assertInstanceOf(User::class, $user);
        $this->assertInstanceOf(Profile::class, $profile);
        $this->assertSame('Paul', $profile->getFirstName());
        $this->assertSame('Bismuth', $profile->getLastName());
    }

    /**
     * @group Brice
     */
    public function testImportCsvProfileAlreadyExists()
    {
        $userImport = $this->initUserImport('user_import-doublon-profiles.csv', 'diot-siaci');

        $this->storage
            ->expects($this->once())
            ->method('resolvePath')
            ->willReturn($this->file->getPathname());

        $userImportImporter = new UserImportImporter(
            em: $this->entityManager,
            storage: $this->storage,
            usersImportLogger: $this->logger,
            uploadFileHelper: $this->uploadFileHelper,
            profileRepository: $this->profileRepository
        );

        $resultUserImport = $userImportImporter->import($userImport, ignoreRemoveFile: true);

        $this->assertEquals(1, $resultUserImport->getProcessed());
        $this->assertEquals(1, $resultUserImport->getSuccessCount());
        $this->assertEquals(1, $resultUserImport->getFailedCount());
        $failedResult = $resultUserImport->getFailedLines();
        $this->assertCount(1, $failedResult);
        $this->assertSame('brice.pote2@gmail.com', $failedResult[0]['email']);
        $this->assertStringContainsString("Utilisateur M POTE-PTQ Brice-PTQ : Cet utilisateur existe déjà", $failedResult[0]['error']);

    }

    /**
     * @group Brice2
     */
    public function testBadCompanyRequested()
    {
        $userImport = $this->initUserImport('user_import-bad-company.csv', 'diot-siaci');

        $this->storage
            ->expects($this->once())
            ->method('resolvePath')
            ->willReturn($this->file->getPathname());

        $userImportImporter = new UserImportImporter(
            em: $this->entityManager,
            storage: $this->storage,
            usersImportLogger: $this->logger,
            uploadFileHelper: $this->uploadFileHelper,
            profileRepository: $this->profileRepository
        );

        $resultUserImport = $userImportImporter->import($userImport, ignoreRemoveFile: true);
        $this->asserttrue(true);

    }
}
