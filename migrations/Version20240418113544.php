<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240418113544 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE invite (id INT NOT NULL, sent_to_establishment_id INT DEFAULT NULL, sent_to_comedian_id INT DEFAULT NULL, comedy_club_id INT DEFAULT NULL, event_id INT NOT NULL, status INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C7E210D732229249 ON invite (sent_to_establishment_id)');
        $this->addSql('CREATE INDEX IDX_C7E210D71FDD55C5 ON invite (sent_to_comedian_id)');
        $this->addSql('CREATE INDEX IDX_C7E210D76B856E60 ON invite (comedy_club_id)');
        $this->addSql('CREATE INDEX IDX_C7E210D771F7E88B ON invite (event_id)');
        $this->addSql('ALTER TABLE invite ADD CONSTRAINT FK_C7E210D732229249 FOREIGN KEY (sent_to_establishment_id) REFERENCES establishment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE invite ADD CONSTRAINT FK_C7E210D71FDD55C5 FOREIGN KEY (sent_to_comedian_id) REFERENCES comedian (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE invite ADD CONSTRAINT FK_C7E210D76B856E60 FOREIGN KEY (comedy_club_id) REFERENCES comedy_club (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE invite ADD CONSTRAINT FK_C7E210D771F7E88B FOREIGN KEY (event_id) REFERENCES event (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE invite DROP CONSTRAINT FK_C7E210D732229249');
        $this->addSql('ALTER TABLE invite DROP CONSTRAINT FK_C7E210D71FDD55C5');
        $this->addSql('ALTER TABLE invite DROP CONSTRAINT FK_C7E210D76B856E60');
        $this->addSql('ALTER TABLE invite DROP CONSTRAINT FK_C7E210D771F7E88B');
        $this->addSql('DROP TABLE invite');
    }
}
