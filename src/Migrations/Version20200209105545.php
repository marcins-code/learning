<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200209105545 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE users_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tags_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE articles_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE categories_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE pages_ID_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE users (id INT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, is_enabled BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9F85E0677 ON users (username)');
        $this->addSql('CREATE TABLE tags (id INT NOT NULL, tag VARCHAR(100) NOT NULL, is_enabled BOOLEAN DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE tags_articles (tags_id INT NOT NULL, articles_id INT NOT NULL, PRIMARY KEY(tags_id, articles_id))');
        $this->addSql('CREATE INDEX IDX_D54BAD718D7B4FB4 ON tags_articles (tags_id)');
        $this->addSql('CREATE INDEX IDX_D54BAD711EBAF6CC ON tags_articles (articles_id)');
        $this->addSql('CREATE TABLE articles (id INT NOT NULL, category_id_id INT DEFAULT NULL, user_id_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, content TEXT DEFAULT NULL, slug VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, is_published BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_BFDD31689777D11E ON articles (category_id_id)');
        $this->addSql('CREATE INDEX IDX_BFDD31689D86650F ON articles (user_id_id)');
        $this->addSql('CREATE TABLE categories (id INT NOT NULL, parent_id INT DEFAULT NULL, category VARCHAR(100) NOT NULL, slug VARCHAR(100) NOT NULL, is_enabled BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3AF34668727ACA70 ON categories (parent_id)');
        $this->addSql('CREATE TABLE pages (ID INT NOT NULL, TITLE VARCHAR(255) NOT NULL, CONTENT_TYPE VARCHAR(255) NOT NULL, CONTENT TEXT NOT NULL, SLUG VARCHAR(255) DEFAULT NULL, PERMALINK VARCHAR(255) DEFAULT NULL, CREATED_ON TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, STATUS VARCHAR(255) NOT NULL, PARENT_PAGE_ID INT DEFAULT NULL, PRIMARY KEY(ID))');
        $this->addSql('CREATE INDEX IDX_2074E575541D4929 ON pages (PARENT_PAGE_ID)');
        $this->addSql('ALTER TABLE tags_articles ADD CONSTRAINT FK_D54BAD718D7B4FB4 FOREIGN KEY (tags_id) REFERENCES tags (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tags_articles ADD CONSTRAINT FK_D54BAD711EBAF6CC FOREIGN KEY (articles_id) REFERENCES articles (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD31689777D11E FOREIGN KEY (category_id_id) REFERENCES categories (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD31689D86650F FOREIGN KEY (user_id_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF34668727ACA70 FOREIGN KEY (parent_id) REFERENCES categories (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE pages ADD CONSTRAINT FK_2074E575541D4929 FOREIGN KEY (PARENT_PAGE_ID) REFERENCES pages (ID) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE articles DROP CONSTRAINT FK_BFDD31689D86650F');
        $this->addSql('ALTER TABLE tags_articles DROP CONSTRAINT FK_D54BAD718D7B4FB4');
        $this->addSql('ALTER TABLE tags_articles DROP CONSTRAINT FK_D54BAD711EBAF6CC');
        $this->addSql('ALTER TABLE articles DROP CONSTRAINT FK_BFDD31689777D11E');
        $this->addSql('ALTER TABLE categories DROP CONSTRAINT FK_3AF34668727ACA70');
        $this->addSql('ALTER TABLE pages DROP CONSTRAINT FK_2074E575541D4929');
        $this->addSql('DROP SEQUENCE users_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tags_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE articles_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE categories_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE pages_ID_seq CASCADE');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE tags');
        $this->addSql('DROP TABLE tags_articles');
        $this->addSql('DROP TABLE articles');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE pages');
    }
}
