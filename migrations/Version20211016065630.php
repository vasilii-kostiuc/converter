<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211016065630 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE currency (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(3) NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE syncronization (id INT AUTO_INCREMENT NOT NULL, from_currency_id INT NOT NULL, to_currency_id INT NOT NULL, value DOUBLE PRECISION NOT NULL, syncronized_at DATETIME NOT NULL, INDEX IDX_3D77FA7CA66BB013 (from_currency_id), INDEX IDX_3D77FA7C16B7BF15 (to_currency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE syncronization ADD CONSTRAINT FK_3D77FA7CA66BB013 FOREIGN KEY (from_currency_id) REFERENCES currency (id)');
        $this->addSql('ALTER TABLE syncronization ADD CONSTRAINT FK_3D77FA7C16B7BF15 FOREIGN KEY (to_currency_id) REFERENCES currency (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE syncronization DROP FOREIGN KEY FK_3D77FA7CA66BB013');
        $this->addSql('ALTER TABLE syncronization DROP FOREIGN KEY FK_3D77FA7C16B7BF15');
        $this->addSql('DROP TABLE currency');
        $this->addSql('DROP TABLE syncronization');
    }
}
