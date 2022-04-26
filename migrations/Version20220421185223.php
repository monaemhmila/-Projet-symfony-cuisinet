<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220421185223 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user CHANGE is_banned is_banned TINYINT(1) DEFAULT false, CHANGE is_activated is_activated TINYINT(1) DEFAULT false, CHANGE activation_code activation_code VARCHAR(255) DEFAULT \'\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user CHANGE is_banned is_banned TINYINT(1) DEFAULT 0, CHANGE is_activated is_activated TINYINT(1) DEFAULT 0, CHANGE activation_code activation_code VARCHAR(255) DEFAULT \'\' NOT NULL');
    }
}
