<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\Entity\Package;
use App\Service\Package\PackageService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class PackageServiceTest extends KernelTestCase
{

    /**
     * @throws Exception
     */
    public function testPackageSoftDeletable(): void
    {
        //Get one package or entity Package
        $package = $this->getPackage(['name' => 'Package un']);
        //PackageService is a service that contains the method isSoftDeletablePackage
        $packageService = $this->getPackageService();
        //Get the result of the method isSoftDeletablePackage
        $result = $packageService->isSoftDeletablePackage($package);
        //Assert that the result false
        $this->assertFalse($result);

        $package = $this->getPackage(['name' => 'Package trois']);
        //PackageService is a service that contains the method isSoftDeletablePackage
        $packageService = $this->getPackageService();
        //Get the result of the method isSoftDeletablePackage
        $result = $packageService->isSoftDeletablePackage($package);
        //Assert that the result false
        $this->assertTrue($result);

    }

    private function getPackage(array $criteria = []): Package
    {
        $package = $this->getPackageRepository()->findOneBy($criteria);
        if (!$package) {
            throw new Exception('Package not found');
        }
        return $package;
    }

    private function getPackageRepository()
    {
        self::bootKernel();
        $container = static::getContainer();
        return $container->get('doctrine')->getRepository(Package::class);
    }

    private function getPackageService(): object
    {
        self::bootKernel();
        return static::getContainer()->get(PackageService::class);
    }

}
