<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200209111508 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE categories DROP CONSTRAINT fk_3af34668727aca70');
        $this->addSql('ALTER TABLE categories DROP CONSTRAINT fk_3af346689777d11e');
        $this->addSql('DROP INDEX idx_3af34668727aca70');
        $this->addSql('DROP INDEX idx_3af346689777d11e');
        $this->addSql('ALTER TABLE categories DROP parent_id');
        $this->addSql('ALTER TABLE categories DROP category_id_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE categories ADD parent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE categories ADD category_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT fk_3af34668727aca70 FOREIGN KEY (parent_id) REFERENCES categories (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT fk_3af346689777d11e FOREIGN KEY (category_id_id) REFERENCES categories (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_3af34668727aca70 ON categories (parent_id)');
        $this->addSql('CREATE INDEX idx_3af346689777d11e ON categories (category_id_id)');
    }
}
