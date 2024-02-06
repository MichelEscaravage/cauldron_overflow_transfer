<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240129142344 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $connection = $this->connection;

        // Check if the column already exists before adding it
        $sql = "SELECT COUNT(*) as count FROM information_schema.columns WHERE table_name = 'job' AND column_name = 'slug'";
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();

        if ($result['count'] == 0) {
            // Add the column if it doesn't exist
            $this->addSql('ALTER TABLE job ADD slug VARCHAR(100) NOT NULL');
        }
    }

    public function down(Schema $schema): void
    {
        // Drop the column if it exists
        if ($schema->getTable('job')->hasColumn('slug')) {
            $this->addSql('ALTER TABLE job DROP COLUMN slug');
        }
    }
}
