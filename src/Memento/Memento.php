<?php

namespace Memento;

final class Memento
{
    /**
     * 
     * @var unknown_type
     */
    private $name;
    
    /**
     * 
     * @var unknown_type
     */
    private $gender;
    
    /**
     * 
     * @var unknown_type
     */
    private $age;
    
    /**
     * 
     * @var array Memento objects in LIFO stack
     */
    private $revisions = array();
    
    public function __get($name)
    {
        //
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        return null;
    }
    
    public function __set($name, $value)
    {
        //
        if (property_exists($this, $name)) {

            //
            $clone = clone($this);
            $this->addRevision($clone);
            
            //
            $clone->$name = $value;
        }
    }
    
    public function commit()
    {
        //
        $latest = array_pop($this->revisions);
        
        //
        foreach (get_object_vars($latest) as $property => $value) {
            
            //
            $this->$property = $value;
        }
        
        $this->revisions = array();
    }
    
    public function rollback($depth = 0)
    {
        //
        if ((integer) $depth > 0) {
            
            //
            for ($x = 1; $x <= $depth; $x++) {
                array_pop($this->revisions);
            }

        //
        } else {
            $this->clearRevisions();
        }
    }
    
    private function addRevision(self $object)
    {
        $this->revisions[] = $object;
    }
    
    private function clearRevisions()
    {
        $this->revisions = array();
    }
}