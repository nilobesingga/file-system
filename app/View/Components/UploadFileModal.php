<?php
namespace App\View\Components;

use Illuminate\View\Component;

class UploadFileModal extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.upload-file-modal');
    }
}
