<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220308084836 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE characters ADD gls_name VARCHAR(16) NOT NULL, ADD caste VARCHAR(16) DEFAULT NULL, DROP name, CHANGE surname surname VARCHAR(64) NOT NULL, CHANGE knowledge knowledge VARCHAR(16) DEFAULT NULL, CHANGE image image VARCHAR(128) DEFAULT NULL, CHANGE kind kind VARCHAR(16) NOT NULL, CHANGE identifier identifier VARCHAR(40) NOT NULL');
        $this->addSql('ALTER TABLE player DROP mirian, CHANGE firstname firstname VARCHAR(32) NOT NULL, CHANGE lastname lastname VARCHAR(32) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE characters ADD name VARCHAR(255) NOT NULL, DROP gls_name, DROP caste, CHANGE surname surname VARCHAR(255) NOT NULL, CHANGE knowledge knowledge VARCHAR(255) NOT NULL, CHANGE image image VARCHAR(255) NOT NULL, CHANGE kind kind VARCHAR(255) NOT NULL, CHANGE identifier identifier VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE player ADD mirian INT DEFAULT NULL, CHANGE firstname firstname VARCHAR(64) NOT NULL, CHANGE lastname lastname VARCHAR(64) NOT NULL');
    }
}
