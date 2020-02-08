<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200207091116 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE articles DROP CONSTRAINT fk_bfdd316812469de2');
        $this->addSql('ALTER TABLE articles DROP CONSTRAINT fk_bfdd3168f675f31b');
        $this->addSql('DROP INDEX uniq_bfdd3168f675f31b');
        $this->addSql('DROP INDEX uniq_bfdd316812469de2');
        $this->addSql('ALTER TABLE articles DROP category_id');
        $this->addSql('ALTER TABLE articles DROP author_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE articles ADD category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE articles ADD author_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT fk_bfdd316812469de2 FOREIGN KEY (category_id) REFERENCES categories (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT fk_bfdd3168f675f31b FOREIGN KEY (author_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_bfdd3168f675f31b ON articles (author_id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_bfdd316812469de2 ON articles (category_id)');
    }
}
