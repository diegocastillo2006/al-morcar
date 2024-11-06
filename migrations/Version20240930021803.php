<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240930021803 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE administrador (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(10) NOT NULL, apellido VARCHAR(10) NOT NULL, dni VARCHAR(8) NOT NULL, telefono VARCHAR(20) NOT NULL, cargo VARCHAR(15) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE alumno (id INT AUTO_INCREMENT NOT NULL, usuario_id INT NOT NULL, nombre VARCHAR(20) NOT NULL, apellido VARCHAR(20) NOT NULL, dni VARCHAR(8) NOT NULL, celular VARCHAR(20) NOT NULL, anio_curso VARCHAR(5) NOT NULL, domicilio VARCHAR(20) NOT NULL, localidad VARCHAR(20) NOT NULL, UNIQUE INDEX UNIQ_1435D52DDB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE libro (id INT AUTO_INCREMENT NOT NULL, titulo VARCHAR(50) NOT NULL, autor VARCHAR(20) NOT NULL, año INT NOT NULL, genero VARCHAR(20) NOT NULL, editorial VARCHAR(50) NOT NULL, num_pag VARCHAR(4) NOT NULL, isbn VARCHAR(13) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prestamo (id INT AUTO_INCREMENT NOT NULL, libro_id INT NOT NULL, usuario_id INT NOT NULL, fecha_prestamo DATE NOT NULL, fecha_devolucion DATE NOT NULL, estado VARCHAR(20) NOT NULL, INDEX IDX_F4D874F2C0238522 (libro_id), INDEX IDX_F4D874F2DB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profesor (id INT AUTO_INCREMENT NOT NULL, usuario_id INT NOT NULL, nombre VARCHAR(20) NOT NULL, apellido VARCHAR(20) NOT NULL, dni VARCHAR(8) NOT NULL, celular VARCHAR(15) NOT NULL, domicilio VARCHAR(20) NOT NULL, localidad VARCHAR(20) NOT NULL, UNIQUE INDEX UNIQ_5B7406D9DB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE alumno ADD CONSTRAINT FK_1435D52DDB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE prestamo ADD CONSTRAINT FK_F4D874F2C0238522 FOREIGN KEY (libro_id) REFERENCES libro (id)');
        $this->addSql('ALTER TABLE prestamo ADD CONSTRAINT FK_F4D874F2DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE profesor ADD CONSTRAINT FK_5B7406D9DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE alumno DROP FOREIGN KEY FK_1435D52DDB38439E');
        $this->addSql('ALTER TABLE prestamo DROP FOREIGN KEY FK_F4D874F2C0238522');
        $this->addSql('ALTER TABLE prestamo DROP FOREIGN KEY FK_F4D874F2DB38439E');
        $this->addSql('ALTER TABLE profesor DROP FOREIGN KEY FK_5B7406D9DB38439E');
        $this->addSql('DROP TABLE administrador');
        $this->addSql('DROP TABLE alumno');
        $this->addSql('DROP TABLE libro');
        $this->addSql('DROP TABLE prestamo');
        $this->addSql('DROP TABLE profesor');
        $this->addSql('DROP TABLE usuario');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
