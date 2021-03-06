<?php
namespace FW;


class FormViewHelper
{
    private static $_instance = null;
    private $_elements = array();
    private $_addedElements = array();
    private $_currentElementId = 0;
    private $_isInForm = false;
    protected $_additionalTokens = array();

    private function  __construct() {

    }

    public static function init()
    {
        if (self::$_instance == null) {
            self::$_instance = new FormViewHelper();
        }

        return self::$_instance;
    }

    public function initForm($action, $attributes = array(), $method = 'post')
    {
        if ($this->_currentElementId != 0) {
            throw new \Exception('Cannot start form as not first element!', 500);
        }

        $this->_elements['formAttributes'] = $attributes;
        $this->_elements['form']['action'] = $action;
        $this->_elements['form']['method'] = $method;
        $this->_isInForm = true;

        if (strtolower($method) != 'post' && strtolower($method) != 'get')
        {
            $this->_additionalTokens[$method] = '<input type="hidden" name="_method" value="' . $method . '">';
            $this->_elements['form']['method'] = "post";
        }

        return $this;
    }

    public function initTextBox($value = '')
    {
        $this->_elements[$this->_currentElementId]['opening tag'] = '<input type="text" value="'.$value.'"';
        $this->_elements[$this->_currentElementId]['closing tag'] = '>';

        return $this;
    }

    public function initPasswordBox()
    {
        $this->_elements[$this->_currentElementId]['opening tag'] = '<input type="password"';
        $this->_elements[$this->_currentElementId]['closing tag'] = '>';

        return $this;
    }

    public function initTextArea($value = '')
    {
        $this->_elements[$this->_currentElementId]['opening tag'] = '<textarea';
        $this->_elements[$this->_currentElementId]['closing tag'] = ">{$value}</textarea>";

        return $this;
    }

    public function initUploadFile()
    {
        $this->_elements[$this->_currentElementId]['opening tag'] = '<input type="file"';
        $this->_elements[$this->_currentElementId]['closing tag'] = '>';

        return $this;
    }

    public function initRadioBox()
    {
        $this->_elements[$this->_currentElementId]['opening tag'] = '<input type="radio"';
        $this->_elements[$this->_currentElementId]['closing tag'] = '>';

        return $this;
    }

    public function initSubmit()
    {
        $this->_elements[$this->_currentElementId]['opening tag'] = '<input type="submit"';
        $this->_elements[$this->_currentElementId]['closing tag'] = '>';

        return $this;
    }

    public function initLabel()
    {
        $this->_elements[$this->_currentElementId]['opening tag'] = '<label';
        $this->_elements[$this->_currentElementId]['closing tag'] = '</label>';

        return $this;
    }

    public function initCheckBox()
    {
        $this->_elements[$this->_currentElementId]['opening tag'] = '<input type="checkbox"';
        $this->_elements[$this->_currentElementId]['closing tag'] = '>';

        return $this;
    }

    public function initLink()
    {
        $this->_elements[$this->_currentElementId]['opening tag'] = '<a';
        $this->_elements[$this->_currentElementId]['closing tag'] = '</a>';

        return $this;
    }

    public function initDiv()
    {
        $this->_elements[$this->_currentElementId]['opening tag'] = '<div';
        $this->_elements[$this->_currentElementId]['closing tag'] = '</div>';

        return $this;
    }

    public function initBoostrapDropDown($value, $type)
    {
        $this->_elements[$this->_currentElementId]['opening tag'] = ' <' . $type . '>
          <a href="#" role="button">' . $value . '</a><ul>';
        $this->_elements[$this->_currentElementId]['closing tag'] = ' </ul></' . $type . '>';

        return $this;
    }

    public function setDropDownLi($href, $value)
    {
        $this->_elements[$this->_currentElementId]['attributes'][] = '<li><a href="' . $href . '">' . $value . '</a></li>';

        return $this;
    }

    public function setName($name)
    {
        $this->_elements[$this->_currentElementId]['name'] = 'name="' . $name . '"';

        return $this;
    }

    public function setValue($value)
    {
        $this->_elements[$this->_currentElementId]['value'] = '>' . $value;

        return $this;
    }

    public function setAttribute($attribute, $value)
    {
        $this->_elements[$this->_currentElementId]['attributes'][] = $attribute . '="' . $value . '"';

        return $this;
    }

    public function setChecked()
    {
        $this->_elements[$this->_currentElementId]['checked'] = 'checked';

        return $this;
    }

    public function create()
    {
        $element = $this->_elements[$this->_currentElementId];
        $html = $element['opening tag'];

        if (!empty($element['name'])) {
            $html .= ' ' . $element['name'];
        }

        if ($element['attributes'])
        {
            foreach ($element['attributes'] as $attribute) {
                $html .= ' ' . $attribute;
            }
        }

        if (!empty($element['checked'])) {
            $html .= ' ' . $element['checked'];
        }

        if (!empty($element['value'])) {
            $html .= ' ' . $element['value'];
        }

        $html .= $element['closing tag'];

        $this->_addedElements[$this->_currentElementId] = $html;
        unset($this->_elements[$this->_currentElementId]);
        $this->_currentElementId++;

        return $this;
    }

    public function render($samePageToken = false)
    {
        if ($this->_isInForm)
        {
            $action = $this->_elements['form']['action'];
            $method = $this->_elements['form']['method'];
            echo '<form action="' . $action . '" method="' . $method . '"';
            $attributes = $this->_elements['formAttributes'];

            foreach ($attributes as $attribute => $value) {
                echo " " . $attribute . '="' . $value . '"';
            }

            echo '>';

        }

        foreach ($this->_addedElements as $element) {
            echo $element;
        }

        if ($this->_isInForm)
        {
            Token::init()->render($samePageToken);
            if (count($this->_additionalTokens) != 0)
            {
                foreach ($this->_additionalTokens as $token) {
                    echo $token;
                }

            }
            echo '</form>';
        }

        $this->_elements = array();
        $this->_currentElementId = 0;
        $this->_isInForm = false;
        $this->_addedElements = array();
        $this->_additionalTokens = array();
    }
}