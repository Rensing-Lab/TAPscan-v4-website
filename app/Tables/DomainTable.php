<?php

namespace App\Tables;

use App\Models\Domain;
use Okipa\LaravelTable\Abstracts\AbstractTable;
use Okipa\LaravelTable\Table;
use App\Models\Users;

class DomainTable extends AbstractTable
{
    /**
     * Configure the table itself.
     *
     * @return \Okipa\LaravelTable\Table
     * @throws \ErrorException
     */
    protected function table(): Table
    {
        return (new Table())->model(Domain::class)
            ->routes([
                'index'   => ['name' => 'domain.table'],
                'create'  => ['name' => 'domain.create'],
                //'show' => ['name' => 'domain.show'],
                'edit'    => ['name' => 'domain.edit'],
                'destroy' => ['name' => 'domain.destroy'],
            ])
            ->destroyConfirmationHtmlAttributes(fn(Domain $domain) => [
                'data-confirm' => __('Are you sure you want to delete the entry :entry?', [
                    'entry' => $domain->database_attribute,
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
        $table->column('name')->title('Domain')->sortable()->searchable();
        $table->column('pfam')->title('PFAM ID')->sortable()->searchable();
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

