<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    /**
     * Create a new component instance.
     */
    public string $name;
    public string $title;
    public $value;
    public string $type;
    public int $column;
    public bool $required;

    public function __construct($name, $title, $value = null, $type = 'text', $column = 1, $required =  false)
    {
        $this->name = $name;
        $this->title = $title;
        $this->value = $value;
        $this->type = $type;
        $this->column = $column;
        $this->required = boolval($required);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.input');
    }
}
