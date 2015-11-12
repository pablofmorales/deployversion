<?php

namespace Tests\Unit;
use \Mockery as m;

class VersioningTest extends TestBase
{

    public function testCheckTheLastVersion()
    {
        $expected = ['response' => ['project' => 'projectTest', 'version' => '2.15.01']];
        $stmt = m::mock('Doctrine\DBAL\Statement');
        $stmt->shouldReceive('fetchColumn')
            ->once()
            ->andReturn('2.15.01');

        $qb = $this->getQueryBuilderMock($stmt);

        $conn = m::mock('\Doctrine\DBAL\Connection');
        $conn->shouldReceive('createQueryBuilder')
            ->once()
            ->andReturn($qb);

        $versionModel = new \Models\Versions($conn);
        $versionController = new \Controllers\Versions($versionModel);
        $response = $versionController->latest('projectTest');

        $this->assertEquals($response, json_encode($expected));
    }
}
