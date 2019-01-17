<?php
namespace Models\BindingModels\Admin;

class AddCategory
{
    private $name;

    public function __construct(array $params)
    {
        $this->setName($params['name']);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    private function setName($name)
    {
        $this->name = $name;
    }
}