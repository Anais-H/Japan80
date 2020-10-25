<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201016112610 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE anime_genre (id INT AUTO_INCREMENT NOT NULL, genre VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE anime_genre_anime (anime_genre_id INT NOT NULL, anime_id INT NOT NULL, INDEX IDX_B3B2E079A7560135 (anime_genre_id), INDEX IDX_B3B2E079794BBE89 (anime_id), PRIMARY KEY(anime_genre_id, anime_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE anime_genre_anime ADD CONSTRAINT FK_B3B2E079A7560135 FOREIGN KEY (anime_genre_id) REFERENCES anime_genre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE anime_genre_anime ADD CONSTRAINT FK_B3B2E079794BBE89 FOREIGN KEY (anime_id) REFERENCES anime (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE anime DROP FOREIGN KEY FK_1304594296E1EAF4');
        $this->addSql('DROP INDEX IDX_1304594296E1EAF4 ON anime');
        $this->addSql('ALTER TABLE anime ADD realisateur VARCHAR(50) DEFAULT NULL, ADD scenariste VARCHAR(50) DEFAULT NULL, DROP artistes_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE anime_genre_anime DROP FOREIGN KEY FK_B3B2E079A7560135');
        $this->addSql('DROP TABLE anime_genre');
        $this->addSql('DROP TABLE anime_genre_anime');
        $this->addSql('ALTER TABLE anime ADD artistes_id INT DEFAULT NULL, DROP realisateur, DROP scenariste');
        $this->addSql('ALTER TABLE anime ADD CONSTRAINT FK_1304594296E1EAF4 FOREIGN KEY (artistes_id) REFERENCES artiste (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_1304594296E1EAF4 ON anime (artistes_id)');
    }
}
