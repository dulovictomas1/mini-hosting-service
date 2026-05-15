<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class WebspaceProvisioningService 
{
    public function createDirectory( string $path )
    {
        if( !File::exists($path) ) {
            File::makeDirectory($path, 0755, true);
        }

        File::put($path . DIRECTORY_SEPARATOR . 'index.php', '<?php echo "Tento webspace je pripravený.";');
    }
}