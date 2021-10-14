<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211014072527 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bord (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, contribute_id INTEGER NOT NULL, contribute_user_id INTEGER NOT NULL, user_id INTEGER NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , delete_flg BOOLEAN DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_A436D2BCD41657D6 ON bord (contribute_id)');
        $this->addSql('CREATE INDEX IDX_A436D2BCDCFBDDB7 ON bord (contribute_user_id)');
        $this->addSql('CREATE INDEX IDX_A436D2BCA76ED395 ON bord (user_id)');
        $this->addSql('CREATE TABLE contribute (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, textarea VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX IDX_E090DA21A76ED395 ON contribute (user_id)');
        $this->addSql('CREATE TABLE message (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, to_user_id INTEGER NOT NULL, from_user_id INTEGER NOT NULL, bord_id INTEGER NOT NULL, contribute_id INTEGER NOT NULL, message VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , delete_flg BOOLEAN NOT NULL)');
        $this->addSql('CREATE INDEX IDX_B6BD307F29F6EE60 ON message (to_user_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F2130303A ON message (from_user_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FD6B1F0E4 ON message (bord_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FD41657D6 ON message (contribute_id)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(255) NOT NULL, age INTEGER NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, area VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, sex VARCHAR(255) NOT NULL, look VARCHAR(255) NOT NULL, is_active BOOLEAN NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE bord');
        $this->addSql('DROP TABLE contribute');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE user');
    }
}
