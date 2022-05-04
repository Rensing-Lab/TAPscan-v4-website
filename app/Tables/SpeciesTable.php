<?php

namespace App\Tables;

use App\Models\SpeciesTaxId;
use Okipa\LaravelTable\Abstracts\AbstractTable;
use Okipa\LaravelTable\Table;
use App\Models\Users;

class SpeciesTable extends AbstractTable
{
    /**
     * Configure the table itself.
     *
     * @return \Okipa\LaravelTable\Table
     * @throws \ErrorException
     */
    protected function table(): Table
    {
        return (new Table())->model(SpeciesTaxId::class)
            ->routes([
                'index'   => ['name' => 'species.index'],
                // 'create'  => ['name' => 'species.create'],
                'show' => ['name' => 'species.show'],
                'edit'    => ['name' => 'species.edit'],
                'destroy' => ['name' => 'species.destroy'],
            ])
            ->destroyConfirmationHtmlAttributes(fn(SpeciesTaxId $speciesTaxId) => [
                'data-confirm' => __('Are you sure you want to delete the entry :entry?', [
                    'entry' => $speciesTaxId->database_attribute,
                ]),
            ]);
    }

    /**
     * Configure the table columns.
     *
     * @param \Okipa\LaravelTable\Table $table
     *
     * @throws \ErrorException
     */
    protected function columns(Table $table): void
    {
        $table->column('name')->sortable()->searchable()->title('Species Name');
        $table->column('taxid')->sortable()->searchable()->title('TaxID');
        // $table->column('updated_at')->dateTimeFormat('d/m/Y H:i')->sortable(true, 'desc');
    }

    /**
     * Configure the table result lines.
     *
     * @param \Okipa\LaravelTable\Table $table
     */
    protected function resultLines(Table $table): void
    {
        //
    }
}
