<?php

namespace Newpixel\GeographyCRUD\app\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class AddSidebarGeographyLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pixeltour:add-sidebar-geography-links';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add links for geography - continents, countries, cities CRUD to the Backpack sidebar_content file';

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
        $path = 'resources/views/vendor/backpack/base/inc/sidebar_content.blade.php';
        $disk_name = config('backpack.base.root_disk_name');
        $disk = Storage::disk($disk_name);
        $code = '
{{-- Geography tree links --}}
<li class="treeview">
    <a href="#"><i class="fa fa-globe"></i> <span>Geografie</span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
        <li><a href="{{ backpack_url(\'city\') }}"><i class="fa fa-globe"></i> <span>Orase</span></a></li>
        <li><a href="{{ backpack_url(\'country\') }}"><i class="fa fa-globe"></i> <span>Tari</span></a></li>
        <li><a href="{{ backpack_url(\'continent\') }}"><i class="fa fa-globe"></i> <span>Continente</span></a></li>
    </ul>
</li>';

        if ($disk->exists($path)) {
            $contents = Storage::disk($disk_name)->get($path);

            if ($disk->put($path, $contents.PHP_EOL.$code)) {
                $this->info('Successfully added geography links tree to sidebar_content file.');
            } else {
                $this->error('Could not write to sidebar_content file.');
            }
        } else {
            $this->error("The sidebar_content file does not exist. Make sure Backpack\Base is properly installed.");
        }
    }
}
