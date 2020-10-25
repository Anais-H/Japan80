<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201025174842 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE anime_anime_genre');
        $this->addSql('DROP TABLE anime_genre_anime');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE anime_anime_genre (anime_id INT NOT NULL, anime_genre_id INT NOT NULL, INDEX IDX_F249F539794BBE89 (anime_id), INDEX IDX_F249F539A7560135 (anime_genre_id), PRIMARY KEY(anime_id, anime_genre_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE anime_genre_anime (anime_genre_id INT NOT NULL, anime_id INT NOT NULL, INDEX IDX_B3B2E079794BBE89 (anime_id), INDEX IDX_B3B2E079A7560135 (anime_genre_id), PRIMARY KEY(anime_genre_id, anime_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE anime_anime_genre ADD CONSTRAINT FK_F249F539794BBE89 FOREIGN KEY (anime_id) REFERENCES anime (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE anime_anime_genre ADD CONSTRAINT FK_F249F539A7560135 FOREIGN KEY (anime_genre_id) REFERENCES anime_genre (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE anime_genre_anime ADD CONSTRAINT FK_B3B2E079794BBE89 FOREIGN KEY (anime_id) REFERENCES anime (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE anime_genre_anime ADD CONSTRAINT FK_B3B2E079A7560135 FOREIGN KEY (anime_genre_id) REFERENCES anime_genre (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
