<?php namespace KitLoong\MigrationsGenerator\Generators;

class ForeignKeyGenerator
{
    /**
     * @var string
     */
    protected $table;

    private $decorator;

    public function __construct(Decorator $decorator)
    {
        $this->decorator = $decorator;
    }

    /**
     * Get array of foreign keys
     *
     * @param  string  $table  Table name
     * @param  \Doctrine\DBAL\Schema\ForeignKeyConstraint[]  $foreignKeys
     * @param  bool  $ignoreForeignKeyNames
     *
     * @return array
     */
    public function generate(string $table, $foreignKeys, bool $ignoreForeignKeyNames): array
    {
        $this->table = $table;
        $fields = [];

        if (empty($foreignKeys)) {
            return [];
        }

        foreach ($foreignKeys as $foreignKey) {
            $fields[] = [
                'name' => $this->getName($foreignKey, $ignoreForeignKeyNames),
                'fields' => $foreignKey->getLocalColumns(),
                'references' => $foreignKey->getForeignColumns(),
                'on' => $this->decorator->tableWithoutPrefix($foreignKey->getForeignTableName()),
                'onUpdate' => $foreignKey->hasOption('onUpdate') ? $foreignKey->getOption('onUpdate') : null,
                'onDelete' => $foreignKey->hasOption('onDelete') ? $foreignKey->getOption('onDelete') : null,
            ];
        }
        return $fields;
    }

    /**
     * @param  \Doctrine\DBAL\Schema\ForeignKeyConstraint  $foreignKey
     * @param  bool  $ignoreForeignKeyNames
     *
     * @return null|string
     */
    protected function getName($foreignKey, bool $ignoreForeignKeyNames): ?string
    {
        if ($ignoreForeignKeyNames or $this->isDefaultName($foreignKey)) {
            return null;
        }
        return $foreignKey->getName();
    }

    /**
     * @param  \Doctrine\DBAL\Schema\ForeignKeyConstraint  $foreignKey
     *
     * @return bool
     */
    protected function isDefaultName($foreignKey): bool
    {
        return $foreignKey->getName() === $this->createIndexName($foreignKey->getLocalColumns());
    }

    /**
     * Create a default index name for the table.
     *
     * @param  array  $columns
     * @return string
     */
    protected function createIndexName(array $columns): string
    {
        $index = strtolower($this->table.'_'.implode('_', $columns).'_foreign');

        return str_replace(['-', '.'], '_', $index);
    }
}
