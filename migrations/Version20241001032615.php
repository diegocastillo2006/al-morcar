<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241001032615 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE alumno DROP FOREIGN KEY FK_1435D52DDB38439E');
        $this->addSql('ALTER TABLE alumno ADD CONSTRAINT FK_1435D52DDB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE profesor DROP FOREIGN KEY FK_5B7406D9DB38439E');
        $this->addSql('ALTER TABLE profesor ADD CONSTRAINT FK_5B7406D9DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE alumno DROP FOREIGN KEY FK_1435D52DDB38439E');
        $this->addSql('ALTER TABLE alumno ADD CONSTRAINT FK_1435D52DDB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE profesor DROP FOREIGN KEY FK_5B7406D9DB38439E');
        $this->addSql('ALTER TABLE profesor ADD CONSTRAINT FK_5B7406D9DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
