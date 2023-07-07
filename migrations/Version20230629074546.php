<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230629074546 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE api_event (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, pub_date VARCHAR(255) NOT NULL, link VARCHAR(255) NOT NULL, guid VARCHAR(255) NOT NULL, url_img VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE api_podcast (id INT AUTO_INCREMENT NOT NULL, link VARCHAR(200) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE api_radio (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, ville VARCHAR(100) NOT NULL, flux_audio VARCHAR(200) NOT NULL, flux_txt VARCHAR(200) NOT NULL, code_postal VARCHAR(6) NOT NULL, coordonnees VARCHAR(50) DEFAULT NULL, rayon INT DEFAULT NULL, is_default TINYINT(1) NOT NULL, path VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_flux_rss (id INT AUTO_INCREMENT NOT NULL, link VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zone_texte (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(100) NOT NULL, texte LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP INDEX IDX_CFC710078D28813C ON slider');
        $this->addSql('DROP INDEX IDX_CFC7100710FFB985 ON slider');
        $this->addSql('DROP INDEX IDX_CFC71007272149B7 ON slider');
        $this->addSql('DROP INDEX IDX_CFC71007A843DEE0 ON slider');
        $this->addSql('DROP INDEX IDX_CFC710073594E659 ON slider');
        $this->addSql('DROP INDEX IDX_CFC71007BAF6710E ON slider');
        $this->addSql('ALTER TABLE slider ADD title VARCHAR(255) NOT NULL, ADD description LONGTEXT NOT NULL, ADD pub_date VARCHAR(255) NOT NULL, ADD link VARCHAR(255) NOT NULL, ADD guid VARCHAR(255) NOT NULL, ADD url_img VARCHAR(255) NOT NULL, ADD content LONGTEXT NOT NULL, DROP choice1_id, DROP choice2_id, DROP choice3_id, DROP choice4_id, DROP choice5_id, DROP choice6_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE api_event');
        $this->addSql('DROP TABLE api_podcast');
        $this->addSql('DROP TABLE api_radio');
        $this->addSql('DROP TABLE event_flux_rss');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE zone_texte');
        $this->addSql('ALTER TABLE slider ADD choice1_id INT DEFAULT NULL, ADD choice2_id INT DEFAULT NULL, ADD choice3_id INT DEFAULT NULL, ADD choice4_id INT DEFAULT NULL, ADD choice5_id INT DEFAULT NULL, ADD choice6_id INT DEFAULT NULL, DROP title, DROP description, DROP pub_date, DROP link, DROP guid, DROP url_img, DROP content');
        $this->addSql('CREATE INDEX IDX_CFC710078D28813C ON slider (choice3_id)');
        $this->addSql('CREATE INDEX IDX_CFC7100710FFB985 ON slider (choice4_id)');
        $this->addSql('CREATE INDEX IDX_CFC71007272149B7 ON slider (choice1_id)');
        $this->addSql('CREATE INDEX IDX_CFC71007A843DEE0 ON slider (choice5_id)');
        $this->addSql('CREATE INDEX IDX_CFC710073594E659 ON slider (choice2_id)');
        $this->addSql('CREATE INDEX IDX_CFC71007BAF6710E ON slider (choice6_id)');
    }
}
