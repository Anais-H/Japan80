<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201025184223 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE groupe_membre ADD actif TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE groupe_artiste RENAME INDEX idx_1d28aef5305371b TO IDX_5A60D2017A45358C');
        $this->addSql('ALTER TABLE groupe_artiste RENAME INDEX idx_1d28aef521d25844 TO IDX_5A60D20121D25844');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE groupe_artiste RENAME INDEX idx_5a60d20121d25844 TO IDX_1D28AEF521D25844');
        $this->addSql('ALTER TABLE groupe_artiste RENAME INDEX idx_5a60d2017a45358c TO IDX_1D28AEF5305371B');
        $this->addSql('ALTER TABLE groupe_membre DROP actif');
    }
}
