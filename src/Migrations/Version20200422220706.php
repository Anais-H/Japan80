<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200422220706 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, artiste_id_id INT NOT NULL, banner_playlist VARCHAR(400) DEFAULT NULL, description VARCHAR(1000) NOT NULL, date_derniere_modification DATETIME DEFAULT NULL, statut VARCHAR(20) DEFAULT NULL, UNIQUE INDEX UNIQ_23A0E66B6D84A9 (artiste_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE album (id INT AUTO_INCREMENT NOT NULL, artiste_id INT NOT NULL, type VARCHAR(20) NOT NULL, couverture VARCHAR(255) DEFAULT NULL, titre VARCHAR(100) NOT NULL, date_sortie SMALLINT NOT NULL, favori TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_39986E43FF7747B4 (titre), INDEX IDX_39986E4321D25844 (artiste_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artiste (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, nom_jp VARCHAR(50) NOT NULL, date_de_naissance DATE NOT NULL, genre VARCHAR(10) NOT NULL, date_debut INT NOT NULL, date_fin INT DEFAULT NULL, courte_description VARCHAR(255) DEFAULT NULL, favori TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_9C07354F6C6E55B5 (nom), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66B6D84A9 FOREIGN KEY (artiste_id_id) REFERENCES artiste (id)');
        $this->addSql('ALTER TABLE album ADD CONSTRAINT FK_39986E4321D25844 FOREIGN KEY (artiste_id) REFERENCES artiste (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66B6D84A9');
        $this->addSql('ALTER TABLE album DROP FOREIGN KEY FK_39986E4321D25844');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE album');
        $this->addSql('DROP TABLE artiste');
    }
}
