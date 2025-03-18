<?php
namespace App\View\Components;

use Illuminate\View\Component;

class FilesList extends Component
{
    public $files;
    public $category;

    /**
     * Create a new component instance.
     */
    public function __construct($files = array(), $category = array())
    {
        $this->files = $files;
        $this->category = $category;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.files-list');
    }
}
