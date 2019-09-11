<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190904235531 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE depot DROP FOREIGN KEY FK_47948BBC4B02CCBD');
        $this->addSql('DROP INDEX IDX_47948BBC4B02CCBD ON depot');
        $this->addSql('ALTER TABLE depot CHANGE cassier_id caisier_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE depot ADD CONSTRAINT FK_47948BBCA679E15E FOREIGN KEY (caisier_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_47948BBCA679E15E ON depot (caisier_id)');
        $this->addSql('ALTER TABLE partenaires CHANGE etat email VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE depot DROP FOREIGN KEY FK_47948BBCA679E15E');
        $this->addSql('DROP INDEX IDX_47948BBCA679E15E ON depot');
        $this->addSql('ALTER TABLE depot CHANGE caisier_id cassier_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE depot ADD CONSTRAINT FK_47948BBC4B02CCBD FOREIGN KEY (cassier_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_47948BBC4B02CCBD ON depot (cassier_id)');
        $this->addSql('ALTER TABLE partenaires CHANGE email etat VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
