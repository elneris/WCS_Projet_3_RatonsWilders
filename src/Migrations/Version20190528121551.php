<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190528121551 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName()
                        !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE domain (id INT AUTO_INCREMENT NOT NULL,
                            name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) 
                            DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE link (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) DEFAULT NULL,
                            type VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) 
                            DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL,
                            url VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) 
                            DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL,
                            PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL,
                            PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(100) DEFAULT NULL,
                            lastname VARCHAR(100) DEFAULT NULL, artist_name VARCHAR(100) DEFAULT NULL,
                            email VARCHAR(100) NOT NULL, phone_number VARCHAR(20) DEFAULT NULL,
                            city VARCHAR(100) DEFAULT NULL, poste_code INT DEFAULT NULL,
                            birthdate DATETIME DEFAULT NULL, address LONGTEXT DEFAULT NULL,
                            password VARCHAR(255) NOT NULL, geo_area VARCHAR(255) DEFAULT NULL,
                            price INT DEFAULT NULL, about LONGTEXT DEFAULT NULL, role INT DEFAULT NULL,
                            status VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) 
                            DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()
                ->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE domain');
        $this->addSql('DROP TABLE link');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE skill');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE user');
    }
}
