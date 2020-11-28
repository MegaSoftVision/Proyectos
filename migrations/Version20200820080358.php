<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200820080358 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE registro CHANGE encuesta_id encuesta_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE respuesta CHANGE registro_id registro_id INT DEFAULT NULL, CHANGE encuesta_id encuesta_id INT DEFAULT NULL, CHANGE pregunta_id pregunta_id INT DEFAULT NULL, CHANGE seleccion_id seleccion_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE seleccion CHANGE valor_id valor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE valor ADD encuesta_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE valor ADD CONSTRAINT FK_2E89272846844BA6 FOREIGN KEY (encuesta_id) REFERENCES encuesta (id)');
        $this->addSql('CREATE INDEX IDX_2E89272846844BA6 ON valor (encuesta_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE registro CHANGE encuesta_id encuesta_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE respuesta CHANGE registro_id registro_id INT DEFAULT NULL, CHANGE encuesta_id encuesta_id INT DEFAULT NULL, CHANGE pregunta_id pregunta_id INT DEFAULT NULL, CHANGE seleccion_id seleccion_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE seleccion CHANGE valor_id valor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
        $this->addSql('ALTER TABLE valor DROP FOREIGN KEY FK_2E89272846844BA6');
        $this->addSql('DROP INDEX IDX_2E89272846844BA6 ON valor');
        $this->addSql('ALTER TABLE valor DROP encuesta_id');
    }
}
