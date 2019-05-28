<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190528135848 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()
                ->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE activity (id INT AUTO_INCREMENT NOT NULL,
                            user_id INT DEFAULT NULL, domain_id INT DEFAULT NULL, skill_id INT DEFAULT NULL,
                            status_id INT DEFAULT NULL, INDEX IDX_AC74095AA76ED395 (user_id),
                            INDEX IDX_AC74095A115F0EE5 (domain_id), INDEX IDX_AC74095A5585C142 (skill_id),
                            INDEX IDX_AC74095A6BF700BD (status_id), PRIMARY KEY(id)) 
                            DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095AA76ED395 
                            FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095A115F0EE5 
                            FOREIGN KEY (domain_id) REFERENCES domain (id)');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095A5585C142 
                            FOREIGN KEY (skill_id) REFERENCES skill (id)');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095A6BF700BD 
                            FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE link ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE link ADD CONSTRAINT FK_36AC99F1A76ED395 
                            FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_36AC99F1A76ED395 ON link (user_id)');
        $this->addSql('ALTER TABLE media ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10CA76ED395 
                            FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_6A2CA10CA76ED395 ON media (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()
                ->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE activity');
        $this->addSql('ALTER TABLE link DROP FOREIGN KEY FK_36AC99F1A76ED395');
        $this->addSql('DROP INDEX IDX_36AC99F1A76ED395 ON link');
        $this->addSql('ALTER TABLE link DROP user_id');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10CA76ED395');
        $this->addSql('DROP INDEX IDX_6A2CA10CA76ED395 ON media');
        $this->addSql('ALTER TABLE media DROP user_id');
    }
}
