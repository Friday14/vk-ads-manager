<?php

namespace App\Console\Commands;

use App\Domain\Ads\Events\CabinetsFetched;
use App\Domain\Ads\Jobs\FetchCabinets;
use App\Domain\Users\User;
use Illuminate\Console\Command;

class UpdateCabinet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cabinets:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle()
    {
        $users = User::whereNotNull('api_access_token')->get();
        foreach ($users as $user) {
            $cabinetUpdateJob = new FetchCabinets($user);
            dispatch($cabinetUpdateJob)->delay(40);
        }
    }
}
