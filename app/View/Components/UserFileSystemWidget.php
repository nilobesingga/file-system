<?php
namespace App\View\Components;

use Illuminate\View\Component;

class UserFileSystemWidget extends Component
{
    public $totalFiles;
    public $unreadFilesCount;
    public $recentUploadsCount;

    /**
     * Create a new component instance.
     */
    public function __construct($totalFiles = 0, $unreadFilesCount = 0, $recentUploadsCount = 0)
    {
        $this->totalFiles = $totalFiles;
        $this->unreadFilesCount = $unreadFilesCount;
        $this->recentUploadsCount = $recentUploadsCount;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.user-file-system-widget');
    }
}
