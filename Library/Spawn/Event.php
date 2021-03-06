<?php
/**
* Spawn Framework
*
* Event
* Spawn.Ready
* Spawn.Execute
* Spawn.Finish
* Spawn.Shutdown
* Spawn.404
* Spawn.Redirect
* Spawn.GetAction 
*
* @author  Paweł Makowski
* @copyright (c) 2010-2011 Paweł Makowski
* @license http://spawnframework.com/license New BSD License
*/
namespace Spawn;

class Event
{
    /**
     *
     * @var array
     */
    protected $_event = array();

    /**
     *
     * @var Registry
     */
    protected $_registry;

    /**
     * load events
     */
    public function __construct()
    {
        $this -> _registry = new Registry('Sf');
        $this -> _event = $this -> _registry -> get('Event', array());
    }

    /**
     *
     * @param string $eventName
     * @param array|string $callback
     * @param array $args
     * @return Event
     */
	public function add($eventName, $callback, array $args = array())
	{
	    $this -> _event[ $eventName ][] = array($callback, $args);
	    return $this;
	}

        /**
         *
         * @param string $eventName
         * @return Event
         */
	public function delete($eventName)
	{
	    unset($this -> _event[ $eventName ]);
	    return $this;
	}

        /**
         *
         * @param string $eventName
         * @return Event
         */
	public function run($eventName)
	{
	    if( isset( $this -> _event[ $eventName ] ) ){
	        foreach( $this -> _event[ $eventName ] as $key)
	        {
	            call_user_func_array($key[0], $key[1]);
	        }	    
	    }
	    return $this;
	}

        /**
         * update registry
         */
	public function __destruct()
	{
	    $this -> _registry -> set('Event', $this -> _event);
	}
	
}//Event
