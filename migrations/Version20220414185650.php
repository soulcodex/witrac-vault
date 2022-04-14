<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Witrac\Shared\Domain\Bus\Event\EventBus;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220414185650 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '[Event][Domain Events] Create domain_events table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(sprintf('CREATE TABLE `%s` (
                    id VARCHAR(36) NOT NULL, 
                    aggregate_id VARCHAR(255) NOT NULL, 
                    name VARCHAR(255) NOT NULL, 
                    body LONGTEXT NOT NULL, 
                    created_at DATETIME NOT NULL,
                    PRIMARY KEY(id)
                ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB',
            EventBus::STORE_ON
            )
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql(sprintf('DROP TABLE `%s`', EventBus::STORE_ON));
    }
}
