<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210522123143 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE person DROP CONSTRAINT person_firstparent_id_fkey');
        $this->addSql('ALTER TABLE person DROP CONSTRAINT person_secondparent_id_fkey');
        $this->addSql('CREATE SEQUENCE customer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE customer (id INT NOT NULL, email VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, phone_number VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81398E09E7927C74 ON customer (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81398E09A9D1C132 ON customer (first_name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81398E09C808BA5A ON customer (last_name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81398E096B01BC5B ON customer (phone_number)');
        $this->addSql('DROP TABLE person');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE customer_id_seq CASCADE');
        $this->addSql('CREATE TABLE person (id INT NOT NULL, firstparent_id INT DEFAULT NULL, secondparent_id INT DEFAULT NULL, firstname VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_34DCD176E8A2BD4B ON person (firstparent_id)');
        $this->addSql('CREATE INDEX IDX_34DCD1766FAED075 ON person (secondparent_id)');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT person_firstparent_id_fkey FOREIGN KEY (firstparent_id) REFERENCES person (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT person_secondparent_id_fkey FOREIGN KEY (secondparent_id) REFERENCES person (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE customer');
    }
}
