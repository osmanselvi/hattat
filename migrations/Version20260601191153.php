<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260601191153 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `artworks` (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, image_path VARCHAR(255) NOT NULL, category VARCHAR(100) NOT NULL, is_featured TINYINT NOT NULL, created_at DATETIME NOT NULL, user_id INT NOT NULL, INDEX IDX_A2E004C7A76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE `assignments` (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, due_date DATE NOT NULL, status VARCHAR(50) NOT NULL, student_id INT NOT NULL, INDEX IDX_308A50DDCB944F1A (student_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE `corrections` (id INT AUTO_INCREMENT NOT NULL, corrected_image_path VARCHAR(255) NOT NULL, teacher_note LONGTEXT DEFAULT NULL, corrected_at DATETIME NOT NULL, submission_id INT NOT NULL, UNIQUE INDEX UNIQ_DE166914E1FD4933 (submission_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE `exhibitions` (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, location VARCHAR(255) NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, cover_image VARCHAR(255) DEFAULT NULL, is_active TINYINT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE `messages` (id INT AUTO_INCREMENT NOT NULL, sender_role VARCHAR(50) NOT NULL, content LONGTEXT NOT NULL, sent_at DATETIME NOT NULL, is_read TINYINT NOT NULL, student_id INT NOT NULL, INDEX IDX_DB021E96CB944F1A (student_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE `news` (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, cover_image VARCHAR(255) DEFAULT NULL, published_at DATETIME NOT NULL, is_published TINYINT NOT NULL, UNIQUE INDEX UNIQ_1DD39950989D9B62 (slug), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE `students` (id INT AUTO_INCREMENT NOT NULL, phone VARCHAR(50) DEFAULT NULL, level VARCHAR(20) NOT NULL, enrollment_date DATE NOT NULL, notes LONGTEXT DEFAULT NULL, user_id INT NOT NULL, UNIQUE INDEX UNIQ_A4698DB2A76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE `submissions` (id INT AUTO_INCREMENT NOT NULL, image_path VARCHAR(255) NOT NULL, student_note LONGTEXT DEFAULT NULL, submitted_at DATETIME NOT NULL, assignment_id INT NOT NULL, student_id INT NOT NULL, INDEX IDX_3F6169F7D19302F8 (assignment_id), INDEX IDX_3F6169F7CB944F1A (student_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE `users` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, avatar VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE `artworks` ADD CONSTRAINT FK_A2E004C7A76ED395 FOREIGN KEY (user_id) REFERENCES `users` (id)');
        $this->addSql('ALTER TABLE `assignments` ADD CONSTRAINT FK_308A50DDCB944F1A FOREIGN KEY (student_id) REFERENCES `students` (id)');
        $this->addSql('ALTER TABLE `corrections` ADD CONSTRAINT FK_DE166914E1FD4933 FOREIGN KEY (submission_id) REFERENCES `submissions` (id)');
        $this->addSql('ALTER TABLE `messages` ADD CONSTRAINT FK_DB021E96CB944F1A FOREIGN KEY (student_id) REFERENCES `students` (id)');
        $this->addSql('ALTER TABLE `students` ADD CONSTRAINT FK_A4698DB2A76ED395 FOREIGN KEY (user_id) REFERENCES `users` (id)');
        $this->addSql('ALTER TABLE `submissions` ADD CONSTRAINT FK_3F6169F7D19302F8 FOREIGN KEY (assignment_id) REFERENCES `assignments` (id)');
        $this->addSql('ALTER TABLE `submissions` ADD CONSTRAINT FK_3F6169F7CB944F1A FOREIGN KEY (student_id) REFERENCES `students` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `artworks` DROP FOREIGN KEY FK_A2E004C7A76ED395');
        $this->addSql('ALTER TABLE `assignments` DROP FOREIGN KEY FK_308A50DDCB944F1A');
        $this->addSql('ALTER TABLE `corrections` DROP FOREIGN KEY FK_DE166914E1FD4933');
        $this->addSql('ALTER TABLE `messages` DROP FOREIGN KEY FK_DB021E96CB944F1A');
        $this->addSql('ALTER TABLE `students` DROP FOREIGN KEY FK_A4698DB2A76ED395');
        $this->addSql('ALTER TABLE `submissions` DROP FOREIGN KEY FK_3F6169F7D19302F8');
        $this->addSql('ALTER TABLE `submissions` DROP FOREIGN KEY FK_3F6169F7CB944F1A');
        $this->addSql('DROP TABLE `artworks`');
        $this->addSql('DROP TABLE `assignments`');
        $this->addSql('DROP TABLE `corrections`');
        $this->addSql('DROP TABLE `exhibitions`');
        $this->addSql('DROP TABLE `messages`');
        $this->addSql('DROP TABLE `news`');
        $this->addSql('DROP TABLE `students`');
        $this->addSql('DROP TABLE `submissions`');
        $this->addSql('DROP TABLE `users`');
    }
}
