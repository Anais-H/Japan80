<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201016111228 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE groupe_membre (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) DEFAULT NULL, poste VARCHAR(100) DEFAULT NULL, nom_jp VARCHAR(20) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupes (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, nom_jp VARCHAR(20) DEFAULT NULL, date_debut SMALLINT NOT NULL, date_fin SMALLINT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupes_artiste (groupes_id INT NOT NULL, artiste_id INT NOT NULL, INDEX IDX_1D28AEF5305371B (groupes_id), INDEX IDX_1D28AEF521D25844 (artiste_id), PRIMARY KEY(groupes_id, artiste_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE groupes_artiste ADD CONSTRAINT FK_1D28AEF5305371B FOREIGN KEY (groupes_id) REFERENCES groupes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupes_artiste ADD CONSTRAINT FK_1D28AEF521D25844 FOREIGN KEY (artiste_id) REFERENCES artiste (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE anime ADD artistes_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE anime ADD CONSTRAINT FK_1304594296E1EAF4 FOREIGN KEY (artistes_id) REFERENCES artiste (id)');
        $this->addSql('CREATE INDEX IDX_1304594296E1EAF4 ON anime (artistes_id)');
        $this->addSql('ALTER TABLE anime DROP COLUMN realisateur');
        $this->addSql('ALTER TABLE anime DROP COLUMN scenariste');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE groupes_artiste DROP FOREIGN KEY FK_1D28AEF5305371B');
        $this->addSql('DROP TABLE groupes');
        $this->addSql('DROP TABLE groupes_artiste');
        $this->addSql('DROP TABLE groupe_membre');
        $this->addSql('ALTER TABLE anime DROP FOREIGN KEY FK_1304594296E1EAF4');
        $this->addSql('DROP INDEX IDX_1304594296E1EAF4 ON anime');
        $this->addSql('ALTER TABLE anime DROP artistes_id');
    }
}
