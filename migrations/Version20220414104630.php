<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220414104630 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '[Vault][Libraries] Create vault_libraries table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE vault_libraries (
                id VARCHAR(36) NOT NULL, 
                name VARCHAR(255) NOT NULL, 
                created_at DATETIME NOT NULL, 
                updated_at DATETIME DEFAULT NULL, 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE vault_libraries');
    }
}
