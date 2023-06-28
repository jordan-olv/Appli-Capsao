<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230627131811 extends AbstractMigration
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
        $this->addSql('DROP TABLE slider');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE slider (id INT AUTO_INCREMENT NOT NULL, choice1_id INT DEFAULT NULL, choice2_id INT DEFAULT NULL, choice3_id INT DEFAULT NULL, choice4_id INT DEFAULT NULL, choice5_id INT DEFAULT NULL, choice6_id INT DEFAULT NULL, INDEX IDX_CFC7100710FFB985 (choice4_id), INDEX IDX_CFC71007272149B7 (choice1_id), INDEX IDX_CFC710073594E659 (choice2_id), INDEX IDX_CFC710078D28813C (choice3_id), INDEX IDX_CFC71007A843DEE0 (choice5_id), INDEX IDX_CFC71007BAF6710E (choice6_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE slider ADD CONSTRAINT FK_CFC7100710FFB985 FOREIGN KEY (choice4_id) REFERENCES api_event (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE slider ADD CONSTRAINT FK_CFC71007272149B7 FOREIGN KEY (choice1_id) REFERENCES api_event (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE slider ADD CONSTRAINT FK_CFC710073594E659 FOREIGN KEY (choice2_id) REFERENCES api_event (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE slider ADD CONSTRAINT FK_CFC710078D28813C FOREIGN KEY (choice3_id) REFERENCES api_event (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE slider ADD CONSTRAINT FK_CFC71007A843DEE0 FOREIGN KEY (choice5_id) REFERENCES api_event (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE slider ADD CONSTRAINT FK_CFC71007BAF6710E FOREIGN KEY (choice6_id) REFERENCES api_event (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
