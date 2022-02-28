<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220228123838 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE characters ADD player_id INT DEFAULT NULL, DROP caste, CHANGE name name VARCHAR(255) NOT NULL, CHANGE surname surname VARCHAR(255) NOT NULL, CHANGE knowledge knowledge VARCHAR(255) NOT NULL, CHANGE image image VARCHAR(255) NOT NULL, CHANGE kind kind VARCHAR(255) NOT NULL, CHANGE identifier identifier VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE characters ADD CONSTRAINT FK_3A29410E99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('CREATE INDEX IDX_3A29410E99E6F5DF ON characters (player_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE characters DROP FOREIGN KEY FK_3A29410E99E6F5DF');
        $this->addSql('DROP INDEX IDX_3A29410E99E6F5DF ON characters');
        $this->addSql('ALTER TABLE characters ADD caste VARCHAR(16) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP player_id, CHANGE name name VARCHAR(16) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE surname surname VARCHAR(64) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE knowledge knowledge VARCHAR(16) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image image VARCHAR(128) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE kind kind VARCHAR(16) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE identifier identifier VARCHAR(40) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE player CHANGE firstname firstname VARCHAR(64) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE lastname lastname VARCHAR(64) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(128) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE identifier identifier VARCHAR(40) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
