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
        echo $line;
    }


    /**
     * Register new application in server
     *
     * @param string $name  application name to use for launch
     * @param string $class application class
     *
     * @return boolean
     */
    public function registerApplication($name, $class)
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
        if (isset($this['_application.' . $app])) {
            $appObject = $this['_application.' . $app];
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
        if ($this->launched[$app]) {
            $this->launched[$app]->kill();
            unset($this->launched[$app]);
            return true;
        }
        return false;
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

        }
    }


    /**
     * Run application with parameters
     *
     * @param array $parameters Parameters for this object
     *
     * @return void
     */
    public function run(array $parameters = array())
    {
        foreach ($parameters as $key => $value) {
            $this[$key] = $value;
        }
        if (!isset($this['sleep']) || !is_numeric($this['sleep'])) {
            $this['sleep'] = 1;
        }
        try {
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
                sleep($this['sleep']);
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

}
