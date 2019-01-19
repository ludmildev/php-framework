<?php
namespace Models\BindingModels\Admin;

class EditCategory
{
    private $id;
    private $name;

    public function __construct(array $params)
    {
        $this->setID($params['id']);
        $this->setName($params['name']);
    }

    /**
     * @return string
     */
    public function getID()
    {
        return (int)$this->id;
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

    /**
     * @param string $name
     */
    private function setID($id)
    {
        $this->id = $id;
    }
}