<?php
/**
 * Console server (just for test)
 *
 * PHP versions 5.3
 *
 * @category  Elbot
 * @package   Console
 * @author    fzerorubigd <fzerorubigd@gmail.com>
 * @copyright 2013 Authors
 * @license   Custom <http://cyberrabbits.net>
 * @version   GIT: $Id$
 * @link      http://cyberrabbits.net
 */

namespace Cybits\Interactive\Console;
use Cybits\Interactive\Server as BaseServer;

/**
 * Interactive console
 *
 * @category  Elbot
 * @package   Console
 * @author    fzerorubigd <fzerorubigd@gmail.com>
 * @copyright 2013 Authors
 * @license   Custom <http://cyberrabbits.net>
 * @version   Release: @package_version@
 * @link      http://cyberrabbits.net
 */

class Server extends BaseServer
{
    /**
     * Read line (A raw line, any thing whitout any filter)
     * Wait for a line to read, then return the line.
     *
     * @return string
     */
    public function readLine()
    {
        $text = readline('Elbot Console :>');
        return $text;
    }

    /**
     * Write a rawline in output.
     *
     * @param string $line Line to write into output
     *
     * @return void
     */
    public function writeLine($line)
    {
        echo $line . PHP_EOL;
    }

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
}