<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200207163714 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE tags_articles (tags_id INT NOT NULL, articles_id INT NOT NULL, PRIMARY KEY(tags_id, articles_id))');
        $this->addSql('CREATE INDEX IDX_D54BAD718D7B4FB4 ON tags_articles (tags_id)');
        $this->addSql('CREATE INDEX IDX_D54BAD711EBAF6CC ON tags_articles (articles_id)');
        $this->addSql('ALTER TABLE tags_articles ADD CONSTRAINT FK_D54BAD718D7B4FB4 FOREIGN KEY (tags_id) REFERENCES tags (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tags_articles ADD CONSTRAINT FK_D54BAD711EBAF6CC FOREIGN KEY (articles_id) REFERENCES articles (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE articles_tags');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE articles_tags (articles_id INT NOT NULL, tags_id INT NOT NULL, PRIMARY KEY(articles_id, tags_id))');
        $this->addSql('CREATE INDEX idx_354053618d7b4fb4 ON articles_tags (tags_id)');
        $this->addSql('CREATE INDEX idx_354053611ebaf6cc ON articles_tags (articles_id)');
        $this->addSql('ALTER TABLE articles_tags ADD CONSTRAINT fk_354053611ebaf6cc FOREIGN KEY (articles_id) REFERENCES articles (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE articles_tags ADD CONSTRAINT fk_354053618d7b4fb4 FOREIGN KEY (tags_id) REFERENCES tags (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE tags_articles');
    }
}
