<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200209111209 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE categories ADD category_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE categories ALTER category TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF346689777D11E FOREIGN KEY (category_id_id) REFERENCES categories (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_3AF346689777D11E ON categories (category_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE categories DROP CONSTRAINT FK_3AF346689777D11E');
        $this->addSql('DROP INDEX IDX_3AF346689777D11E');
        $this->addSql('ALTER TABLE categories DROP category_id_id');
        $this->addSql('ALTER TABLE categories ALTER category TYPE VARCHAR(100)');
    }
}
