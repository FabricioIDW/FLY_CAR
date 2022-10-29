<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Popup extends Component
{
    public $openBtn;
    public $title;
    public $leftBtn;
    public $rightBtn;
    public $ref;
    public $value;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($openBtn, $title, $leftBtn, $rightBtn, $ref, $value)
    {
        $this->title = $title;
        $this->leftBtn = $leftBtn;
        $this->rightBtn = $rightBtn;
        $this->openBtn = $openBtn;
        $this->ref = $ref;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.popup');
    }
}