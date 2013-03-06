<?php
/**
 * System application
 *
 * PHP versions 5.3
 *
 * @category  Elbit
 * @package   Application
 * @author    fzerorubigd <fzerorubigd@gmail.com>
 * @copyright 2013 Authors
 * @license   Custom <http://cyberrabbits.net>
 * @version   GIT: $Id$
 * @link      http://cyberrabbits.net
 */

namespace Cybits\Interactive\Application;
use Cybits\Interactive\Application as BaseApplication;
use Cybits\Interactive\Message;
/**
 * System application
 *
 * @category  Elbit
 * @package   Application
 * @author    fzerorubigd <fzerorubigd@gmail.com>
 * @copyright 2013 Authors
 * @license   Custom <http://cyberrabbits.net>
 * @version   Release: @package_version@
 * @link      http://cyberrabbits.net
 */

class System extends BaseApplication
{
    protected static $count = 0;

    const NS  = 'interactive.application.system';
    /**
     * Boot application
     *
     * @return void
     */
    public function boot()
    {
        if (self::$count > 0) {
            throw new \Exception('Can not launch more than one instance of this application');
        }
        self::$count++;
        $this->setAttribute('system', true);
        $this->server['storage']->registerNamespace(self::NS);
        $this->server['storage']->set(self::NS, 'test', array(1,2,3,4,5));
        print_r($this->server['storage']->get(self::NS, 'test'));
        $this->server['storage']->drop(self::NS, 'test');

        $this->writeLine("Starting system application");
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
     * Get application name, just use for pid
     *
     * @return string
     */
    public function getName()
    {
        return "system";
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
        $msg = $message->getRawMessage();
        if (strlen($msg) > 1 && $msg{0} == '!') {
            return true;
        }
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
        $cmd = $message->getCommand();
        switch ($cmd) {
        case '!list' :
            $this->listCommand($message);
            return true;
        case '!test' :
            $this->testCommand($message);
            return true;
        case '!kill' :
            $this->killCommand($message);
            return true;
        default:
        }
        return false;
    }

    /**
     * Run list command
     *
     * @param Message $message the run command
     *
     * @return void
     */
    protected function listCommand(Message $message)
    {
        foreach ($this->getServer()->getApplications() as $pid => $app) {
            $this->writeLine("-- $pid ..... " . $app->getName());
        }
    }

    /**
     * Run kill command
     *
     * @param Message $message the run command
     *
     * @return void
     */
    protected function killCommand(Message $message)
    {

    }

    /**
     * Run list command
     *
     * @param Message $message the run command
     *
     * @return void
     */
    protected function testCommand(Message $message)
    {
        $i = 0;
        while ($param = $message->getArg($i)) {
            $i++;
            $this->writeLine($param . '.');
        }
    }

}