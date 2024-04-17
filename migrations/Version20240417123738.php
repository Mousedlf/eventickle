<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240417123738 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE availability_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE booking_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE comedian_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE comedy_club_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE equipment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE establishment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE event_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE image_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE invite_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "like_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE spectator_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ticket_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE availability (id INT NOT NULL, dates TEXT NOT NULL, capacity INT DEFAULT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN availability.dates IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE booking (id INT NOT NULL, event_id INT NOT NULL, location_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E00CEDDE71F7E88B ON booking (event_id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE64D218E ON booking (location_id)');
        $this->addSql('CREATE TABLE comedian (id INT NOT NULL, profile_picture_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, links TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_86AE26C6292E8AE2 ON comedian (profile_picture_id)');
        $this->addSql('COMMENT ON COLUMN comedian.links IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE comedian_spectator (comedian_id INT NOT NULL, spectator_id INT NOT NULL, PRIMARY KEY(comedian_id, spectator_id))');
        $this->addSql('CREATE INDEX IDX_C9101BA11D3228F ON comedian_spectator (comedian_id)');
        $this->addSql('CREATE INDEX IDX_C9101BA1523FB688 ON comedian_spectator (spectator_id)');
        $this->addSql('CREATE TABLE comedian_availability (comedian_id INT NOT NULL, availability_id INT NOT NULL, PRIMARY KEY(comedian_id, availability_id))');
        $this->addSql('CREATE INDEX IDX_67F23D671D3228F ON comedian_availability (comedian_id)');
        $this->addSql('CREATE INDEX IDX_67F23D6761778466 ON comedian_availability (availability_id)');
        $this->addSql('CREATE TABLE comedy_club (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE equipment (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE establishment (id INT NOT NULL, siret VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, adress VARCHAR(255) NOT NULL, accessibility TEXT DEFAULT NULL, name VARCHAR(255) NOT NULL, phone_number VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN establishment.accessibility IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE establishment_availability (establishment_id INT NOT NULL, availability_id INT NOT NULL, PRIMARY KEY(establishment_id, availability_id))');
        $this->addSql('CREATE INDEX IDX_CDE405BB8565851 ON establishment_availability (establishment_id)');
        $this->addSql('CREATE INDEX IDX_CDE405BB61778466 ON establishment_availability (availability_id)');
        $this->addSql('CREATE TABLE establishment_equipment (establishment_id INT NOT NULL, equipment_id INT NOT NULL, PRIMARY KEY(establishment_id, equipment_id))');
        $this->addSql('CREATE INDEX IDX_1BA4FDF08565851 ON establishment_equipment (establishment_id)');
        $this->addSql('CREATE INDEX IDX_1BA4FDF0517FE9FE ON establishment_equipment (equipment_id)');
        $this->addSql('CREATE TABLE event (id INT NOT NULL, location_id INT DEFAULT NULL, poster_id INT DEFAULT NULL, comedy_club_id INT NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, price DOUBLE PRECISION NOT NULL, duration VARCHAR(255) DEFAULT NULL, status BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3BAE0AA764D218E ON event (location_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3BAE0AA75BB66C05 ON event (poster_id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA76B856E60 ON event (comedy_club_id)');
        $this->addSql('COMMENT ON COLUMN event.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE event_comedian (event_id INT NOT NULL, comedian_id INT NOT NULL, PRIMARY KEY(event_id, comedian_id))');
        $this->addSql('CREATE INDEX IDX_C042CF1671F7E88B ON event_comedian (event_id)');
        $this->addSql('CREATE INDEX IDX_C042CF161D3228F ON event_comedian (comedian_id)');
        $this->addSql('CREATE TABLE image (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE invite (id INT NOT NULL, sent_to_establishment_id INT DEFAULT NULL, sent_to_comedian_id INT DEFAULT NULL, comedy_club_id INT DEFAULT NULL, status BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C7E210D732229249 ON invite (sent_to_establishment_id)');
        $this->addSql('CREATE INDEX IDX_C7E210D71FDD55C5 ON invite (sent_to_comedian_id)');
        $this->addSql('CREATE INDEX IDX_C7E210D76B856E60 ON invite (comedy_club_id)');
        $this->addSql('CREATE TABLE "like" (id INT NOT NULL, comedian_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AC6340B31D3228F ON "like" (comedian_id)');
        $this->addSql('CREATE TABLE spectator (id INT NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, phone_number VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE ticket (id INT NOT NULL, event_id INT NOT NULL, bought_by_id INT NOT NULL, spectator_id INT NOT NULL, price DOUBLE PRECISION NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, qr_code VARCHAR(2000) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_97A0ADA371F7E88B ON ticket (event_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3DEC6D6BA ON ticket (bought_by_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3523FB688 ON ticket (spectator_id)');
        $this->addSql('COMMENT ON COLUMN ticket.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE64D218E FOREIGN KEY (location_id) REFERENCES establishment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comedian ADD CONSTRAINT FK_86AE26C6292E8AE2 FOREIGN KEY (profile_picture_id) REFERENCES image (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comedian_spectator ADD CONSTRAINT FK_C9101BA11D3228F FOREIGN KEY (comedian_id) REFERENCES comedian (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comedian_spectator ADD CONSTRAINT FK_C9101BA1523FB688 FOREIGN KEY (spectator_id) REFERENCES spectator (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comedian_availability ADD CONSTRAINT FK_67F23D671D3228F FOREIGN KEY (comedian_id) REFERENCES comedian (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comedian_availability ADD CONSTRAINT FK_67F23D6761778466 FOREIGN KEY (availability_id) REFERENCES availability (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE establishment_availability ADD CONSTRAINT FK_CDE405BB8565851 FOREIGN KEY (establishment_id) REFERENCES establishment (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE establishment_availability ADD CONSTRAINT FK_CDE405BB61778466 FOREIGN KEY (availability_id) REFERENCES availability (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE establishment_equipment ADD CONSTRAINT FK_1BA4FDF08565851 FOREIGN KEY (establishment_id) REFERENCES establishment (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE establishment_equipment ADD CONSTRAINT FK_1BA4FDF0517FE9FE FOREIGN KEY (equipment_id) REFERENCES equipment (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA764D218E FOREIGN KEY (location_id) REFERENCES establishment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA75BB66C05 FOREIGN KEY (poster_id) REFERENCES image (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA76B856E60 FOREIGN KEY (comedy_club_id) REFERENCES comedy_club (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_comedian ADD CONSTRAINT FK_C042CF1671F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_comedian ADD CONSTRAINT FK_C042CF161D3228F FOREIGN KEY (comedian_id) REFERENCES comedian (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE invite ADD CONSTRAINT FK_C7E210D732229249 FOREIGN KEY (sent_to_establishment_id) REFERENCES establishment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE invite ADD CONSTRAINT FK_C7E210D71FDD55C5 FOREIGN KEY (sent_to_comedian_id) REFERENCES comedian (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE invite ADD CONSTRAINT FK_C7E210D76B856E60 FOREIGN KEY (comedy_club_id) REFERENCES comedy_club (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "like" ADD CONSTRAINT FK_AC6340B31D3228F FOREIGN KEY (comedian_id) REFERENCES comedian (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA371F7E88B FOREIGN KEY (event_id) REFERENCES event (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3DEC6D6BA FOREIGN KEY (bought_by_id) REFERENCES spectator (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3523FB688 FOREIGN KEY (spectator_id) REFERENCES spectator (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE availability_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE booking_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE comedian_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE comedy_club_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE equipment_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE establishment_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE event_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE image_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE invite_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "like_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE spectator_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ticket_id_seq CASCADE');
        $this->addSql('ALTER TABLE booking DROP CONSTRAINT FK_E00CEDDE71F7E88B');
        $this->addSql('ALTER TABLE booking DROP CONSTRAINT FK_E00CEDDE64D218E');
        $this->addSql('ALTER TABLE comedian DROP CONSTRAINT FK_86AE26C6292E8AE2');
        $this->addSql('ALTER TABLE comedian_spectator DROP CONSTRAINT FK_C9101BA11D3228F');
        $this->addSql('ALTER TABLE comedian_spectator DROP CONSTRAINT FK_C9101BA1523FB688');
        $this->addSql('ALTER TABLE comedian_availability DROP CONSTRAINT FK_67F23D671D3228F');
        $this->addSql('ALTER TABLE comedian_availability DROP CONSTRAINT FK_67F23D6761778466');
        $this->addSql('ALTER TABLE establishment_availability DROP CONSTRAINT FK_CDE405BB8565851');
        $this->addSql('ALTER TABLE establishment_availability DROP CONSTRAINT FK_CDE405BB61778466');
        $this->addSql('ALTER TABLE establishment_equipment DROP CONSTRAINT FK_1BA4FDF08565851');
        $this->addSql('ALTER TABLE establishment_equipment DROP CONSTRAINT FK_1BA4FDF0517FE9FE');
        $this->addSql('ALTER TABLE event DROP CONSTRAINT FK_3BAE0AA764D218E');
        $this->addSql('ALTER TABLE event DROP CONSTRAINT FK_3BAE0AA75BB66C05');
        $this->addSql('ALTER TABLE event DROP CONSTRAINT FK_3BAE0AA76B856E60');
        $this->addSql('ALTER TABLE event_comedian DROP CONSTRAINT FK_C042CF1671F7E88B');
        $this->addSql('ALTER TABLE event_comedian DROP CONSTRAINT FK_C042CF161D3228F');
        $this->addSql('ALTER TABLE invite DROP CONSTRAINT FK_C7E210D732229249');
        $this->addSql('ALTER TABLE invite DROP CONSTRAINT FK_C7E210D71FDD55C5');
        $this->addSql('ALTER TABLE invite DROP CONSTRAINT FK_C7E210D76B856E60');
        $this->addSql('ALTER TABLE "like" DROP CONSTRAINT FK_AC6340B31D3228F');
        $this->addSql('ALTER TABLE ticket DROP CONSTRAINT FK_97A0ADA371F7E88B');
        $this->addSql('ALTER TABLE ticket DROP CONSTRAINT FK_97A0ADA3DEC6D6BA');
        $this->addSql('ALTER TABLE ticket DROP CONSTRAINT FK_97A0ADA3523FB688');
        $this->addSql('DROP TABLE availability');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE comedian');
        $this->addSql('DROP TABLE comedian_spectator');
        $this->addSql('DROP TABLE comedian_availability');
        $this->addSql('DROP TABLE comedy_club');
        $this->addSql('DROP TABLE equipment');
        $this->addSql('DROP TABLE establishment');
        $this->addSql('DROP TABLE establishment_availability');
        $this->addSql('DROP TABLE establishment_equipment');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_comedian');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE invite');
        $this->addSql('DROP TABLE "like"');
        $this->addSql('DROP TABLE spectator');
        $this->addSql('DROP TABLE ticket');
    }
}
