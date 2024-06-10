<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\Entity\User;
use App\Entity\Profile;
use App\Service\Profile\KpiService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class KpiServiceTest extends KernelTestCase
{

    public function testKpi(): ?array
    {
        self::bootKernel();
        $container = static::getContainer();
        /** @var KpiService $kpiService */
        $kpiService = $container->get(KpiService::class);

        $user = $container->get('doctrine')->getRepository(User::class)->findOneBy(['email' => 'superadmin@s2h.corp']);
        $profile = $container->get('doctrine')->getRepository(Profile::class)->findOneBy(['user' => $user]);

        $this->assertInstanceOf(Profile::class, $profile);
        $this->assertIsNumeric($profile->getId());
        $this->assertContains('ROLE_SUPER_ADMIN', $user->getRoles());
        $isAdmin = false;
        if (\in_array(User::ROLE_SUPER_ADMIN, $user->getRoles()) || \in_array(User::ROLE_ADMIN, $user->getRoles())) {
            $isAdmin = true;
        }

        $kpi = $kpiService->getKpi(idProfile: $profile->getId(), isAdmin: $isAdmin);
        $this->assertIsArray($kpi);
        $this->assertArrayHasKey('list_profile', $kpi);
        $this->assertArrayHasKey('nbAllProfiles', $kpi);
        $this->assertArrayHasKey('profile', $kpi);
        $this->assertArrayHasKey('userRequest', $kpi);
        $this->assertArrayHasKey('count_request_in_progress', $kpi);
        $this->assertArrayHasKey('count_request_vip', $kpi);
        $this->assertArrayHasKey('messages', $kpi);
        $this->assertArrayHasKey('count_msg_no_read', $kpi);
        $this->assertArrayHasKey('cnt_booking_month_profile', $kpi);
        $this->assertArrayHasKey('cnt_booking_month', $kpi);
        $this->assertArrayHasKey('cnt_simulation_month', $kpi);
        $this->assertArrayHasKey('bri', $kpi);
        return $kpi;
    }

    /**
     * @param array<array-key, string|int|array> $response
     * @depends testKpi
     * @return void
     *
     */
    public function testvaluesOfResult(array $response): void
    {

        $this->assertCount(5, $response['userRequest']);
        $this->assertEquals(5, $response['count_request_in_progress']);
        $this->assertEquals(2, $response['count_request_vip']);

        $this->assertCount(3, $response['messages']);
        $this->assertEquals(3, $response['count_msg_no_read']['count_unread_messages']);

        $this->assertEquals(3, $response['cnt_booking_month_profile']);
        $this->assertEquals(4, $response['cnt_booking_month']);
        $this->assertEquals(1, $response['cnt_simulation_month']);
    }

}
