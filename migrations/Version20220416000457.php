<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220416000457 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '[Vault][Files] Add forgotten path field on last migration to vault_files table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE vault_files ADD path VARCHAR(255) NOT NULL AFTER size');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE vault_files DROP path');
    }
}
