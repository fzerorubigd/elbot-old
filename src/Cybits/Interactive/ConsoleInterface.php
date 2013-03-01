<?php
/**
 * Console interface
 *
 * PHP versions 5.3
 *
 * @category  elbot
 * @package   Interactive
 * @author    fzerorubigd <fzerorubigd@gmail.com>
 * @copyright 2013 Authors
 * @license   Custom <http://cyberrabbits.net>
 * @version   GIT: $Id$
 * @link      http://cyberrabbits.net
 */

namespace Cybits\Interactive;

/**
 * Interactive console interface
 *
 * @category  elbot
 * @package   Interactive
 * @author    fzerorubigd <fzerorubigd@gmail.com>
 * @copyright 2013 Authors
 * @license   Custom <http://cyberrabbits.net>
 * @version   Release: @package_version@
 * @link      http://cyberrabbits.net
 */

interface Console
{
    /**
     * Write a line in this console
     *
     * @param string $line Line to write
     *
     * @return void
     */
    public function writeLine($line);

    /**
     * Is this line math this console?
     *
     * @param Message $message Message object
     *
     * @return boolean true if matched false if not matched
     */
    public function match(Message $message);

    /**
     * Execute if matched.
     *
     * @param Message $message Message object
     *
     * @return boolean true to stop call the next console, false to continue
     */
    public function execute(Message $message);
}
