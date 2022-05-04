<?php

namespace App\Tables;

use App\Models\Tap;
use Okipa\LaravelTable\Abstracts\AbstractTable;
use Okipa\LaravelTable\Table;

class TapTable extends AbstractTable
{
    /**
     * Configure the table itself.
     *
     * @return \Okipa\LaravelTable\Table
     * @throws \ErrorException
     */
    protected function table(): Table
    {
        return (new Table())->model(Tap::class)
            ->routes([
              'index'   => ['name' => 'tap.index'],
              // 'create'  => ['name' => 'tap.create'],
              // 'show' => ['name' => 'tap.show'],
              // 'edit'    => ['name' => 'tap.edit'],
              // 'destroy' => ['name' => 'tap.destroy'],
            ])
            ->destroyConfirmationHtmlAttributes(fn(Tap $tap) => [
                'data-confirm' => __('Are you sure you want to delete the entry :entry?', [
                    'entry' => $tap->database_attribute,
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
        $table->column('tap_id')->sortable()->searchable()->title('TAP ID');
        $table->column('tap_1')->sortable()->searchable()->title('TAP 1');
        $table->column('tap_2')->sortable()->searchable()->title('TAP 2');
        $table->column('count')->sortable()->title('Count');
        $table->column('tap_3')->sortable()->title('TAP 3');
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
