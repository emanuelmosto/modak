<?php


namespace Api;

use Tests\Support\ApiTester;

class CheckMessageRateCest
{
    // tests
    public function checkRateOK(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendPost('api/v1/messages', [
            'id' => '7875be4b-917d-4aff-8cc4-5606c36bf418a',
            'type' => 'Status',
            "recipient_id" => "9b8988a0-3bf1-4ebb-b270as",
            "clean_text" => "Test Message",
            "rate_limit" => [
                "rate" => 2,
                "unit" => "second"
            ]]);

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('Message Sent');
    }
}
