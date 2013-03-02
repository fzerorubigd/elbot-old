<?php
/**
 * Interactive server
 *
 * PHP versions 5.3
 *
 * @category  Elbot
 * @package   Server
 * @author    fzerorubigd <fzerorubigd@gmail.com>
 * @copyright 2013 Authors
 * @license   Custom <http://cyberrabbits.net>
 * @version   GIT: $Id$
 * @link      http://cyberrabbits.net
 */

namespace Cybits\Interactive;
use Pimple;

/**
 * Interactive Server
 *
 * @category  Elbot
 * @package   Server
 * @author    fzerorubigd <fzerorubigd@gmail.com>
 * @copyright 2013 Authors
 * @license   Custom <http://cyberrabbits.net>
 * @version   Release: @package_version@
 * @link      http://cyberrabbits.net
 */
class Server extends Pimple
{
    protected $launched = array();

    protected $autostarts = array();

    private $_state = false;

    /**
     * Read line (A raw line, any thing whitout any filter)
     * Wait for a line to read, then return the line.
     *
     * @return string
     */
    public function readLine()
    {
        throw new \RuntimeException(__CLASS__ . ' must overwrite ' . __METHOD__);
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
        throw new \RuntimeException(__CLASS__ . ' must overwrite ' . __METHOD__);
    }


    /**
     * Register new application in server
     *
     * @param string  $name      application name to use for launch
     * @param string  $class     application class
     * @param boolean $autostart Auto start application or not
     *
     * @return boolean
     */
    public function registerApplication($name, $class, $autostart)
    {
        if (class_exists($class)) {
            $server = &$this;
            $this['_application.' . $name] = function () use ($server, $class) {
                try {
                    $app = new $class($server);
                    if (!$app instanceof Application) {
                        unset($app);
                        return false;
                    }
                    $app->boot();
                    return $app;
                } catch (Exception $e) {
                    return false;
                }
            };
            if ($autostart) {
                $this->autostarts[] = $name;
            }
            return true;
        }
        return false;
    }

    /**
     * Launch application by its name
     *
     * @param string $app Application name
     *
     * @return false|string application pid in case of success
     */
    public function launchApplication($app)
    {
        if (!$this->_state) {
            return false;
        }
        if (isset($this['_application.' . $app])) {
            try {
                $appObject = $this['_application.' . $app];
            } catch (\Exception $e) {
                unset($appObject);
                return false;
            }
            // I prefer to use simple array instead of Pimple
            $this->launched[$appObject->getPid()] = &$appObject;
            return $appObject->getPid();
        }
        return false;
    }

    /**
     * Kill application base on its pid
     *
     * @param string $app Application pid
     *
     * @return false|string application pid in case of success
     */
    public function killApplication($app)
    {
        if (!$this->_state) {
            return false;
        }
        if ($this->launched[$app]) {
            if ($this->launched[$app]->hasAttribute('system') && $this->launched[$app]->getAttribute('system', false) === true) {
                return false;
            }
            $this->launched[$app]->kill();
            unset($this->launched[$app]);
            return true;
        }
        return false;
    }

    /**
     * Get app by its pid
     *
     * @param string $pid Application's pid'
     *
     * @return Application
     */
    public function getApplication($pid)
    {
        if (isset($this->launched[$pid])) {
            return $this->launched[$pid];
        }
        return false;
    }

    /**
     * Get running applications
     *
     * @return array
     */
    public function getApplications()
    {
        return $this->launched;
    }
    /**
     * Process the line and return false to exit
     *
     * @param string $line input string
     *
     * @return boolean false to stop process and exit, anything else to continue
     */
    protected function process($line)
    {
        $message = new Message($line);
        foreach ($this->launched as $pid => $app) {
            $stop = false;
            if ($app->match($message)) {
                $stop = $app->execute($message);
            }
            if ($stop) {
                break;
            }
        }
    }


    /**
     * Run application with parameters
     *
     * @param callable $callable   A callable
     * @param array    $parameters Parameters for this object
     *
     * @return void
     */
    public function run($callable = false, array $parameters = array())
    {
        foreach ($parameters as $key => $value) {
            $this[$key] = $value;
        }
        $this->_state = true; // Set running flag
        try {
            foreach ($this->autostarts as $app) {
                $this->launchApplication($app);
            }
            if (is_callable($callable)) {
                call_user_func($callable, $this);
            }
            while (true) {
                $line = $this->readLine();
                if ($line === false) {
                    break;
                }
                $data = $this->process($line);
                if ($data === false) {
                    break;
                }
                if (is_string($data)) {
                    $data = array($data);
                }
                if (is_array($data)) {
                    foreach ($data as $l) {
                        $this->writeLine($line);
                    }
                }
                if (isset($this['sleep']) && is_numeric($this['sleep'])) {
                    sleep($this['sleep']);
                }

            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

}
