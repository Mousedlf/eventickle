<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240418134833 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE "order_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "order" (id INT NOT NULL, made_by_id INT NOT NULL, number_of_persons INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F529939890B9D269 ON "order" (made_by_id)');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT FK_F529939890B9D269 FOREIGN KEY (made_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ticket ADD of_order_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ticket ADD used BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA331049BD3 FOREIGN KEY (of_order_id) REFERENCES "order" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_97A0ADA331049BD3 ON ticket (of_order_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE ticket DROP CONSTRAINT FK_97A0ADA331049BD3');
        $this->addSql('DROP SEQUENCE "order_id_seq" CASCADE');
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT FK_F529939890B9D269');
        $this->addSql('DROP TABLE "order"');
        $this->addSql('DROP INDEX IDX_97A0ADA331049BD3');
        $this->addSql('ALTER TABLE ticket DROP of_order_id');
        $this->addSql('ALTER TABLE ticket DROP used');
    }
}
