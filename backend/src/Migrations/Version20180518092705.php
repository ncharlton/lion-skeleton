<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180518092705 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE profile (id VARCHAR(30) NOT NULL, avatar VARCHAR(30) DEFAULT NULL, hobbies VARCHAR(255) NOT NULL, profession VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8157AA0F1677722F (avatar), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0F1677722F FOREIGN KEY (avatar) REFERENCES file (id)');
        $this->addSql('ALTER TABLE actor ADD profile VARCHAR(30) DEFAULT NULL');
        $this->addSql('ALTER TABLE actor ADD CONSTRAINT FK_447556F98157AA0F FOREIGN KEY (profile) REFERENCES profile (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_447556F98157AA0F ON actor (profile)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE actor DROP FOREIGN KEY FK_447556F98157AA0F');
        $this->addSql('DROP TABLE profile');
        $this->addSql('DROP INDEX UNIQ_447556F98157AA0F ON actor');
        $this->addSql('ALTER TABLE actor DROP profile');
    }
}
