<?php
/**
 * Application abstract class
 *
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
use Cybits\Interactive\ConsoleInterface;
/**
 * Application class
 *
 * @category  Elbot
 * @package   Interactive
 * @author    fzerorubigd <fzerorubigd@gmail.com>
 * @copyright 2013 Authors
 * @license   Custom <http://cyberrabbits.net>
 * @version   Release: @package_version@
 * @link      http://cyberrabbits.net
 */

abstract class Application extends ParameterHolder implements ConsoleInterface
{
    protected $server;

    private $_pid;

    private static $_counter = 1;

    /**
     * Construct application
     *
     * @param Server $server Server for this application to run
     *
     * @return void
     */
    public function __construct(Server $server)
    {
        $this->server = $server;
        $this->_pid = self::$_counter . time();
        self::$_counter++;
    }

    /**
     * Boot application
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Pre-Kill application event.
     *
     * @return void
     */
    public function kill()
    {

    }

    /**
     * exit code
     *
     * @param integer $code exit code
     *
     * @return integer
     */
    public function exitCode($code)
    {
        return $this->server->exitCode($code, $this->getPid());
    }

    /**
     * Get server
     *
     * @return Server
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * Get this instance pid
     *
     * @return string
     */
    public final function getPid()
    {
        return $this->getName() . '-' . $this->_pid;
    }

    /**
     * Get application name, just use for pid
     *
     * @return string
     */
    abstract public function getName();


    /**
     * Write a line in this console
     *
     * @param string $line Line to write
     *
     * @return void
     */
    public function writeLine($line)
    {
        $this->server->writeLine($line);
    }

    /**
     * Is this line math this console?
     *
     * @param Message $message Message object
     *
     * @return boolean true if matched false if not matched
     */
    public function match(Message $message)
    {
        return false;
    }

    /**
     * Execute if matched.
     *
     * @param Message $message Message object
     *
     * @return boolean true to stop call the next console, false to continue
     */
    public function execute(Message $message)
    {
        return false;
    }


}
