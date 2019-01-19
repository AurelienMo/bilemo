<?php declare(strict_types=1);

namespace App\Domain\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190119125515 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE amo_brand (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amo_client (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amo_collaborator (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amo_feature_phone (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, type_value VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amo_phone (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', amo_brand_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', amo_phone_os_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', amo_phone_memory_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', amo_type_connector_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_E4B4D2CDFFB2E30C (amo_brand_id), INDEX IDX_E4B4D2CDD54A68AF (amo_phone_os_id), INDEX IDX_E4B4D2CD93B71B59 (amo_phone_memory_id), INDEX IDX_E4B4D2CD6D444093 (amo_type_connector_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amo_phone_has_feature (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', amo_phone_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', amo_feature_phone_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', value VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_5F64DC63803410CF (amo_phone_id), INDEX IDX_5F64DC632A153E10 (amo_feature_phone_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amo_phone_memory (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amo_phone_os (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, short_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amo_type_connector (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE amo_phone ADD CONSTRAINT FK_E4B4D2CDFFB2E30C FOREIGN KEY (amo_brand_id) REFERENCES amo_brand (id)');
        $this->addSql('ALTER TABLE amo_phone ADD CONSTRAINT FK_E4B4D2CDD54A68AF FOREIGN KEY (amo_phone_os_id) REFERENCES amo_phone_os (id)');
        $this->addSql('ALTER TABLE amo_phone ADD CONSTRAINT FK_E4B4D2CD93B71B59 FOREIGN KEY (amo_phone_memory_id) REFERENCES amo_phone_memory (id)');
        $this->addSql('ALTER TABLE amo_phone ADD CONSTRAINT FK_E4B4D2CD6D444093 FOREIGN KEY (amo_type_connector_id) REFERENCES amo_type_connector (id)');
        $this->addSql('ALTER TABLE amo_phone_has_feature ADD CONSTRAINT FK_5F64DC63803410CF FOREIGN KEY (amo_phone_id) REFERENCES amo_phone (id)');
        $this->addSql('ALTER TABLE amo_phone_has_feature ADD CONSTRAINT FK_5F64DC632A153E10 FOREIGN KEY (amo_feature_phone_id) REFERENCES amo_feature_phone (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amo_phone DROP FOREIGN KEY FK_E4B4D2CDFFB2E30C');
        $this->addSql('ALTER TABLE amo_phone_has_feature DROP FOREIGN KEY FK_5F64DC632A153E10');
        $this->addSql('ALTER TABLE amo_phone_has_feature DROP FOREIGN KEY FK_5F64DC63803410CF');
        $this->addSql('ALTER TABLE amo_phone DROP FOREIGN KEY FK_E4B4D2CD93B71B59');
        $this->addSql('ALTER TABLE amo_phone DROP FOREIGN KEY FK_E4B4D2CDD54A68AF');
        $this->addSql('ALTER TABLE amo_phone DROP FOREIGN KEY FK_E4B4D2CD6D444093');
        $this->addSql('DROP TABLE amo_brand');
        $this->addSql('DROP TABLE amo_client');
        $this->addSql('DROP TABLE amo_collaborator');
        $this->addSql('DROP TABLE amo_feature_phone');
        $this->addSql('DROP TABLE amo_phone');
        $this->addSql('DROP TABLE amo_phone_has_feature');
        $this->addSql('DROP TABLE amo_phone_memory');
        $this->addSql('DROP TABLE amo_phone_os');
        $this->addSql('DROP TABLE amo_type_connector');
    }
}
