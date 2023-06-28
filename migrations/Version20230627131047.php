<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230627131047 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE slider DROP FOREIGN KEY FK_CFC7100710FFB985');
        $this->addSql('ALTER TABLE slider DROP FOREIGN KEY FK_CFC71007272149B7');
        $this->addSql('ALTER TABLE slider DROP FOREIGN KEY FK_CFC710073594E659');
        $this->addSql('ALTER TABLE slider DROP FOREIGN KEY FK_CFC710078D28813C');
        $this->addSql('ALTER TABLE slider DROP FOREIGN KEY FK_CFC71007A843DEE0');
        $this->addSql('ALTER TABLE slider DROP FOREIGN KEY FK_CFC71007BAF6710E');
        $this->addSql('ALTER TABLE slider ADD CONSTRAINT FK_CFC7100710FFB985 FOREIGN KEY (choice4_id) REFERENCES api_event (id)');
        $this->addSql('ALTER TABLE slider ADD CONSTRAINT FK_CFC71007272149B7 FOREIGN KEY (choice1_id) REFERENCES api_event (id)');
        $this->addSql('ALTER TABLE slider ADD CONSTRAINT FK_CFC710073594E659 FOREIGN KEY (choice2_id) REFERENCES api_event (id)');
        $this->addSql('ALTER TABLE slider ADD CONSTRAINT FK_CFC710078D28813C FOREIGN KEY (choice3_id) REFERENCES api_event (id)');
        $this->addSql('ALTER TABLE slider ADD CONSTRAINT FK_CFC71007A843DEE0 FOREIGN KEY (choice5_id) REFERENCES api_event (id)');
        $this->addSql('ALTER TABLE slider ADD CONSTRAINT FK_CFC71007BAF6710E FOREIGN KEY (choice6_id) REFERENCES api_event (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE slider DROP FOREIGN KEY FK_CFC71007272149B7');
        $this->addSql('ALTER TABLE slider DROP FOREIGN KEY FK_CFC710073594E659');
        $this->addSql('ALTER TABLE slider DROP FOREIGN KEY FK_CFC710078D28813C');
        $this->addSql('ALTER TABLE slider DROP FOREIGN KEY FK_CFC7100710FFB985');
        $this->addSql('ALTER TABLE slider DROP FOREIGN KEY FK_CFC71007A843DEE0');
        $this->addSql('ALTER TABLE slider DROP FOREIGN KEY FK_CFC71007BAF6710E');
        $this->addSql('ALTER TABLE slider ADD CONSTRAINT FK_CFC71007272149B7 FOREIGN KEY (choice1_id) REFERENCES api_radio (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE slider ADD CONSTRAINT FK_CFC710073594E659 FOREIGN KEY (choice2_id) REFERENCES api_radio (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE slider ADD CONSTRAINT FK_CFC710078D28813C FOREIGN KEY (choice3_id) REFERENCES api_radio (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE slider ADD CONSTRAINT FK_CFC7100710FFB985 FOREIGN KEY (choice4_id) REFERENCES api_radio (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE slider ADD CONSTRAINT FK_CFC71007A843DEE0 FOREIGN KEY (choice5_id) REFERENCES api_radio (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE slider ADD CONSTRAINT FK_CFC71007BAF6710E FOREIGN KEY (choice6_id) REFERENCES api_radio (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
