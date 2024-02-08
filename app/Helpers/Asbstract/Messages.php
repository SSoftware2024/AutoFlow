<?php
namespace App\Helpers\Asbstract;
abstract class Messages
{
    protected array $queque = [];

    public function hasQueque()
    {
        return count($this->queque) > 1 ? true:false;
    }
    public function getFirstValue()
    {
        return $this->queque[0];
    }
    public function getQueque()
    {
        return $this->queque;
    }
    public function generate()
    {
        session()->flash('flash_toast', $this->getQueque());
    }
}
