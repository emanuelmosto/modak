<?php

namespace Entities;

use Codeception\Util\JsonType;
use Project\Entities\Rate;
use stdClass;

class RateTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testCreateASimpleRate()
    {
        $rate = new Rate(5,'minute', '12313');
        $rate->updateRate(6);

        $jsonType = new JsonType(json_decode(json_encode($rate), true));
        $match = $jsonType->matches([
            'unit'=>'string:regex("minute")',
            'currentTime'=>'string:regex("12313")'
        ]);

        $this->assertTrue($match);
        $this->assertEquals($rate->getRateNumber(), 6);
    }

}
