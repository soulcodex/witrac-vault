<?php

namespace Witrac\Tests\Shared\Infrastructure\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use function Lambdish\Phunctional\first;
use function Lambdish\Phunctional\map;

final class DoctrineMysqlDatabaseCleaner implements DatabaseCleaner
{
    /**
     * @throws Exception
     */
    public function clean(EntityManagerInterface $entityManager): void
    {
        $connection = $entityManager->getConnection();

        $tables = $this->tables($connection);
        $truncateTablesSql = $this->truncateDatabaseSql($tables);

        $connection->executeQuery($truncateTablesSql);
    }

    private function truncateDatabaseSql(array $tables): string
    {
        $truncateTables = map($this->truncateTableSql(), $tables);

        return sprintf('SET FOREIGN_KEY_CHECKS = 0; %s SET FOREIGN_KEY_CHECKS = 1;', implode(' ', $truncateTables));
    }

    private function truncateTableSql(): callable
    {
        return fn (array $table): string => sprintf('TRUNCATE TABLE `%s`;', first($table));
    }

    /**
     * @throws Exception
     */
    private function tables(Connection $connection): array
    {
        return $connection->executeQuery('SHOW TABLES')->fetchAllAssociative();
    }
}
