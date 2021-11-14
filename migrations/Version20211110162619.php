<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211110162619 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE announcement ADD id_type_house INT DEFAULT NULL, ADD id_apartment_size INT DEFAULT NULL, ADD id_due_date INT DEFAULT NULL, ADD id_ownership INT DEFAULT NULL, DROP type_house, DROP apartment_size, DROP due_date, DROP ownership');
        $this->addSql('ALTER TABLE announcement ADD CONSTRAINT FK_4DB9D91CCC533EBD FOREIGN KEY (id_type_house) REFERENCES properties (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE announcement ADD CONSTRAINT FK_4DB9D91CBF3A2B82 FOREIGN KEY (id_apartment_size) REFERENCES properties (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE announcement ADD CONSTRAINT FK_4DB9D91CB6A84CA4 FOREIGN KEY (id_due_date) REFERENCES properties (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE announcement ADD CONSTRAINT FK_4DB9D91C98A550B3 FOREIGN KEY (id_ownership) REFERENCES properties (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_4DB9D91CCC533EBD ON announcement (id_type_house)');
        $this->addSql('CREATE INDEX IDX_4DB9D91CBF3A2B82 ON announcement (id_apartment_size)');
        $this->addSql('CREATE INDEX IDX_4DB9D91CB6A84CA4 ON announcement (id_due_date)');
        $this->addSql('CREATE INDEX IDX_4DB9D91C98A550B3 ON announcement (id_ownership)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE announcement DROP FOREIGN KEY FK_4DB9D91CCC533EBD');
        $this->addSql('ALTER TABLE announcement DROP FOREIGN KEY FK_4DB9D91CBF3A2B82');
        $this->addSql('ALTER TABLE announcement DROP FOREIGN KEY FK_4DB9D91CB6A84CA4');
        $this->addSql('ALTER TABLE announcement DROP FOREIGN KEY FK_4DB9D91C98A550B3');
        $this->addSql('DROP INDEX IDX_4DB9D91CCC533EBD ON announcement');
        $this->addSql('DROP INDEX IDX_4DB9D91CBF3A2B82 ON announcement');
        $this->addSql('DROP INDEX IDX_4DB9D91CB6A84CA4 ON announcement');
        $this->addSql('DROP INDEX IDX_4DB9D91C98A550B3 ON announcement');
        $this->addSql('ALTER TABLE announcement ADD type_house VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD apartment_size VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD due_date VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD ownership VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP id_type_house, DROP id_apartment_size, DROP id_due_date, DROP id_ownership');
    }
}
