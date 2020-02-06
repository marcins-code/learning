<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200206062627 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE categories_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE articles_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE pages_ID_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE pages (ID INT NOT NULL, TITLE VARCHAR(255) NOT NULL, CONTENT_TYPE VARCHAR(255) NOT NULL, CONTENT TEXT NOT NULL, SLUG VARCHAR(255) DEFAULT NULL, PERMALINK VARCHAR(255) DEFAULT NULL, CREATED_ON TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, STATUS VARCHAR(255) NOT NULL, PARENT_PAGE_ID INT DEFAULT NULL, PRIMARY KEY(ID))');
        $this->addSql('CREATE INDEX IDX_2074E575541D4929 ON pages (PARENT_PAGE_ID)');
        $this->addSql('ALTER TABLE pages ADD CONSTRAINT FK_2074E575541D4929 FOREIGN KEY (PARENT_PAGE_ID) REFERENCES pages (ID) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE pages DROP CONSTRAINT FK_2074E575541D4929');
        $this->addSql('DROP SEQUENCE pages_ID_seq CASCADE');
        $this->addSql('CREATE SEQUENCE categories_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE articles_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('DROP TABLE pages');
    }
}
