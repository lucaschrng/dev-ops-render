<?php

namespace App\Command;

use Doctrine\DBAL\Connection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GenerateDataMigrationsCommand extends Command
{
	protected static $defaultName = 'app:generate-data-migrations';
	private $connection;

	public function __construct(Connection $connection)
	{
		parent::__construct();
		$this->connection = $connection;
	}

	protected function configure()
	{
		$this
			->setDescription('Generate data migrations from the current database')
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$io = new SymfonyStyle($input, $output);
		$schemaManager = $this->connection->createSchemaManager();
		$tables = array_reverse($schemaManager->listTableNames());

		$migrationFileName = 'Version'.date('YmdHis').'.php';

		$migrationFile = 'migrations/' . $migrationFileName;

		$migrationSql = '';

		foreach ($tables as $table) {

			if ($table === 'doctrine_migration_versions') {
				continue;
			}

			$data = $this->connection->fetchAllAssociative("SELECT * FROM $table");

			if (empty($data)) {
				continue;
			}

			foreach ($data as $row) {
				$columns = array_keys($row);
				$values = array_values($row);

				$columnsList = implode(', ', $columns);
				$valuesList = implode(', ', array_map([$this, 'quoteValue'], $values));

				$migrationSql .= sprintf(
					'$this->addSql' . '("INSERT INTO %s (%s) VALUES (%s)");' . "\n",
					$table,
					$columnsList,
					$valuesList
				);
			}
		}


		$this->writeMigrationFile($migrationFile, $migrationSql);

		$io->success("Data migrations generated successfully inside '$migrationFileName' !");

		return Command::SUCCESS;
	}

	private function quoteValue($value)
	{
		if (is_null($value)) {
			return 'NULL';
		}

		if (is_numeric($value)) {
			return $value;
		}

		return $this->connection->quote($value);
	}

	private function writeMigrationFile($filePath, $migrationSql)
	{
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
        return 'Data migration';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
%s
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
EOT;

		$migrationClass = sprintf($migrationTemplate, date('YmdHis'), $this->indent($migrationSql, 2));

		file_put_contents($filePath, $migrationClass);
	}

	private function indent($text, $level = 1)
	{
		$indentation = str_repeat('    ', $level);
		return implode("\n", array_map(function ($line) use ($indentation) {
			return $indentation . $line;
		}, explode("\n", $text)));
	}
}
