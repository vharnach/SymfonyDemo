<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220918203029 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        for ($i = 0; $i <= 100; $i++) {
            $phoneNumber = $i + 111111111;
            $params = ['phoneNumber' => $phoneNumber];
            $this->addSql('INSERT INTO `phone_number` (`number`) VALUES (:phoneNumber);', $params);
        }
    }
}
