<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190815154252 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE transaction ADD nom_envoyeur VARCHAR(255) DEFAULT NULL, ADD nom_beneficiaire VARCHAR(255) DEFAULT NULL, ADD tel_en VARCHAR(255) DEFAULT NULL, ADD tel_ben VARCHAR(255) DEFAULT NULL, DROP nom_en, DROP prenom_en, DROP nom_ben, DROP prenom_ben');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE transaction ADD nom_en VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD prenom_en VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD nom_ben VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD prenom_ben VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, DROP nom_envoyeur, DROP nom_beneficiaire, DROP tel_en, DROP tel_ben');
    }
}
