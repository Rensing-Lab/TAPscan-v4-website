<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\SpeciesTaxId;
use Illuminate\Support\Facades\DB;

use App\Imports\DomainImport;
use App\Imports\SpeciesImport;
use App\Imports\TapImport;
use App\Imports\TapInfoImport;
use App\Imports\TapRulesImport;
use App\Imports\StructureImport;

use EllGreen\LaravelLoadFile\Laravel\Facades\LoadFile;

class ImportTAPscanData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:tapscan_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all the TAPscan data from _data folder';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
      // SPECIES
      $file = '/data/import-species/species_v4.csv';
      $this->info('Importing species...');
      if (!file_exists($file)) {
        $this->error('CSV file not found!'); return;
      }
      Excel::import(new SpeciesImport(), $file);
      $this->info('Species import completed successfully!');

      // RULES
      $file = '/data/import-rules/rules_v82.txt';
      $this->info('Importing rules from '.$file.' ...');
      if (!file_exists($file)) {
        $this->error('CSV file not found!'); return;
      }
      Excel::import(new TapRulesImport(), $file);
      $this->info('Rules import completed successfully!');

      // TAPS
      $file = '/data/import-tap/taps_v4.csv';
      //$file = '/data/import-tap/source/ACTCH.output.3';

      $this->info('Importing TAPs from '.$file.' ... (this may take a while)');
      if (!file_exists($file)) {
        $this->error('CSV file not found!'); return;
      }
      # This file is too big for Excel import (would take hours to import, so we do it differently
      # Cuts the import time from hours to seconds (!)
      //Excel::import(new TapImport(), $file);

      LoadFile::file($file, $local = true)
        ->into('taps')
        ->columns([
          'tap_id',
          //DB::raw('@tap_id'),
          'tap_1',
          'tap_2',
          'count',
          'tap_3',
        ])
        ->ignoreLines(1)
        ->fieldsTerminatedBy(';')
        ->fieldsEscapedBy('\\\\')
        ->fieldsEnclosedBy('"')
        ->set(['created_at' => now()])
        ->set(['updated_at' => now()])
        //->set(['code_id'    => DB::raw("(select id from species_tax_ids where species_tax_ids.lettercode=SUBSTRING_INDEX(@tap_id, '_', 1 ) collate utf8mb4_0900_ai_ci)")])
        ->load();


      DB::statement("UPDATE taps SET code_id = (SELECT id FROM species_tax_ids WHERE species_tax_ids.lettercode = SUBSTRING_INDEX(taps.tap_id,'_',1))");

      $this->info('TAPs import completed successfully!');

      // TAP INFO
      $file = '/data/import-tapinfo/tapinfo_v4.csv';
      $this->info('Importing TAP INFO from '.$file.' ...');
      if (!file_exists($file)) {
        $this->error('CSV file not found!'); return;
      }
      Excel::import(new TapInfoImport(), $file);
      $this->info('TAPINFO import completed successfully!');

       // DOMAIN INFO
      $file = '/data/import-domain/domains_v4.csv';
      $this->info('Importing Domains from '.$file.' ...');
      if (!file_exists($file)) {
        $this->error('CSV file not found!'); return;
      }
      Excel::import(new DomainImport(), $file);
      $this->info('Domain import completed successfully!');

      // Structural INFO (mapping to Plant-TFclass study)
      $file = '/data/import-structure/structure_v4.csv';
      $this->info('Importing Structural classes from '.$file.' ...');
      if (!file_exists($file)) {
        $this->error('CSV file not found!'); return;
      }
      Excel::import(new StructureImport(), $file);
      $this->info('Structure import completed successfully!');



      return 0;
    }
}
