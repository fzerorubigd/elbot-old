<?php
/**
 * Storage interface
 *
 * PHP versions 5.3
 *
 * @category  Cybits
 * @package   Storage
 * @author    fzerorubigd <fzerorubigd@gmail.com>
 * @copyright 2013 Authors
 * @license   Custom <http://cyberrabbits.net>
 * @version   GIT: $Id$
 * @link      http://cyberrabbits.net
 */

namespace Cybits\Interactive;

/**
 * Storage interface
 *
 * @category  Cybits
 * @package   Storage
 * @author    fzerorubigd <fzerorubigd@gmail.com>
 * @copyright 2013 Authors
 * @license   Custom <http://cyberrabbits.net>
 * @version   Release: @package_version@
 * @link      http://cyberrabbits.net
 */


interface StorageInterface
{
    /**
     * Register new name space.
     *
     * @param string $namespace new namespace ,if already registered there is no need to change
     *
     * @return boolean
     */
    public function registerNamespace($namespace);

    /**
     * Get data from namespace
     *
     * @param string $namespace a registered namespace
     * @param string $key       Key to get data
     * @param mixed  $default   Default value if not found
     *
     * @return mixed
     */
    public function get($namespace, $key, $default = null);

    /**
     * Set data into namespace
     *
     * @param string $namespace a registered namespace
     * @param string $key       Key to set data
     * @param mixed  $value     Value to store
     *
     * @return mixed
     */
    public function set($namespace, $key, $value);


    /**
     * Drop data form namespace
     *
     * @param string $namespace a registered namespace
     * @param string $key       Key to drop
     *
     * @return void
     */
    public function drop($namespace, $key);

    /**
     * Un-Register new name space.
     *
     * @param string $namespace namespace to remove
     *
     * @return boolean
     */
    public function unRegisterNamespace($namespace);

}