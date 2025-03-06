<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Textarea extends Component
{
    public $id;
    public $name;
    public $value;
    public $class;
    public $required;

    /**
     * Create a new component instance.
     *
     * @param string $id
     * @param string $name
     * @param string|null $value
     * @param string|null $class
     * @param bool $required
     * @return void
     */
    public function __construct($id, $name, $value = null, $class = null, $required = false)
    {
        $this->id = $id;
        $this->name = $name;
        $this->value = $value;
        $this->class = $class ?? 'block w-full mt-1 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400';
        $this->required = $required;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.textarea');
    }
}
