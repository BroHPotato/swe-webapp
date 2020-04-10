<?php

namespace Tests\Models;

use App\Providers\AlertServiceProvider;
use PHPUnit\Framework\TestCase;

class AlertTest extends TestCase
{
    public function testSensorAttribute()
    {
        $alert = AlertServiceProvider::GetAnAlert();
        $response = array_combine(
            array('threshold', 'type', 'deleted', 'entity', 'sensor', 'lastSent', 'alertId'),
            array("10", "0", "0", '0', '0', '20-02-2020', '0')
        );
        $this->assertEquals($response, $alert->getAttributes());
    }

    public function testGetType()
    {
        $alert = AlertServiceProvider::GetAnAlert();
        $this->assertEquals('minore di', $alert->getType());
    }
}
