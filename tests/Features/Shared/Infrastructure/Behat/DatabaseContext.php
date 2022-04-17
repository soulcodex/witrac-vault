<?php

namespace Witrac\Tests\Features\Shared\Infrastructure\Behat;

use App\Kernel;
use Behat\Behat\Context\Context;
use Behat\Testwork\Hook\Scope\AfterSuiteScope;
use Behat\Testwork\Hook\Scope\BeforeSuiteScope;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Witrac\Tests\Shared\Infrastructure\Doctrine\DatabasePreparer;

final class DatabaseContext implements Context
{
    /** @BeforeSuite */
    public static function beforeSuite(BeforeSuiteScope $scope): void
    {
        self::getDatabasePreparer()->beforeClass();
    }

    /** @AfterSuite */
    public static function afterSuite(AfterSuiteScope $scope): void
    {
        self::getDatabasePreparer()->afterClass();
    }

    private static function getDatabasePreparer(): DatabasePreparer
    {
        /** @var DatabasePreparer $databasePreparer */
        $databasePreparer = self::getContainer()->get(DatabasePreparer::class);

        return $databasePreparer;
    }

    /** @BeforeScenario */
    public function beforeScenario(): void
    {
        self::getDatabasePreparer()->beforeTest();
    }

    private static function getContainer(): ContainerInterface
    {
        $kernel = new Kernel('test', true);
        $kernel->boot();

        return $kernel->getContainer();
    }
}
