<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200920013302 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categoria_valor ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE categoria_valor ADD CONSTRAINT FK_2FBEEEEBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_2FBEEEEBA76ED395 ON categoria_valor (user_id)');
        $this->addSql('ALTER TABLE encuesta CHANGE user_id user_id INT DEFAULT NULL, CHANGE banner banner VARCHAR(255) DEFAULT NULL, CHANGE instructivo instructivo VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE grupo CHANGE pregunta_id pregunta_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE registro CHANGE encuesta_id encuesta_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE respuesta CHANGE registro_id registro_id INT DEFAULT NULL, CHANGE encuesta_id encuesta_id INT DEFAULT NULL, CHANGE pregunta_id pregunta_id INT DEFAULT NULL, CHANGE seleccion_id seleccion_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE respuesta_grupo CHANGE registro_id registro_id INT DEFAULT NULL, CHANGE encuesta_id encuesta_id INT DEFAULT NULL, CHANGE pregunta_id pregunta_id INT DEFAULT NULL, CHANGE grupo_id grupo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE respuesta_simple CHANGE registro_id registro_id INT DEFAULT NULL, CHANGE encuesta_id encuesta_id INT DEFAULT NULL, CHANGE pregunta_id pregunta_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE seleccion CHANGE valor_id valor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE valor CHANGE categoria_id categoria_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categoria_valor DROP FOREIGN KEY FK_2FBEEEEBA76ED395');
        $this->addSql('DROP INDEX IDX_2FBEEEEBA76ED395 ON categoria_valor');
        $this->addSql('ALTER TABLE categoria_valor DROP user_id');
        $this->addSql('ALTER TABLE encuesta CHANGE user_id user_id INT DEFAULT NULL, CHANGE banner banner VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE instructivo instructivo VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE grupo CHANGE pregunta_id pregunta_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE registro CHANGE encuesta_id encuesta_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE respuesta CHANGE registro_id registro_id INT DEFAULT NULL, CHANGE encuesta_id encuesta_id INT DEFAULT NULL, CHANGE pregunta_id pregunta_id INT DEFAULT NULL, CHANGE seleccion_id seleccion_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE respuesta_grupo CHANGE registro_id registro_id INT DEFAULT NULL, CHANGE encuesta_id encuesta_id INT DEFAULT NULL, CHANGE pregunta_id pregunta_id INT DEFAULT NULL, CHANGE grupo_id grupo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE respuesta_simple CHANGE registro_id registro_id INT DEFAULT NULL, CHANGE encuesta_id encuesta_id INT DEFAULT NULL, CHANGE pregunta_id pregunta_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE seleccion CHANGE valor_id valor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE valor CHANGE categoria_id categoria_id INT DEFAULT NULL');
    }
}
