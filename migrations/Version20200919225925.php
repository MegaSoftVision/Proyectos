<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200919225925 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categoria_encuesta (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, descripcion VARCHAR(255) NOT NULL, date_create DATE NOT NULL, INDEX IDX_83378951A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categoria_valor (id INT AUTO_INCREMENT NOT NULL, descripcion VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE valor_encuesta (valor_id INT NOT NULL, encuesta_id INT NOT NULL, INDEX IDX_7629ADB21EBE5BA7 (valor_id), INDEX IDX_7629ADB246844BA6 (encuesta_id), PRIMARY KEY(valor_id, encuesta_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categoria_encuesta ADD CONSTRAINT FK_83378951A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE valor_encuesta ADD CONSTRAINT FK_7629ADB21EBE5BA7 FOREIGN KEY (valor_id) REFERENCES valor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE valor_encuesta ADD CONSTRAINT FK_7629ADB246844BA6 FOREIGN KEY (encuesta_id) REFERENCES encuesta (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE encuesta CHANGE user_id user_id INT DEFAULT NULL, CHANGE banner banner VARCHAR(255) DEFAULT NULL, CHANGE instructivo instructivo VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE grupo CHANGE pregunta_id pregunta_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE registro CHANGE encuesta_id encuesta_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE respuesta CHANGE registro_id registro_id INT DEFAULT NULL, CHANGE encuesta_id encuesta_id INT DEFAULT NULL, CHANGE pregunta_id pregunta_id INT DEFAULT NULL, CHANGE seleccion_id seleccion_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE respuesta_grupo CHANGE registro_id registro_id INT DEFAULT NULL, CHANGE encuesta_id encuesta_id INT DEFAULT NULL, CHANGE pregunta_id pregunta_id INT DEFAULT NULL, CHANGE grupo_id grupo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE respuesta_simple CHANGE registro_id registro_id INT DEFAULT NULL, CHANGE encuesta_id encuesta_id INT DEFAULT NULL, CHANGE pregunta_id pregunta_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE seleccion CHANGE valor_id valor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE valor ADD categoria_id INT DEFAULT NULL, ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE valor ADD CONSTRAINT FK_2E8927283397707A FOREIGN KEY (categoria_id) REFERENCES categoria_valor (id)');
        $this->addSql('ALTER TABLE valor ADD CONSTRAINT FK_2E892728A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_2E8927283397707A ON valor (categoria_id)');
        $this->addSql('CREATE INDEX IDX_2E892728A76ED395 ON valor (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE valor DROP FOREIGN KEY FK_2E8927283397707A');
        $this->addSql('DROP TABLE categoria_encuesta');
        $this->addSql('DROP TABLE categoria_valor');
        $this->addSql('DROP TABLE valor_encuesta');
        $this->addSql('ALTER TABLE encuesta CHANGE user_id user_id INT DEFAULT NULL, CHANGE banner banner VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE instructivo instructivo VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE grupo CHANGE pregunta_id pregunta_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE registro CHANGE encuesta_id encuesta_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE respuesta CHANGE registro_id registro_id INT DEFAULT NULL, CHANGE encuesta_id encuesta_id INT DEFAULT NULL, CHANGE pregunta_id pregunta_id INT DEFAULT NULL, CHANGE seleccion_id seleccion_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE respuesta_grupo CHANGE registro_id registro_id INT DEFAULT NULL, CHANGE encuesta_id encuesta_id INT DEFAULT NULL, CHANGE pregunta_id pregunta_id INT DEFAULT NULL, CHANGE grupo_id grupo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE respuesta_simple CHANGE registro_id registro_id INT DEFAULT NULL, CHANGE encuesta_id encuesta_id INT DEFAULT NULL, CHANGE pregunta_id pregunta_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE seleccion CHANGE valor_id valor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE valor DROP FOREIGN KEY FK_2E892728A76ED395');
        $this->addSql('DROP INDEX IDX_2E8927283397707A ON valor');
        $this->addSql('DROP INDEX IDX_2E892728A76ED395 ON valor');
        $this->addSql('ALTER TABLE valor DROP categoria_id, DROP user_id');
    }
}
