<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_JSON extends Controller {

  protected $_json_vars = array();

  public function before()
  {
    parent::before();
    $this->add('status', 'error');
    
    $this->response->headers('Content-Type', 'application/json');
    $this->profiler = NULL;
    $this->auto_render = FALSE;
  }

  /**
   * Setter method to add a value to the response json string
   *
   * @param string $name
   * @param mixed $value
   * @return void
   */
  public function add($name, $value)
  {
    if (is_null($name))
    {
      $this->_json_vars[] = $value;
    } 
    else 
    {
      $this->_json_vars[$name] = $value;
    }
  }

  /**
   * Setter method that replaces the response json string
   * 
   * @param mixed $value 
   */
  public function set($value)
  {
    $this->_json_vars = $value;
  }
  
  /**
   * Setter method to merge values into the response json string
   * 
   * @param array $values 
   */
  public function merge(Array $values)
  {
    $this->_json_vars = Arr::merge($this->_json_vars, $values);
  }

  public function after()
  {
    $this->response->body(json_encode($this->_json_vars));
    parent::after();
  }
}