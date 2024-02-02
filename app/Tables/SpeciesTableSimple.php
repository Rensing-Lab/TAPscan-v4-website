<?php

namespace App\Tables;

use App\Models\SpeciesTaxId;
use Okipa\LaravelTable\Abstracts\AbstractTable;
use Okipa\LaravelTable\Table;

class SpeciesTableSimple extends AbstractTable
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
                'index'   => ['name' => 'species.table'],
                'show'    => ['name' => 'species.show']
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
        $table->column('lettercode')->sortable()->searchable()->title('5 Letter Code');
        $table->column('name')->sortable()->searchable()->title('Species Name');
        $table->column('taxid')->sortable()->searchable()->title('NCBI TaxID');
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
