<?php
/**
 * Interactive message class
 *
 * This is base on AgaviAttributeHolder class
 * PHP versions 5.3
 *
 * @category  Elbot
 * @package   Base
 * @author    fzerorubigd <fzerorubigd@gmail.com>
 * @copyright 2013 Authors
 * @license   Custom <http://cyberrabbits.net>
 * @version   GIT: $Id$
 * @link      http://cyberrabbits.net
 */

namespace Cybits;

/**
 * Interactive message class
 *
 * @category  Elbot
 * @package   Base
 * @author    fzerorubigd <fzerorubigd@gmail.com>
 * @copyright 2013 Authors
 * @license   Custom <http://cyberrabbits.net>
 * @version   Release: @package_version@
 * @link      http://cyberrabbits.net
 */
class ParameterHolder
{

    /**
     * Attributes list
     * @var array
     */
    protected $attributes = array();

    /**
     * Default name space
     * @var string
     */
    protected $defaultNamespace = 'org.cybits';

    /**
     * Clear attributes
     *
     * @return nothing
     */
    public function clearAttributes()
    {
        $this->attributes = array();
    }

    /**
     * Get attribute
     *
     * @param string $attr    attribute name
     * @param string $ns      name space to use
     * @param string $default default value
     *
     * @return mixed attribute value
     */
    public function &getAttribute($attr, $ns = null, $default = null)
    {
        if ($ns === null) {
            $ns = $this->defaultNamespace;
        }
        if (isset($this->attributes[$ns])) {
            if (isset($this->attributes[$ns][$attr]) || array_key_exists($attr, $this->attributes[$ns])) {
                return $this->attributes[$ns][$attr];
            }
        }
        return $default;
    }

    /**
     * Set attribute
     *
     * @param string $attr  attribute name
     * @param mixed  $value attribute value
     * @param string $ns    name space
     *
     * @return nothing
     */
    public function setAttribute($attr, $value, $ns = null)
    {
        if ($ns === null) {
            $ns = $this->defaultNamespace;
        }
        if (!isset($this->attributes[$ns])) {
            $this->attributes[$ns] = array();
        }
        $this->attributes[$ns][$attr] = $value;
    }
    /**
     * Remove an attribute and return it
     *
     * @param string $attr attribute name
     * @param string $ns   namespace
     *
     * @return mixed|null
     */
    public function &removeAttribute($attr, $ns = null)
    {
        if ($ns === null) {
            $ns = $this->defaultNamespace;
        }
        $result = null;
        if (isset($this->attributes[$ns])) {
            if (isset($this->attributes[$ns][$attr]) || array_key_exists($attr, $this->attributes[$ns])) {
                $result =& $this->attributes[$ns];
                unset($this->attributes[$ns]);
            }
        }
        return $result;
    }


    /**
     * Get all attributes in name space
     *
     * @param string $ns name space
     *
     * @return array
     */
    public function getAttributes($ns = null)
    {
        if ($ns === null) {
            $ns = $this->defaultNamespace;
        }
        $result = array();

        if (isset($this->attributes[$ns])) {
            $result =& $this->attributes[$ns];
        }
        return $result;
    }

    /**
     * Has attribute
     *
     * @param string $attr attribute name
     * @param string $ns   name space
     *
     * @return boolean
     */
    public function hasAttribute($attr, $ns)
    {
        if ($ns === null) {
            $ns = $this->defaultNamespace;
        }
        if (isset($this->attributes[$ns])) {
            if (isset($this->attributes[$ns][$attr]) || array_key_exists($attr, $this->attributes[$ns])) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get default namespace
     *
     * @return string
     */
    public function getDefaultNamespace()
    {
        return $this->defaultNamespace;
    }

    /**
     * Set default namespace
     *
     * @param string $ns new namespace
     *
     * @return nothing
     */
    public function setDefaultNamespace($ns)
    {
        $this->defaultNamespace = $ns;
    }

    /**
     * Get all namespace in this holder
     *
     * @return array
     */
    public function getAttributeNamespaces()
    {
        return array_keys($this->attributes);
    }

    /**
     * Get all attribute name in a namespace
     *
     * @param string $ns Namespace
     *
     * @return array
     */
    public function getAttributeNames($ns = null)
    {
        if ($ns === null) {
            $ns = $this->defaultNamespace;
        }
        $result = array();

        if (isset($this->attributes[$ns])) {
            $result = array_keys($this->attributes[$ns]);
        }
        return $result;
    }

    /**
     * Has attribute namespace or not
     *
     * @param string $ns namespae
     *
     * @return boolean
     */
    public function hasAttributeNamespace($ns)
    {
        return isset($this->attributes[$ns]);
    }

}
