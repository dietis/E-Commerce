<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200312195415 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, id_item INT NOT NULL, name VARCHAR(50) NOT NULL, price INT DEFAULT NULL, weight INT DEFAULT NULL, enabled TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item_store (item_id INT NOT NULL, store_id INT NOT NULL, INDEX IDX_D5F043A7126F525E (item_id), INDEX IDX_D5F043A7B092A811 (store_id), PRIMARY KEY(item_id, store_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, fk_user_id INT DEFAULT NULL, id_order INT NOT NULL, price INT NOT NULL, enabled TINYINT(1) NOT NULL, INDEX IDX_F52993985741EEB9 (fk_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_store (order_id INT NOT NULL, store_id INT NOT NULL, INDEX IDX_7CC92C8A8D9F6D38 (order_id), INDEX IDX_7CC92C8AB092A811 (store_id), PRIMARY KEY(order_id, store_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shopping_cart (id INT AUTO_INCREMENT NOT NULL, fk_user_id INT DEFAULT NULL, id_shopping_cart INT NOT NULL, UNIQUE INDEX UNIQ_72AAD4F65741EEB9 (fk_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shopping_cart_item (shopping_cart_id INT NOT NULL, item_id INT NOT NULL, INDEX IDX_E59A1DF445F80CD (shopping_cart_id), INDEX IDX_E59A1DF4126F525E (item_id), PRIMARY KEY(shopping_cart_id, item_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE store (id INT AUTO_INCREMENT NOT NULL, id_store INT NOT NULL, name VARCHAR(50) NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, enabled TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transporter (id INT AUTO_INCREMENT NOT NULL, id_transporter INT NOT NULL, name VARCHAR(50) NOT NULL, enabled TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(64) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', api_token VARCHAR(255) DEFAULT NULL, city VARCHAR(255) NOT NULL, street VARCHAR(255) NOT NULL, state VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D6497BA2F5EB (api_token), UNIQUE INDEX UNIQ_8D93D6492D5B0234 (city), UNIQUE INDEX UNIQ_8D93D649F0EED3D8 (street), UNIQUE INDEX UNIQ_8D93D649A393D2FB (state), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE item_store ADD CONSTRAINT FK_D5F043A7126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE item_store ADD CONSTRAINT FK_D5F043A7B092A811 FOREIGN KEY (store_id) REFERENCES store (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993985741EEB9 FOREIGN KEY (fk_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE order_store ADD CONSTRAINT FK_7CC92C8A8D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_store ADD CONSTRAINT FK_7CC92C8AB092A811 FOREIGN KEY (store_id) REFERENCES store (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shopping_cart ADD CONSTRAINT FK_72AAD4F65741EEB9 FOREIGN KEY (fk_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE shopping_cart_item ADD CONSTRAINT FK_E59A1DF445F80CD FOREIGN KEY (shopping_cart_id) REFERENCES shopping_cart (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shopping_cart_item ADD CONSTRAINT FK_E59A1DF4126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE item_store DROP FOREIGN KEY FK_D5F043A7126F525E');
        $this->addSql('ALTER TABLE shopping_cart_item DROP FOREIGN KEY FK_E59A1DF4126F525E');
        $this->addSql('ALTER TABLE order_store DROP FOREIGN KEY FK_7CC92C8A8D9F6D38');
        $this->addSql('ALTER TABLE shopping_cart_item DROP FOREIGN KEY FK_E59A1DF445F80CD');
        $this->addSql('ALTER TABLE item_store DROP FOREIGN KEY FK_D5F043A7B092A811');
        $this->addSql('ALTER TABLE order_store DROP FOREIGN KEY FK_7CC92C8AB092A811');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993985741EEB9');
        $this->addSql('ALTER TABLE shopping_cart DROP FOREIGN KEY FK_72AAD4F65741EEB9');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE item_store');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_store');
        $this->addSql('DROP TABLE shopping_cart');
        $this->addSql('DROP TABLE shopping_cart_item');
        $this->addSql('DROP TABLE store');
        $this->addSql('DROP TABLE transporter');
        $this->addSql('DROP TABLE user');
    }
}
