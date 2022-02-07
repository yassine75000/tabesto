<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220207101351 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tile ADD adventure_id INT DEFAULT NULL, ADD monster_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tile ADD CONSTRAINT FK_768FA90455CF40F9 FOREIGN KEY (adventure_id) REFERENCES adventure (id)');
        $this->addSql('ALTER TABLE tile ADD CONSTRAINT FK_768FA904C5FF1223 FOREIGN KEY (monster_id) REFERENCES monster (id)');
        $this->addSql('CREATE INDEX IDX_768FA90455CF40F9 ON tile (adventure_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_768FA904C5FF1223 ON tile (monster_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `character` CHANGE attack_value attack_value VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE monster CHANGE attack_value attack_value VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE armor_value armor_value VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE type type VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE tile DROP FOREIGN KEY FK_768FA90455CF40F9');
        $this->addSql('ALTER TABLE tile DROP FOREIGN KEY FK_768FA904C5FF1223');
        $this->addSql('DROP INDEX IDX_768FA90455CF40F9 ON tile');
        $this->addSql('DROP INDEX UNIQ_768FA904C5FF1223 ON tile');
        $this->addSql('ALTER TABLE tile DROP adventure_id, DROP monster_id, CHANGE type type VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE special_effects special_effects VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
