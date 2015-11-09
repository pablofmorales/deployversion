<?php
namespace Tests\Unit;

include 'vendor/autoload.php';

use \Mockery as m;

class TestBase extends \PHPUnit_Framework_TestCase
{

    protected function tearDown()
    {
        m::close();
    }

    protected function getQueryBuilderMock($stmt)
    {
        $qb = m::mock('Doctrine\DBAL\Query\QueryBuilder');
        $expr = m::mock('Doctrine\DBAL\Query\Expression\ExpressionBuilder');

        $qbMethods = [
            'select', 'delete', 'update', 'set',
            'from', 'leftJoin', 'innerJoin',
            'where', 'andWhere', 'orWhere',
            'groupBy', 'addGroupBy',
            'having', 'andHaving', 'orHaving',
            'orderBy', 'addOrderBy',
            'setParameter', 'setMaxResults',
            'setFirstResult', 'addSelect'
        ];
        foreach ($qbMethods as $method) {
            $qb->shouldReceive($method)->andReturn($qb);
        }

        $exprMethods = array('orX', 'andX', 'add');
        foreach ($exprMethods as $method) {
            $expr->shouldReceive($method)->andReturn($expr);
        }

        $qb->shouldReceive('expr')->andReturn($expr);
        $qb->shouldReceive('execute')->andReturn($stmt);

        return $qb;
    }

}
