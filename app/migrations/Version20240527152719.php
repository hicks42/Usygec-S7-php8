<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240527152719 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activities ADD company_id INT NOT NULL');
        $this->addSql('ALTER TABLE activities ADD CONSTRAINT FK_B5F1AFE5979B1AD6 FOREIGN KEY (company_id) REFERENCES companies (id)');
        $this->addSql('CREATE INDEX IDX_B5F1AFE5979B1AD6 ON activities (company_id)');
        $this->addSql('ALTER TABLE companies ADD handler_id INT NOT NULL, ADD category_id INT NOT NULL');
        $this->addSql('ALTER TABLE companies ADD CONSTRAINT FK_8244AA3AA6E82043 FOREIGN KEY (handler_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE companies ADD CONSTRAINT FK_8244AA3A12469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('CREATE INDEX IDX_8244AA3AA6E82043 ON companies (handler_id)');
        $this->addSql('CREATE INDEX IDX_8244AA3A12469DE2 ON companies (category_id)');
        $this->addSql('ALTER TABLE mc_performance ADD product_id INT NOT NULL');
        $this->addSql('ALTER TABLE mc_performance ADD CONSTRAINT FK_FE1AD2354584665A FOREIGN KEY (product_id) REFERENCES `mc_produit` (id)');
        $this->addSql('CREATE INDEX IDX_FE1AD2354584665A ON mc_performance (product_id)');
        $this->addSql('ALTER TABLE mc_produit ADD categorie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE mc_produit ADD CONSTRAINT FK_9AB288E4BCF5E72D FOREIGN KEY (categorie_id) REFERENCES `mc_categorie` (id)');
        $this->addSql('CREATE INDEX IDX_9AB288E4BCF5E72D ON mc_produit (categorie_id)');
        $this->addSql('ALTER TABLE mc_repart_geo ADD produit_id INT NOT NULL');
        $this->addSql('ALTER TABLE mc_repart_geo ADD CONSTRAINT FK_C631E788F347EFB FOREIGN KEY (produit_id) REFERENCES `mc_produit` (id)');
        $this->addSql('CREATE INDEX IDX_C631E788F347EFB ON mc_repart_geo (produit_id)');
        $this->addSql('ALTER TABLE mc_repart_sector ADD produit_id INT NOT NULL');
        $this->addSql('ALTER TABLE mc_repart_sector ADD CONSTRAINT FK_8D81AE3CF347EFB FOREIGN KEY (produit_id) REFERENCES `mc_produit` (id)');
        $this->addSql('CREATE INDEX IDX_8D81AE3CF347EFB ON mc_repart_sector (produit_id)');
        $this->addSql('ALTER TABLE reset_password_request ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_7CE748AA76ED395 ON reset_password_request (user_id)');
        $this->addSql('ALTER TABLE sd_address ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE sd_address ADD CONSTRAINT FK_E35FD7D0A76ED395 FOREIGN KEY (user_id) REFERENCES sd_users (id)');
        $this->addSql('CREATE INDEX IDX_E35FD7D0A76ED395 ON sd_address (user_id)');
        $this->addSql('ALTER TABLE sd_attachment ADD produit_id INT NOT NULL');
        $this->addSql('ALTER TABLE sd_attachment ADD CONSTRAINT FK_528D9990F347EFB FOREIGN KEY (produit_id) REFERENCES sd_produits (id)');
        $this->addSql('CREATE INDEX IDX_528D9990F347EFB ON sd_attachment (produit_id)');
        $this->addSql('ALTER TABLE sd_order ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE sd_order ADD CONSTRAINT FK_F6D7FF4BA76ED395 FOREIGN KEY (user_id) REFERENCES sd_users (id)');
        $this->addSql('CREATE INDEX IDX_F6D7FF4BA76ED395 ON sd_order (user_id)');
        $this->addSql('ALTER TABLE sd_order_details ADD the_order_id INT NOT NULL');
        $this->addSql('ALTER TABLE sd_order_details ADD CONSTRAINT FK_28E0F716C416F85B FOREIGN KEY (the_order_id) REFERENCES `sd_order` (id)');
        $this->addSql('CREATE INDEX IDX_28E0F716C416F85B ON sd_order_details (the_order_id)');
        $this->addSql('ALTER TABLE sd_produits ADD category_id INT DEFAULT NULL, ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE sd_produits ADD CONSTRAINT FK_A2AFAF5612469DE2 FOREIGN KEY (category_id) REFERENCES sd_category (id)');
        $this->addSql('ALTER TABLE sd_produits ADD CONSTRAINT FK_A2AFAF56A76ED395 FOREIGN KEY (user_id) REFERENCES sd_users (id)');
        $this->addSql('CREATE INDEX IDX_A2AFAF5612469DE2 ON sd_produits (category_id)');
        $this->addSql('CREATE INDEX IDX_A2AFAF56A76ED395 ON sd_produits (user_id)');
        $this->addSql('ALTER TABLE sd_reset_password_requests ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE sd_reset_password_requests ADD CONSTRAINT FK_923E81BAA76ED395 FOREIGN KEY (user_id) REFERENCES sd_users (id)');
        $this->addSql('CREATE INDEX IDX_923E81BAA76ED395 ON sd_reset_password_requests (user_id)');
        $this->addSql('ALTER TABLE structure ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE structure ADD CONSTRAINT FK_6F0137EAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_6F0137EAA76ED395 ON structure (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activities DROP FOREIGN KEY FK_B5F1AFE5979B1AD6');
        $this->addSql('DROP INDEX IDX_B5F1AFE5979B1AD6 ON activities');
        $this->addSql('ALTER TABLE activities DROP company_id');
        $this->addSql('ALTER TABLE companies DROP FOREIGN KEY FK_8244AA3AA6E82043');
        $this->addSql('ALTER TABLE companies DROP FOREIGN KEY FK_8244AA3A12469DE2');
        $this->addSql('DROP INDEX IDX_8244AA3AA6E82043 ON companies');
        $this->addSql('DROP INDEX IDX_8244AA3A12469DE2 ON companies');
        $this->addSql('ALTER TABLE companies DROP handler_id, DROP category_id');
        $this->addSql('ALTER TABLE `mc_performance` DROP FOREIGN KEY FK_FE1AD2354584665A');
        $this->addSql('DROP INDEX IDX_FE1AD2354584665A ON `mc_performance`');
        $this->addSql('ALTER TABLE `mc_performance` DROP product_id');
        $this->addSql('ALTER TABLE `mc_produit` DROP FOREIGN KEY FK_9AB288E4BCF5E72D');
        $this->addSql('DROP INDEX IDX_9AB288E4BCF5E72D ON `mc_produit`');
        $this->addSql('ALTER TABLE `mc_produit` DROP categorie_id');
        $this->addSql('ALTER TABLE `mc_repart_geo` DROP FOREIGN KEY FK_C631E788F347EFB');
        $this->addSql('DROP INDEX IDX_C631E788F347EFB ON `mc_repart_geo`');
        $this->addSql('ALTER TABLE `mc_repart_geo` DROP produit_id');
        $this->addSql('ALTER TABLE `mc_repart_sector` DROP FOREIGN KEY FK_8D81AE3CF347EFB');
        $this->addSql('DROP INDEX IDX_8D81AE3CF347EFB ON `mc_repart_sector`');
        $this->addSql('ALTER TABLE `mc_repart_sector` DROP produit_id');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP INDEX IDX_7CE748AA76ED395 ON reset_password_request');
        $this->addSql('ALTER TABLE reset_password_request DROP user_id');
        $this->addSql('ALTER TABLE sd_address DROP FOREIGN KEY FK_E35FD7D0A76ED395');
        $this->addSql('DROP INDEX IDX_E35FD7D0A76ED395 ON sd_address');
        $this->addSql('ALTER TABLE sd_address DROP user_id');
        $this->addSql('ALTER TABLE sd_attachment DROP FOREIGN KEY FK_528D9990F347EFB');
        $this->addSql('DROP INDEX IDX_528D9990F347EFB ON sd_attachment');
        $this->addSql('ALTER TABLE sd_attachment DROP produit_id');
        $this->addSql('ALTER TABLE `sd_order` DROP FOREIGN KEY FK_F6D7FF4BA76ED395');
        $this->addSql('DROP INDEX IDX_F6D7FF4BA76ED395 ON `sd_order`');
        $this->addSql('ALTER TABLE `sd_order` DROP user_id');
        $this->addSql('ALTER TABLE sd_order_details DROP FOREIGN KEY FK_28E0F716C416F85B');
        $this->addSql('DROP INDEX IDX_28E0F716C416F85B ON sd_order_details');
        $this->addSql('ALTER TABLE sd_order_details DROP the_order_id');
        $this->addSql('ALTER TABLE sd_produits DROP FOREIGN KEY FK_A2AFAF5612469DE2');
        $this->addSql('ALTER TABLE sd_produits DROP FOREIGN KEY FK_A2AFAF56A76ED395');
        $this->addSql('DROP INDEX IDX_A2AFAF5612469DE2 ON sd_produits');
        $this->addSql('DROP INDEX IDX_A2AFAF56A76ED395 ON sd_produits');
        $this->addSql('ALTER TABLE sd_produits DROP category_id, DROP user_id');
        $this->addSql('ALTER TABLE sd_reset_password_requests DROP FOREIGN KEY FK_923E81BAA76ED395');
        $this->addSql('DROP INDEX IDX_923E81BAA76ED395 ON sd_reset_password_requests');
        $this->addSql('ALTER TABLE sd_reset_password_requests DROP user_id');
        $this->addSql('ALTER TABLE structure DROP FOREIGN KEY FK_6F0137EAA76ED395');
        $this->addSql('DROP INDEX IDX_6F0137EAA76ED395 ON structure');
        $this->addSql('ALTER TABLE structure DROP user_id');
    }
}
