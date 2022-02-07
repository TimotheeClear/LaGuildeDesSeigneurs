<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220207132531 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE `character`');
        $this->addSql('ALTER TABLE characters ADD identifier VARCHAR(40) NOT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE intelligence intelligence INT DEFAULT NULL, CHANGE life life INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `character` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(16) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, surname VARCHAR(64) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, caste VARCHAR(16) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, knowledge VARCHAR(16) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, intelligence INT DEFAULT NULL, life INT DEFAULT NULL, image VARCHAR(128) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, kind VARCHAR(16) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, creation DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE characters DROP identifier, CHANGE id id TINYINT(1) NOT NULL, CHANGE name name VARCHAR(16) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE surname surname VARCHAR(64) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE caste caste VARCHAR(16) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE knowledge knowledge VARCHAR(16) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE intelligence intelligence TINYINT(1) DEFAULT NULL, CHANGE life life TINYINT(1) DEFAULT NULL, CHANGE image image VARCHAR(128) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE kind kind VARCHAR(16) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
