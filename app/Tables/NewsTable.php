<?php

namespace App\Tables;

use App\Models\News;
use Okipa\LaravelTable\Abstracts\AbstractTable;
use Okipa\LaravelTable\Table;

class NewsTable extends AbstractTable
{
    /**
     * Configure the table itself.
     *
     * @return \Okipa\LaravelTable\Table
     * @throws \ErrorException
     */
    protected function table(): Table
    {
        return (new Table())->model(News::class)
            ->routes([
                'index'   => ['name' => 'news.table'],
                'create'  => ['name' => 'news.create'],
                'show'    => ['name' => 'news.show'],
                'edit'    => ['name' => 'news.edit'],
                'destroy' => ['name' => 'news.destroy'],

            ])
            ->destroyConfirmationHtmlAttributes(fn(News $news) => [
                'data-confirm' => __('Are you sure you want to delete the entry :entry?', [
                    'entry' => $news->database_attribute,
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
        // $table->column('id')->sortable()->searchable()->title('ID');
        $table->column('name')->title('Name')->searchable();
        $table->column('created_at')->dateTimeFormat('d/m/Y H:i')->sortable()->title('Created at');
        $table->column('updated_at')->dateTimeFormat('d/m/Y H:i')->sortable(true, 'desc')->title('Updated at');
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
