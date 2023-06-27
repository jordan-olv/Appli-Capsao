<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230627081901 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE default_radio (id INT AUTO_INCREMENT NOT NULL, radio_id_id INT NOT NULL, INDEX IDX_9604F01487B1CC (radio_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE default_radio ADD CONSTRAINT FK_9604F01487B1CC FOREIGN KEY (radio_id_id) REFERENCES api_radio (id)');
        $this->addSql('ALTER TABLE api_radio DROP is_default');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE default_radio DROP FOREIGN KEY FK_9604F01487B1CC');
        $this->addSql('DROP TABLE default_radio');
        $this->addSql('ALTER TABLE api_radio ADD is_default TINYINT(1) NOT NULL');
    }
}
