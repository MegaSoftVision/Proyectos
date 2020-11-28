<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200908031205 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE grupo (id INT AUTO_INCREMENT NOT NULL, pregunta_id INT DEFAULT NULL, descripcion VARCHAR(255) NOT NULL, INDEX IDX_8C0E9BD331A5801E (pregunta_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE grupo ADD CONSTRAINT FK_8C0E9BD331A5801E FOREIGN KEY (pregunta_id) REFERENCES pregunta (id)');
        $this->addSql('ALTER TABLE encuesta CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE encuesta RENAME INDEX idx_b25b68413b0f2f2b TO IDX_B25B6841A76ED395');
        $this->addSql('ALTER TABLE registro CHANGE encuesta_id encuesta_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE respuesta CHANGE registro_id registro_id INT DEFAULT NULL, CHANGE encuesta_id encuesta_id INT DEFAULT NULL, CHANGE pregunta_id pregunta_id INT DEFAULT NULL, CHANGE seleccion_id seleccion_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE respuesta_simple CHANGE registro_id registro_id INT DEFAULT NULL, CHANGE encuesta_id encuesta_id INT DEFAULT NULL, CHANGE pregunta_id pregunta_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE seleccion CHANGE valor_id valor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE valor CHANGE encuesta_id encuesta_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE grupo');
        $this->addSql('ALTER TABLE encuesta CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE encuesta RENAME INDEX idx_b25b6841a76ed395 TO IDX_B25B68413B0F2F2B');
        $this->addSql('ALTER TABLE registro CHANGE encuesta_id encuesta_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE respuesta CHANGE registro_id registro_id INT DEFAULT NULL, CHANGE encuesta_id encuesta_id INT DEFAULT NULL, CHANGE pregunta_id pregunta_id INT DEFAULT NULL, CHANGE seleccion_id seleccion_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE respuesta_simple CHANGE registro_id registro_id INT DEFAULT NULL, CHANGE encuesta_id encuesta_id INT DEFAULT NULL, CHANGE pregunta_id pregunta_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE seleccion CHANGE valor_id valor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
        $this->addSql('ALTER TABLE valor CHANGE encuesta_id encuesta_id INT DEFAULT NULL');
    }
}
