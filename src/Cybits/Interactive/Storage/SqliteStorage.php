<?php
/**
 * Sqlite storage
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

namespace Cybits\Interactive\Storage;
use Cybits\Interactive\StorageInterface;
use PDO;

/**
 * Interactive storage for sqlite
 *
 * @category  Cybits
 * @package   Storage
 * @author    fzerorubigd <fzerorubigd@gmail.com>
 * @copyright 2013 Authors
 * @license   Custom <http://cyberrabbits.net>
 * @version   Release: @package_version@
 * @link      http://cyberrabbits.net
 */

class SqliteStorage implements StorageInterface
{

    private $_dsn;

    protected $pdo;

    /**
     * Storage engine constructor
     *
     * @param string $file Sqlite storage
     *
     * @return void
     */
    public function __construct($file)
    {
        $this->_dsn = "sqlite:$file";
        $this->pdo = new PDO($this->_dsn);
        $this->pdo->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
        );
    }
    /**
     * Register new name space.
     *
     * @param string $namespace new namespace ,if already registered there is no need to change
     *
     * @return boolean
     */
    public function registerNamespace($namespace)
    {
        // Create table
        $tableName = md5($namespace);
        try {
            $stmt = $this->pdo->prepare("SELECT name FROM sqlite_master WHERE type='table' AND name='$tableName'");
            $stmt->execute();

            $exist = $stmt->fetch(PDO::FETCH_OBJ);
            if ($exist) {
                return true;
            }
            $this->pdo->exec(
                "CREATE TABLE '$tableName'
                        ('id' INTEGER PRIMARY KEY  NOT NULL ,
                         'key' VARCHAR NOT NULL  UNIQUE ,
                         'value' TEXT)"
            );
            $this->pdo->exec("CREATE UNIQUE INDEX 'keyindex' ON '$tableName' ('key' ASC)");
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

    /**
     * Get data from namespace
     *
     * @param string $namespace a registered namespace
     * @param string $key       Key to get data
     * @param mixed  $default   Default value if not found
     *
     * @return mixed
     */
    public function get($namespace, $key, $default = null)
    {
        $tableName = md5($namespace);
        $stmt = $this->pdo->prepare("SELECT * FROM '$tableName' WHERE \"key\"=:key");
        $stmt->execute(array(':key' => $key));
        $value = $stmt->fetch(PDO::FETCH_OBJ);
        if (!$value) {
            return $default;
        }

        $value = @unserialize($value->value);
        return $value;
    }

    /**
     * Set data into namespace
     *
     * @param string $namespace a registered namespace
     * @param string $key       Key to set data
     * @param mixed  $value     Value to store
     *
     * @return boolean
     */
    public function set($namespace, $key, $value)
    {
        $tableName = md5($namespace);
        $stmt = $this->pdo->prepare("INSERT OR REPLACE INTO '$tableName' (\"key\", \"value\") VALUES (:key, :value)");
        try {
            $stmt->execute(array(':key' => $key, ':value' => serialize($value)));
        } catch (Exception $e) {
            return false;
        }
        return true;
    }


    /**
     * Drop data form namespace
     *
     * @param string $namespace a registered namespace
     * @param string $key       Key to drop
     *
     * @return void
     */
    public function drop($namespace, $key)
    {
        $tableName = md5($namespace);
        $stmt = $this->pdo->prepare("DELETE FROM '$tableName' WHERE \"key\"=:key");
        try {
            $stmt->execute(array(':key' => $key));
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

    /**
     * Un-Register new name space.
     *
     * @param string $namespace namespace to remove
     *
     * @return boolean
     */
    public function unRegisterNamespace($namespace)
    {
        $tableName = md5($namespace);
        try {
            $this->pdo->exec(
                "DROP TABLE IF EXISTS '$tableName'"
            );
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

}
