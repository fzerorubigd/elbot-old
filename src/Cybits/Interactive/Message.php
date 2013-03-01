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

}
