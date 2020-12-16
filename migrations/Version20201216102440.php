<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201216102440 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE episode ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE program CHANGE synopsis synopsis LONGTEXT NOT NULL, CHANGE country country VARCHAR(255) NOT NULL, CHANGE year year INT NOT NULL, CHANGE summary summary LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE season CHANGE program_id program_id INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE episode DROP slug');
        $this->addSql('ALTER TABLE program CHANGE summary summary LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE synopsis synopsis TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE country country VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE year year INT DEFAULT NULL');
        $this->addSql('ALTER TABLE season CHANGE program_id program_id INT DEFAULT NULL');
    }
}
