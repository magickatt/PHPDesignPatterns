<?php

namespace Memento;

/**
 * Memento design pattern
 * 
 * There are various ways of tracking the changes made to an object, many that
 * are more graceful and performant than this, but this should demonstrate a 
 * relatively simple way to track the changes made to an object in a 
 * transactional way
 * @author Andrew Kirkpatrick <info@andrew-kirkpatrick.com>
 */
final class Memento
{
    /**
     * Name (of the thing)
     * @var string
     */
    private $name;
    
    /**
     * Gender (or sex if you're from a bygone era)
     * @var string
     */
    private $gender;
    
    /**
     * Age (in human years, not dog years)
     * @var integer
     */
    private $age;
    
    /**
     * Revision history of current Memento object
     * @var Memento[] Memento objects in LIFO stack
     */
    private $revisions = array();
    
    /**
     * Get a property
     * @param string $name
     * @return mixed|null
     */
    public function __get($name)
    {
        //
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        return null;
    }
    
    /**
     * Set a property
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        // If the property exists...
        if (property_exists($this, $name)) {

            // Clone the current object and add as a revision
            $clone = clone($this);
            $this->addRevision($clone);
            
            // Set the property
            $this->$name = $value;
        }
    }
    
    /**
     * Commit changes (discard all previous revisions)
     * 
     * Discards the previous revisions of this object so that changes are now 
     * final
     */
    public function commit()
    {
        $this->clearRevisions();
    }
    
    /**
     * Rollback changes
     * @param integer $depth How many revisions to rollback
     */
    public function rollback($depth = 0)
    {
        // If no depth is specified, rollback to the oldest revision
        if ((integer) $depth <= 0) {
            $depth = count($this);
        }
            
        // Pop revisions from the stack until the specified depth is reached
        for ($x = 1; $x <= $depth; $x++) {
            $rollbackRevision = array_pop($this->revisions);
        }
        
        // Iterate over each property of the revision
        foreach (get_object_vars($rollbackRevision) as $property => $value) {
        
            // Set the property of the current object to that of the revision
            $this->$property = $value;
            
        }
    }
    
    /**
     * Add a revision
     * @param self $object
     */
    private function addRevision(self $object)
    {
        $this->revisions[] = $object;
    }
    
    /**
     * Clear revisions
     */
    private function clearRevisions()
    {
        $this->revisions = array();
    }
}