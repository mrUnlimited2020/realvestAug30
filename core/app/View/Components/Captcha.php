<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Captcha extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $path;
    public $label;
    public $formControl;

    public function __construct($path = null, $label = 'form-label', $formControl = 'form-control')
    {
        $this->path = $path;
        $this->label = $label;
        $this->formControl = $formControl;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        if ($this->path) {
            return view($this->path.'.captcha');
        }
        return view('partials.captcha');
    }
}
