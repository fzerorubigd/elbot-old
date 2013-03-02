<?php
/**
 * Interactive message class
 *
 * This is base on AgaviAttributeHolder class
 * PHP versions 5.3
 *
 * @category  Elbot
 * @package   Interactive
 * @author    fzerorubigd <fzerorubigd@gmail.com>
 * @copyright 2013 Authors
 * @license   Custom <http://cyberrabbits.net>
 * @version   GIT: $Id$
 * @link      http://cyberrabbits.net
 */

namespace Cybits\Interactive;
use Cybits\ParameterHolder;
/**
 * Interactive message class
 *
 * @category  Elbot
 * @package   Interactive
 * @author    fzerorubigd <fzerorubigd@gmail.com>
 * @copyright 2013 Authors
 * @license   Custom <http://cyberrabbits.net>
 * @version   Release: @package_version@
 * @link      http://cyberrabbits.net
 */
class Message extends ParameterHolder
{

    protected $raw;

    protected $parts;
    /**
     * Create new message
     *
     * @param string $raw Input raw message
     *
     * @return void
     */
    public function __construct($raw)
    {
        $this->raw = $raw;
        $this->parts = preg_split("/[\s]+/", $raw, -1, PREG_SPLIT_OFFSET_CAPTURE);
    }

    /**
     * get raw message
     *
     * @return void
     */
    public function getRawMessage()
    {
        return $this->raw;
    }

    /**
     * Get parameter, argv like :)
     *
     * @param integer $position parameter position 0 is the command itself
     * @param boolean $tilEnd   Return from this parameter to the end (this is the last parameter)
     *
     * @return string|null null on no position available
     */
    public function getArg($position, $tilEnd = false)
    {
        if (isset($this->parts[$position])) {
            if ($tilEnd) {
                return substr($this->raw, $this->parts[$position][1]);
            } else {
                return $this->parts[$position][0];
            }
        }
        return null;
    }

    /**
     * argc :)
     *
     * @return integer
     */
    public function getArgCount()
    {
        return count($this->parts);
    }

    /**
     * Get command (parameter 0)
     *
     * @return string
     */
    public function getCommand()
    {
        return $this->getArg(0);
    }

}
