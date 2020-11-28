<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200902212614 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE respuesta_simple (id INT AUTO_INCREMENT NOT NULL, registro_id INT DEFAULT NULL, encuesta_id INT DEFAULT NULL, pregunta_id INT DEFAULT NULL, descripcion VARCHAR(255) NOT NULL, INDEX IDX_7D00095B39C50FAE (registro_id), INDEX IDX_7D00095B46844BA6 (encuesta_id), INDEX IDX_7D00095B31A5801E (pregunta_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE respuesta_simple ADD CONSTRAINT FK_7D00095B39C50FAE FOREIGN KEY (registro_id) REFERENCES registro (id)');
        $this->addSql('ALTER TABLE respuesta_simple ADD CONSTRAINT FK_7D00095B46844BA6 FOREIGN KEY (encuesta_id) REFERENCES encuesta (id)');
        $this->addSql('ALTER TABLE respuesta_simple ADD CONSTRAINT FK_7D00095B31A5801E FOREIGN KEY (pregunta_id) REFERENCES pregunta (id)');
        $this->addSql('ALTER TABLE pregunta ADD type VARCHAR(255) NOT NULL, ADD posicion INT NOT NULL');
        $this->addSql('ALTER TABLE registro CHANGE encuesta_id encuesta_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE respuesta CHANGE registro_id registro_id INT DEFAULT NULL, CHANGE encuesta_id encuesta_id INT DEFAULT NULL, CHANGE pregunta_id pregunta_id INT DEFAULT NULL, CHANGE seleccion_id seleccion_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE seleccion CHANGE valor_id valor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE valor CHANGE encuesta_id encuesta_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE respuesta_simple');
        $this->addSql('ALTER TABLE pregunta DROP type, DROP posicion');
        $this->addSql('ALTER TABLE registro CHANGE encuesta_id encuesta_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE respuesta CHANGE registro_id registro_id INT DEFAULT NULL, CHANGE encuesta_id encuesta_id INT DEFAULT NULL, CHANGE pregunta_id pregunta_id INT DEFAULT NULL, CHANGE seleccion_id seleccion_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE seleccion CHANGE valor_id valor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
        $this->addSql('ALTER TABLE valor CHANGE encuesta_id encuesta_id INT DEFAULT NULL');
    }
}
