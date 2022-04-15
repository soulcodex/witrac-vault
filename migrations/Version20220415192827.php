<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220415192827 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '[Vault][Files] Create vault_fiels table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vault_files (
                    id VARCHAR(36) NOT NULL, 
                    name VARCHAR(255) NOT NULL, 
                    size INT NOT NULL, 
                    mime_type VARCHAR(255) NOT NULL, 
                    status VARCHAR(255) NOT NULL, 
                    created_at DATETIME NOT NULL, 
                    updated_at DATETIME DEFAULT NULL, 
                    PRIMARY KEY(id)
                ) 
            DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE vault_files');
    }
}
