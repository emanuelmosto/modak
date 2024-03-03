<?php


namespace Tests\Api;

use Tests\Support\ApiTester;

class CheckStatusCest
{
    // tests
    public function checkStatus(ApiTester $I)
    {
        $I->wantTo('I want to test the "status" endpoint');
        $I->sendGET('api/v1/status');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['status' => 'OK']);
    }
}
