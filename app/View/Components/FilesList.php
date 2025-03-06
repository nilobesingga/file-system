<?php
namespace App\View\Components;

use Illuminate\View\Component;

class FilesList extends Component
{
    public $files;

    /**
     * Create a new component instance.
     */
    public function __construct($files = array())
    {
        $this->files = $files;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.files-list');
    }
}
