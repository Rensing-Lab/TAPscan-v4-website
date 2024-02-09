<?php

namespace App\Tables;

use App\Models\TapInfo;
use Okipa\LaravelTable\Abstracts\AbstractTable;
use Okipa\LaravelTable\Table;
use App\Models\Users;

class TapInfoTable extends AbstractTable
{
    /**
     * Configure the table itself.
     *
     * @return \Okipa\LaravelTable\Table
     * @throws \ErrorException
     */
    protected function table(): Table
    {
        return (new Table())->model(TapInfo::class)
            ->routes([
                'index'   => ['name' => 'tapinfo.table'],
                //'create'  => ['name' => 'species.create'],
                //'show' => ['name' => 'tapinfo.show'],
                'edit'    => ['name' => 'tapinfo.edit'],
                //'destroy' => ['name' => 'tapinfo.destroy'],
            ])
            ->destroyConfirmationHtmlAttributes(fn(TapInfo $tapinfo) => [
                'data-confirm' => __('Are you sure you want to delete the entry :entry?', [
                    'entry' => $tapinfo->database_attribute,
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
        $table->column('tap')->sortable()->searchable()->title('TAP');
        $table->column('text')->sortable()->searchable()->title('Description');
        $table->column('reference')->sortable()->searchable()->title('References');
        $table->column('type')->sortable()->searchable()->title('Type');
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
