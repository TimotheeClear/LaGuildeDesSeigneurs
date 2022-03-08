<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220308090135 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE player CHANGE email email VARCHAR(128) DEFAULT NULL, CHANGE creation_date creation_date DATETIME DEFAULT NULL, CHANGE last_connection_date last_connection_date DATETIME DEFAULT NULL, CHANGE modification_date modification_date DATETIME DEFAULT NULL, CHANGE mirian mirian INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE player CHANGE email email VARCHAR(128) NOT NULL, CHANGE mirian mirian INT NOT NULL, CHANGE creation_date creation_date DATETIME NOT NULL, CHANGE last_connection_date last_connection_date DATETIME NOT NULL, CHANGE modification_date modification_date DATETIME NOT NULL');
    }
}
