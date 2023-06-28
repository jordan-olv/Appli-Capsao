<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230627142509 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE slider ADD event_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE slider ADD CONSTRAINT FK_CFC7100771F7E88B FOREIGN KEY (event_id) REFERENCES api_event (id)');
        $this->addSql('CREATE INDEX IDX_CFC7100771F7E88B ON slider (event_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE slider DROP FOREIGN KEY FK_CFC7100771F7E88B');
        $this->addSql('DROP INDEX IDX_CFC7100771F7E88B ON slider');
        $this->addSql('ALTER TABLE slider DROP event_id');
    }
}
