<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250321144937 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE creneau (id INT AUTO_INCREMENT NOT NULL, employe_id INT NOT NULL, tache_id INT NOT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, INDEX IDX_F9668B5F1B65292 (employe_id), INDEX IDX_F9668B5FD2235D39 (tache_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employe (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, role INT NOT NULL, contrat VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, actif TINYINT(1) NOT NULL, date_arrivee DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employe_projet (employe_id INT NOT NULL, projet_id INT NOT NULL, INDEX IDX_3E3387501B65292 (employe_id), INDEX IDX_3E338750C18272 (projet_id), PRIMARY KEY(employe_id, projet_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projet (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, archive TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE statut (id INT AUTO_INCREMENT NOT NULL, projet_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, INDEX IDX_E564F0BFC18272 (projet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tache (id INT AUTO_INCREMENT NOT NULL, projet_id INT NOT NULL, statut_id INT NOT NULL, employe_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, deadline DATE DEFAULT NULL, INDEX IDX_93872075C18272 (projet_id), INDEX IDX_93872075F6203804 (statut_id), INDEX IDX_938720751B65292 (employe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, projet_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, INDEX IDX_389B783C18272 (projet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_tache (tag_id INT NOT NULL, tache_id INT NOT NULL, INDEX IDX_B16B3973BAD26311 (tag_id), INDEX IDX_B16B3973D2235D39 (tache_id), PRIMARY KEY(tag_id, tache_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE creneau ADD CONSTRAINT FK_F9668B5F1B65292 FOREIGN KEY (employe_id) REFERENCES employe (id)');
        $this->addSql('ALTER TABLE creneau ADD CONSTRAINT FK_F9668B5FD2235D39 FOREIGN KEY (tache_id) REFERENCES tache (id)');
        $this->addSql('ALTER TABLE employe_projet ADD CONSTRAINT FK_3E3387501B65292 FOREIGN KEY (employe_id) REFERENCES employe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE employe_projet ADD CONSTRAINT FK_3E338750C18272 FOREIGN KEY (projet_id) REFERENCES projet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE statut ADD CONSTRAINT FK_E564F0BFC18272 FOREIGN KEY (projet_id) REFERENCES projet (id)');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_93872075C18272 FOREIGN KEY (projet_id) REFERENCES projet (id)');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_93872075F6203804 FOREIGN KEY (statut_id) REFERENCES statut (id)');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_938720751B65292 FOREIGN KEY (employe_id) REFERENCES employe (id)');
        $this->addSql('ALTER TABLE tag ADD CONSTRAINT FK_389B783C18272 FOREIGN KEY (projet_id) REFERENCES projet (id)');
        $this->addSql('ALTER TABLE tag_tache ADD CONSTRAINT FK_B16B3973BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_tache ADD CONSTRAINT FK_B16B3973D2235D39 FOREIGN KEY (tache_id) REFERENCES tache (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE creneau DROP FOREIGN KEY FK_F9668B5F1B65292');
        $this->addSql('ALTER TABLE creneau DROP FOREIGN KEY FK_F9668B5FD2235D39');
        $this->addSql('ALTER TABLE employe_projet DROP FOREIGN KEY FK_3E3387501B65292');
        $this->addSql('ALTER TABLE employe_projet DROP FOREIGN KEY FK_3E338750C18272');
        $this->addSql('ALTER TABLE statut DROP FOREIGN KEY FK_E564F0BFC18272');
        $this->addSql('ALTER TABLE tache DROP FOREIGN KEY FK_93872075C18272');
        $this->addSql('ALTER TABLE tache DROP FOREIGN KEY FK_93872075F6203804');
        $this->addSql('ALTER TABLE tache DROP FOREIGN KEY FK_938720751B65292');
        $this->addSql('ALTER TABLE tag DROP FOREIGN KEY FK_389B783C18272');
        $this->addSql('ALTER TABLE tag_tache DROP FOREIGN KEY FK_B16B3973BAD26311');
        $this->addSql('ALTER TABLE tag_tache DROP FOREIGN KEY FK_B16B3973D2235D39');
        $this->addSql('DROP TABLE creneau');
        $this->addSql('DROP TABLE employe');
        $this->addSql('DROP TABLE employe_projet');
        $this->addSql('DROP TABLE projet');
        $this->addSql('DROP TABLE statut');
        $this->addSql('DROP TABLE tache');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE tag_tache');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
