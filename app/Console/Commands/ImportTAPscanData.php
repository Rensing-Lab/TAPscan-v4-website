<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

use App\Imports\DomainImport;
use App\Imports\SpeciesImport;
use App\Imports\TapImport;
use App\Imports\TapInfoImport;
use App\Imports\TapRulesImport;

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
      $file = '/data/import-rules/rules_v81.txt';
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
      Excel::import(new TapImport(), $file);
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


      return 0;
    }
}
