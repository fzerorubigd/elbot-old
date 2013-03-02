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
        $cmd = $message->getRawMessage();
        if ($cmd == '!list') {
            foreach ($this->getServer()->getApplications() as $pid => $app) {
                $this->writeLine("-- $pid ..... " . $app->getName());
            }
            return true;
        }
        return false;
    }
}