<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220411225630 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE promotions CHANGE idprod idprod INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users CHANGE isBanned isBanned INT NOT NULL, CHANGE isActivated isActivated INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE promotions CHANGE idprod idprod INT NOT NULL');
        $this->addSql('ALTER TABLE users CHANGE isBanned isBanned INT DEFAULT 0 NOT NULL, CHANGE isActivated isActivated INT DEFAULT 0 NOT NULL');
    }
}
