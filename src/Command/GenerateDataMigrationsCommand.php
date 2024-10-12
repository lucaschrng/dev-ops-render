<?php

namespace App\Command;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GenerateDataMigrationsCommand extends Command
{
    protected static $defaultName = 'app:generate-data-migrations';
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        parent::__construct();
        $this->connection = $connection;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Génère des migrations de données à partir de la base de données actuelle');
    }

    /**
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $schemaManager = $this->connection->createSchemaManager();
        $tables = array_reverse($schemaManager->listTableNames());

        $migrationFileName = 'Version' . date('YmdHis') . '.php';
        $migrationFile = 'migrations/' . $migrationFileName;

        $migrationSql = '';
        $truncateSql = '$this->addSql("SET foreign_key_checks = 0");' . "\n";

        foreach ($tables as $table) {
            if ($table === 'doctrine_migration_versions') {
                continue;
            }

            $truncateSql .= sprintf(
                '$this->addSql' . '("TRUNCATE TABLE `%s`");' . "\n",
                $table
            );

            try {
                $data = $this->connection->fetchAllAssociative("SELECT * FROM $table");
            } catch (\Exception $e) {
                $io->error("Erreur lors de la récupération des données de la table $table : " . $e->getMessage());
                return Command::FAILURE;
            }

            if (empty($data)) {
                continue;
            }

            foreach ($data as $row) {
                $columns = array_keys($row);
                $values = array_values($row);

                $columnsList = implode(', ', $columns);
                $valuesList = implode(', ', array_map([$this, 'quoteValue'], $values));

                $migrationSql .= sprintf(
                    '$this->addSql' . '("INSERT INTO `%s` (%s) VALUES (%s)");' . "\n",
                    $table,
                    $columnsList,
                    $valuesList
                );
            }
        }

        $truncateSql .= '$this->addSql("SET foreign_key_checks = 1");' . "\n";

        $this->writeMigrationFile($migrationFile, $migrationSql, $truncateSql);

        $io->success("Migrations de données générées avec succès dans '$migrationFileName' !");

        return Command::SUCCESS;
    }

    /**
     * Quotes a value for use in a SQL query.
     *
     * @param mixed $value The value to quote.
     * @return string The quoted value as a string.
     */
    private function quoteValue(mixed $value): string
    {
        if (is_null($value)) {
            return 'NULL';
        }

        if (is_numeric($value)) {
            return (string)$value; // Convertit en string pour garantir le type de retour
        }

        return $this->connection->quote($value);
    }

    private function writeMigrationFile(string $filePath, string $migrationSql, string $truncateSql): void
    {
        $directory = dirname($filePath);
        if (!is_dir($directory) && !mkdir($directory, 0777, true) && !is_dir($directory)) {
            throw new RuntimeException(sprintf('Directory "%s" was not created', $directory));
        }

        $migrationTemplate = <<<'EOT'
<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version%s extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Données générées à partir des données existantes dans la base de données, ' . 
        'Alerte ! Ce script va tronquer toutes les tables avant de commencer';
    }

    public function preUp(Schema $schema): void
    {
        // Important de tronquer les tables avant d'ajouter des valeurs dupliquées
%s
    }

    public function up(Schema $schema): void
    {
        // Cette migration up() est auto-générée, veuillez la modifier selon vos besoins
%s
    }

    public function down(Schema $schema): void
    {
        // Optionnel : Ajoutez la logique pour annuler la migration si nécessaire
    }
}
EOT;

        $migrationClass = sprintf(
            $migrationTemplate,
            date('YmdHis'),
            $this->indent($truncateSql, 2),
            $this->indent($migrationSql, 2)
        );

        file_put_contents($filePath, $migrationClass);
    }

    private function indent(string $text, int $level = 1): string
    {
        $indentation = str_repeat('    ', $level);
        return implode("\n", array_map(static function ($line) use ($indentation): string {
            return $indentation . $line;
        }, explode("\n", $text)));
    }
}
