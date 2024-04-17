<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240417134815 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comedian ADD of_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comedian ADD CONSTRAINT FK_86AE26C65A1B2224 FOREIGN KEY (of_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_86AE26C65A1B2224 ON comedian (of_user_id)');
        $this->addSql('ALTER TABLE comedy_club ADD of_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comedy_club ADD CONSTRAINT FK_C7475D8F5A1B2224 FOREIGN KEY (of_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7475D8F5A1B2224 ON comedy_club (of_user_id)');
        $this->addSql('ALTER TABLE establishment ADD of_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE establishment ADD CONSTRAINT FK_DBEFB1EE5A1B2224 FOREIGN KEY (of_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DBEFB1EE5A1B2224 ON establishment (of_user_id)');
        $this->addSql('ALTER TABLE spectator ADD of_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE spectator ADD CONSTRAINT FK_54C715055A1B2224 FOREIGN KEY (of_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_54C715055A1B2224 ON spectator (of_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE spectator DROP CONSTRAINT FK_54C715055A1B2224');
        $this->addSql('DROP INDEX UNIQ_54C715055A1B2224');
        $this->addSql('ALTER TABLE spectator DROP of_user_id');
        $this->addSql('ALTER TABLE comedian DROP CONSTRAINT FK_86AE26C65A1B2224');
        $this->addSql('DROP INDEX UNIQ_86AE26C65A1B2224');
        $this->addSql('ALTER TABLE comedian DROP of_user_id');
        $this->addSql('ALTER TABLE comedy_club DROP CONSTRAINT FK_C7475D8F5A1B2224');
        $this->addSql('DROP INDEX UNIQ_C7475D8F5A1B2224');
        $this->addSql('ALTER TABLE comedy_club DROP of_user_id');
        $this->addSql('ALTER TABLE establishment DROP CONSTRAINT FK_DBEFB1EE5A1B2224');
        $this->addSql('DROP INDEX UNIQ_DBEFB1EE5A1B2224');
        $this->addSql('ALTER TABLE establishment DROP of_user_id');
    }
}
