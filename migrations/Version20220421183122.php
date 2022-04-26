<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220421183122 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE events');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE users');
        $this->addSql('ALTER TABLE user CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE fullname fullname VARCHAR(255) NOT NULL, CHANGE role role VARCHAR(255) NOT NULL, CHANGE avatar avatar VARCHAR(255) DEFAULT \'\' NOT NULL, CHANGE is_banned is_banned TINYINT(1) DEFAULT false, CHANGE is_activated is_activated TINYINT(1) DEFAULT false, CHANGE activation_code activation_code VARCHAR(255) DEFAULT \'\' NOT NULL, ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE events (event_id INT AUTO_INCREMENT NOT NULL, nom_event VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, event_date_debut DATE NOT NULL, event_date_fin DATE NOT NULL, event_type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, tournament_game VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(event_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE products (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, price VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, descr VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'Description is null.\' NOT NULL COLLATE `utf8mb4_general_ci`, img VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, fullname VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'Foo Bar\' NOT NULL COLLATE `utf8mb4_general_ci`, role VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT \'Normal\' COLLATE `utf8mb4_general_ci`, avatar VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'default.jpg\' NOT NULL COLLATE `utf8mb4_general_ci`, isBanned INT DEFAULT 0 NOT NULL, isActivated INT DEFAULT 0 NOT NULL, activationCode VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT \'\' NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE user DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE user CHANGE id id INT DEFAULT 0 NOT NULL, CHANGE fullname fullname VARCHAR(255) DEFAULT \'Foo Bar\' NOT NULL, CHANGE role role VARCHAR(100) DEFAULT \'Normal\', CHANGE avatar avatar VARCHAR(255) DEFAULT \'default.jpg\' NOT NULL, CHANGE is_banned is_banned INT DEFAULT 0 NOT NULL, CHANGE is_activated is_activated INT DEFAULT 0 NOT NULL, CHANGE activation_code activation_code VARCHAR(100) DEFAULT \'\' NOT NULL');
    }
}
