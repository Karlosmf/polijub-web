<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\ShoppingService;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class ShoppingServiceTest extends TestCase
{
    protected $tempSettingsPath;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tempSettingsPath = base_path('config/app_settings.json.bak');
        if (File::exists(base_path('config/app_settings.json'))) {
            File::copy(base_path('config/app_settings.json'), $this->tempSettingsPath);
        }
    }

    protected function tearDown(): void
    {
        if (File::exists($this->tempSettingsPath)) {
            File::move($this->tempSettingsPath, base_path('config/app_settings.json'));
        }
        parent::tearDown();
    }

    protected function setConfig(array $config)
    {
        $settings = ['shopping_hours' => $config];
        File::put(base_path('config/app_settings.json'), json_encode($settings));
    }

    public function test_it_correctly_identifies_disabled_day()
    {
        $this->setConfig([
            'enabled' => true,
            'schedule' => [
                'fri' => ['enabled' => false, 'start_time' => '09:00', 'end_time' => '22:00'],
            ]
        ]);

        Carbon::setTestNow('2025-10-24 12:00:00'); // A Friday
        $this->assertTrue(ShoppingService::isDayDisabled());
        $this->assertFalse(ShoppingService::isShoppingAllowed());
        $this->assertStringContainsString('hoy no tomamos pedidos', ShoppingService::getStatusMessage());
    }

    public function test_it_correctly_identifies_outside_hours()
    {
        $this->setConfig([
            'enabled' => true,
            'schedule' => [
                'mon' => ['enabled' => true, 'start_time' => '10:00', 'end_time' => '20:00'],
            ]
        ]);

        Carbon::setTestNow('2025-10-20 09:00:00'); // Monday before
        $this->assertFalse(ShoppingService::isDayDisabled());
        $this->assertTrue(ShoppingService::isOutsideHours());
        $this->assertFalse(ShoppingService::isShoppingAllowed());
        $this->assertStringContainsString('horario de atención hoy es de 10:00 a 20:00', ShoppingService::getStatusMessage());
    }

    public function test_it_allows_everything_when_global_switch_is_off()
    {
        $this->setConfig([
            'enabled' => false,
            'schedule' => [
                'mon' => ['enabled' => true, 'start_time' => '10:00', 'end_time' => '20:00'],
            ]
        ]);

        Carbon::setTestNow('2025-10-20 09:00:00'); // Monday outside hours
        $this->assertTrue(ShoppingService::isShoppingAllowed());
        $this->assertNull(ShoppingService::getStatusMessage());
    }
}
