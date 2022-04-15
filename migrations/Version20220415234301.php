<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220415234301 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '[Vault][Files] Relate a file with a library';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE vault_files ADD library_id VARCHAR(255) NOT NULL AFTER id');
        $this->addSql('ALTER TABLE vault_files ADD CONSTRAINT FK_5BAD8C22FE2541D7 FOREIGN KEY (library_id) REFERENCES vault_libraries (id)');
        $this->addSql('CREATE INDEX IDX_5BAD8C22FE2541D7 ON vault_files (library_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE vault_files DROP FOREIGN KEY FK_5BAD8C22FE2541D7');
        $this->addSql('DROP INDEX IDX_5BAD8C22FE2541D7 ON vault_files');
        $this->addSql('ALTER TABLE vault_files DROP library_id');
    }
}
