<?php

namespace App\Tables;

use App\Models\Domain;
use Okipa\LaravelTable\Abstracts\AbstractTable;
use Okipa\LaravelTable\Table;
use App\Models\Users;

class DomainTableSimple extends AbstractTable
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
                'index'   => ['name' => 'domain.index'],
                // 'create'  => ['name' => 'species.create'],
                //'show' => ['name' => 'tapinfo.show'],
                //'edit'    => ['name' => 'tapinfo.edit'],
                //'destroy' => ['name' => 'tapinfo.destroy'],
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

