<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200809001210 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE encuesta (id INT AUTO_INCREMENT NOT NULL, descripcion VARCHAR(255) NOT NULL, date_create DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE encuesta_pregunta (encuesta_id INT NOT NULL, pregunta_id INT NOT NULL, INDEX IDX_3C1707EE46844BA6 (encuesta_id), INDEX IDX_3C1707EE31A5801E (pregunta_id), PRIMARY KEY(encuesta_id, pregunta_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pregunta (id INT AUTO_INCREMENT NOT NULL, descripcion VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pregunta_seleccion (pregunta_id INT NOT NULL, seleccion_id INT NOT NULL, INDEX IDX_5D6E4DF631A5801E (pregunta_id), INDEX IDX_5D6E4DF646F75C38 (seleccion_id), PRIMARY KEY(pregunta_id, seleccion_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE registro (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, pais VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE respuesta (id INT AUTO_INCREMENT NOT NULL, registro_id INT DEFAULT NULL, encuesta_id INT DEFAULT NULL, pregunta_id INT DEFAULT NULL, seleccion_id INT DEFAULT NULL, INDEX IDX_6C6EC5EE39C50FAE (registro_id), INDEX IDX_6C6EC5EE46844BA6 (encuesta_id), INDEX IDX_6C6EC5EE31A5801E (pregunta_id), INDEX IDX_6C6EC5EE46F75C38 (seleccion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE seleccion (id INT AUTO_INCREMENT NOT NULL, valor_id INT DEFAULT NULL, descripcion VARCHAR(255) NOT NULL, INDEX IDX_5B6B63F11EBE5BA7 (valor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE valor (id INT AUTO_INCREMENT NOT NULL, descripcion VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE encuesta_pregunta ADD CONSTRAINT FK_3C1707EE46844BA6 FOREIGN KEY (encuesta_id) REFERENCES encuesta (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE encuesta_pregunta ADD CONSTRAINT FK_3C1707EE31A5801E FOREIGN KEY (pregunta_id) REFERENCES pregunta (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pregunta_seleccion ADD CONSTRAINT FK_5D6E4DF631A5801E FOREIGN KEY (pregunta_id) REFERENCES pregunta (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pregunta_seleccion ADD CONSTRAINT FK_5D6E4DF646F75C38 FOREIGN KEY (seleccion_id) REFERENCES seleccion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE respuesta ADD CONSTRAINT FK_6C6EC5EE39C50FAE FOREIGN KEY (registro_id) REFERENCES registro (id)');
        $this->addSql('ALTER TABLE respuesta ADD CONSTRAINT FK_6C6EC5EE46844BA6 FOREIGN KEY (encuesta_id) REFERENCES encuesta (id)');
        $this->addSql('ALTER TABLE respuesta ADD CONSTRAINT FK_6C6EC5EE31A5801E FOREIGN KEY (pregunta_id) REFERENCES pregunta (id)');
        $this->addSql('ALTER TABLE respuesta ADD CONSTRAINT FK_6C6EC5EE46F75C38 FOREIGN KEY (seleccion_id) REFERENCES seleccion (id)');
        $this->addSql('ALTER TABLE seleccion ADD CONSTRAINT FK_5B6B63F11EBE5BA7 FOREIGN KEY (valor_id) REFERENCES valor (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE encuesta_pregunta DROP FOREIGN KEY FK_3C1707EE46844BA6');
        $this->addSql('ALTER TABLE respuesta DROP FOREIGN KEY FK_6C6EC5EE46844BA6');
        $this->addSql('ALTER TABLE encuesta_pregunta DROP FOREIGN KEY FK_3C1707EE31A5801E');
        $this->addSql('ALTER TABLE pregunta_seleccion DROP FOREIGN KEY FK_5D6E4DF631A5801E');
        $this->addSql('ALTER TABLE respuesta DROP FOREIGN KEY FK_6C6EC5EE31A5801E');
        $this->addSql('ALTER TABLE respuesta DROP FOREIGN KEY FK_6C6EC5EE39C50FAE');
        $this->addSql('ALTER TABLE pregunta_seleccion DROP FOREIGN KEY FK_5D6E4DF646F75C38');
        $this->addSql('ALTER TABLE respuesta DROP FOREIGN KEY FK_6C6EC5EE46F75C38');
        $this->addSql('ALTER TABLE seleccion DROP FOREIGN KEY FK_5B6B63F11EBE5BA7');
        $this->addSql('DROP TABLE encuesta');
        $this->addSql('DROP TABLE encuesta_pregunta');
        $this->addSql('DROP TABLE pregunta');
        $this->addSql('DROP TABLE pregunta_seleccion');
        $this->addSql('DROP TABLE registro');
        $this->addSql('DROP TABLE respuesta');
        $this->addSql('DROP TABLE seleccion');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE valor');
    }
}
