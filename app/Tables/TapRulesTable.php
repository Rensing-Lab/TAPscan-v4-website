<?php

namespace App\Tables;

use App\Models\TapRules;
use Okipa\LaravelTable\Abstracts\AbstractTable;
use Okipa\LaravelTable\Table;
use App\Models\Users;

class TapRulesTable extends AbstractTable
{
    /**
     * Configure the table itself.
     *
     * @return \Okipa\LaravelTable\Table
     * @throws \ErrorException
     */
    protected function table(): Table
    {
        return (new Table())->model(TapRules::class)
            ->routes([
              'index'   => ['name' => 'rules.table'],
              // 'create'  => ['name' => 'rules.create'],
              // 'show' => ['name' => 'rules.show'],
              'edit'    => ['name' => 'rules.edit'],
              'destroy' => ['name' => 'rules.destroy'],
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
        $table->column('tap_1')->sortable()->title('TAP Family')->searchable();
        $table->column('tap_2')->sortable()->title('Domain');
        $table->column('rule')->title('Rule');
        // $table->column('created_at')->dateTimeFormat('d/m/Y H:i')->sortable();
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
