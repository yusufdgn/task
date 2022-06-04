<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220604212618 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subscription ADD cancellated TINYINT(1) NOT NULL, ADD cancellation_date VARCHAR(255) NOT NULL, ADD cancellation_reason VARCHAR(16) NOT NULL, ADD cancellation_code VARCHAR(16) NOT NULL, DROP cancellation');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subscription ADD cancellation TINYINT(1) DEFAULT NULL, DROP cancellated, DROP cancellation_date, DROP cancellation_reason, DROP cancellation_code');
    }
}
