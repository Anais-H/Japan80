<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201025174247 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE anime_artiste (anime_id INT NOT NULL, artiste_id INT NOT NULL, INDEX IDX_896B1282794BBE89 (anime_id), INDEX IDX_896B128221D25844 (artiste_id), PRIMARY KEY(anime_id, artiste_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE anime_genre_anime (anime_genre_id INT NOT NULL, anime_id INT NOT NULL, INDEX IDX_B3B2E079A7560135 (anime_genre_id), INDEX IDX_B3B2E079794BBE89 (anime_id), PRIMARY KEY(anime_genre_id, anime_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE anime_artiste ADD CONSTRAINT FK_896B1282794BBE89 FOREIGN KEY (anime_id) REFERENCES anime (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE anime_artiste ADD CONSTRAINT FK_896B128221D25844 FOREIGN KEY (artiste_id) REFERENCES artiste (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE anime_genre_anime ADD CONSTRAINT FK_B3B2E079A7560135 FOREIGN KEY (anime_genre_id) REFERENCES anime_genre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE anime_genre_anime ADD CONSTRAINT FK_B3B2E079794BBE89 FOREIGN KEY (anime_id) REFERENCES anime (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE anime_artiste');
        $this->addSql('DROP TABLE anime_genre_anime');
    }
}
