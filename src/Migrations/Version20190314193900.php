<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190314193900 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE price ADD CONSTRAINT FK_CAC822D9786A81FB FOREIGN KEY (iduser_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE profile DROP INDEX userid, ADD UNIQUE INDEX UNIQ_8157AA0FA76ED395 (user_id)');
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY profile_ibfk_1');
        $this->addSql('ALTER TABLE profile CHANGE telephone telephone VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE slider ADD CONSTRAINT FK_CFC71007A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
        $this->addSql('ALTER TABLE day ADD CONSTRAINT FK_E5A02990A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FB19811DC FOREIGN KEY (poluch_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message RENAME INDEX uniq_b6bd307fb19811dc TO IDX_B6BD307FB19811DC');
        $this->addSql('ALTER TABLE recall ADD CONSTRAINT FK_4B30057613B3DB11 FOREIGN KEY (master_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE recall ADD CONSTRAINT FK_4B300576A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE time ADD CONSTRAINT FK_6F9498459C24126 FOREIGN KEY (day_id) REFERENCES day (id)');
        $this->addSql('ALTER TABLE time ADD CONSTRAINT FK_6F949845C643D61D FOREIGN KEY (brone_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE category');
        $this->addSql('ALTER TABLE day DROP FOREIGN KEY FK_E5A02990A76ED395');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FB19811DC');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FF675F31B');
        $this->addSql('ALTER TABLE message RENAME INDEX idx_b6bd307fb19811dc TO UNIQ_B6BD307FB19811DC');
        $this->addSql('ALTER TABLE price DROP FOREIGN KEY FK_CAC822D9786A81FB');
        $this->addSql('ALTER TABLE profile DROP INDEX UNIQ_8157AA0FA76ED395, ADD INDEX userid (user_id)');
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0FA76ED395');
        $this->addSql('ALTER TABLE profile CHANGE telephone telephone VARCHAR(11) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT profile_ibfk_1 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recall DROP FOREIGN KEY FK_4B30057613B3DB11');
        $this->addSql('ALTER TABLE recall DROP FOREIGN KEY FK_4B300576A76ED395');
        $this->addSql('ALTER TABLE slider DROP FOREIGN KEY FK_CFC71007A76ED395');
        $this->addSql('ALTER TABLE time DROP FOREIGN KEY FK_6F9498459C24126');
        $this->addSql('ALTER TABLE time DROP FOREIGN KEY FK_6F949845C643D61D');
        $this->addSql('DROP INDEX UNIQ_8D93D649F85E0677 ON user');
        $this->addSql('ALTER TABLE user CHANGE roles roles VARCHAR(255) NOT NULL COLLATE utf8_general_ci');
    }
}
