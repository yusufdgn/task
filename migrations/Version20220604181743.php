<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220604181743 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subscriber CHANGE unique_id unique_id VARCHAR(64) NOT NULL');
        $this->addSql('ALTER TABLE subscription CHANGE subscriber_id subscriber_id VARCHAR(64) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subscriber CHANGE unique_id unique_id INT NOT NULL');
        $this->addSql('ALTER TABLE subscription CHANGE subscriber_id subscriber_id VARCHAR(32) NOT NULL');
    }
}
