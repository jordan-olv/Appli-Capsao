<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230627082001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE default_radio DROP FOREIGN KEY FK_9604F01487B1CC');
        $this->addSql('DROP INDEX IDX_9604F01487B1CC ON default_radio');
        $this->addSql('ALTER TABLE default_radio CHANGE radio_id_id radio_id INT NOT NULL');
        $this->addSql('ALTER TABLE default_radio ADD CONSTRAINT FK_9604F015B94ADD2 FOREIGN KEY (radio_id) REFERENCES api_radio (id)');
        $this->addSql('CREATE INDEX IDX_9604F015B94ADD2 ON default_radio (radio_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE default_radio DROP FOREIGN KEY FK_9604F015B94ADD2');
        $this->addSql('DROP INDEX IDX_9604F015B94ADD2 ON default_radio');
        $this->addSql('ALTER TABLE default_radio CHANGE radio_id radio_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE default_radio ADD CONSTRAINT FK_9604F01487B1CC FOREIGN KEY (radio_id_id) REFERENCES api_radio (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_9604F01487B1CC ON default_radio (radio_id_id)');
    }
}
