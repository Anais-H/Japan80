<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201025190103 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE groupe_membre ADD artiste_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE groupe_membre ADD CONSTRAINT FK_9D8A071321D25844 FOREIGN KEY (artiste_id) REFERENCES artiste (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9D8A071321D25844 ON groupe_membre (artiste_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE groupe_membre DROP FOREIGN KEY FK_9D8A071321D25844');
        $this->addSql('DROP INDEX UNIQ_9D8A071321D25844 ON groupe_membre');
        $this->addSql('ALTER TABLE groupe_membre DROP artiste_id');
    }
}
