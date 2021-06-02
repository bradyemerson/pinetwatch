<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210602050927 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE device (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, network_id INTEGER DEFAULT NULL, mac VARCHAR(50) NOT NULL, name VARCHAR(255) DEFAULT NULL, hostname VARCHAR(255) DEFAULT NULL, type VARCHAR(100) DEFAULT NULL, vendor VARCHAR(255) DEFAULT NULL, is_favorite BOOLEAN NOT NULL, first_connection DATETIME NOT NULL, last_connection DATETIME NOT NULL, last_ip VARCHAR(50) NOT NULL, alert_device_down BOOLEAN NOT NULL, is_guest BOOLEAN NOT NULL, is_new_device BOOLEAN NOT NULL, is_wired BOOLEAN DEFAULT NULL, port SMALLINT DEFAULT NULL, satisfaction SMALLINT DEFAULT NULL, signal SMALLINT DEFAULT NULL, identified_by VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_92FB68E34128B91 ON device (network_id)');
        $this->addSql('CREATE TABLE event (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, device_id INTEGER DEFAULT NULL, date_time DATETIME NOT NULL, type CLOB NOT NULL --(DC2Type:array)
        , additional_info VARCHAR(255) NOT NULL, i_snew VARCHAR(255) NOT NULL, is_new BOOLEAN NOT NULL)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA794A4C7D4 ON event (device_id)');
        $this->addSql('CREATE TABLE network (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, is_guest BOOLEAN NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE device');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE network');
    }
}
