<?php
namespace Models\ViewModels;

class MainViewModel {
    
    private $parts = array();

    public function __construct(array $parts)
    {
        $this->parts = $parts;
    }

    public function getAll()
    {
        return $this->parts;
    }
}