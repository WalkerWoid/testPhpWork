<?php

namespace Felix\StudyProject\Commands;

use Felix\StudyProject\Database;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DatabaseInitCommand extends \Symfony\Component\Console\Command\Command
{
    protected function configure()
    {
        $this
            ->setName('database-init')
            ->setHelp('Инициализирует БД')
            ->setDescription('Создание файла базы данных и таблиц в ней');
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return int
     *
     * todo Написать запрос для создания таблицы
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $createTableSql = <<<SQL

SQL;

        try {
            $database = new Database();
            $database->query($createTableSql);
        } catch (\Throwable $throwable) {
            $output->writeln('Ошибка при инициализации базы данных: ' . $throwable->getMessage());
            return Command::FAILURE;
        }

        $output->writeln('База данных создана и инициализирована');

        return Command::SUCCESS;
    }
}
