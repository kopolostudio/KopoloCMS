<?php
/**
 * A preferences management system.
 *
 * PrefManager can be used for storing user and application preferences,
 * and most other forms of key/value pairs. If required it can also fall
 * back to default values if a value is not defined.
 *
 * PHP versions 4 and 5
 *
 * LICENSE: This source file is subject to version 3.0 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_0.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   Authentication
 * @package    PrefManager
 * @author     Jon Wood <jon@substance-it.co.uk>
 * @copyright  2003-2005 Substance IT
 * @license    http://www.debian.org/misc/bsd.license  BSD License (3 Clause)
 * @version    CVS: $Id: PrefManager.php,v 1.24 2007/06/14 06:43:01 aashley Exp $
 * @link       http://pear.php.net/package/Auth_PrefManager
 */

/**
 * Load DB for data access.
 */
require_once 'DB.php';

/**
 * Main PrefManager class.
 *
 * Uses a table with the following spec:
 *
 * CREATE TABLE `preferences` (
 *   `user_id` varchar( 255 ) NOT null default '',
 *   `pref_id` varchar( 32 ) NOT null default '',
 *   `pref_value` longtext NOT null ,
 *   PRIMARY KEY ( `user_id` , `pref_id` )
 * )
 *
 * @category   Authentication
 * @package    PrefManager
 * @author     Jon Wood <jon@substance-it.co.uk>
 * @author     Adam Ashley <php@adamashley.name>
 * @copyright  2003-2005 Substance IT, 2007 The PHP Group
 * @license    http://www.debian.org/misc/bsd.license  BSD License (3 Clause)
 * @version    Release: @package_version@
 * @link       http://pear.php.net/package/Auth_PrefManager
 */
class Auth_PrefManager
{

    // {{{ properties

    /**
     * The database object.
     *
     * @var object
     * @access private
     */
    var $_db = null;

    /**
     * The DSN to use when connecting
     *
     * @var string
     * @access private
     */
    var $_dsn = "";

    /**
     * The user name to get preferences from if the user specified doesn't
     * have that preference set.
     *
     * @var string
     * @access private
     */
    var $_defaultUser = "__default__";

    /**
     * Should we search for default values, or just fail when we find out that
     * the specified user didn't have it set.
     *
     * @var bool
     * @access private
     */
    var $_returnDefaults = true;

    /**
     * The table containing the preferences.
     *
     * @var string
     * @access private
     */
    var $_table = "preferences";

    /**
     * The column containing user ids.
     *
     * @var string
     * @access private
     */
    var $_userColumn = "user_id";

    /**
     * The column containing preference names.
     *
     * @var string
     * @access private
     */
    var $_nameColumn = "pref_id";

    /**
     * The column containing preference values.
     *
     * @var string
     * @access private
     */
    var $_valueColumn = "pref_value";

    /**
     * The session variable that the cache array is stored in.
     *
     * @var string
     * @access private
     */
     var $_cacheName = "prefCache";

    /**
     * The last error given.
     *
     * @var string
     * @access private
     */
    var $_lastError;

    /**
     * Defines whether the cache should be used or not.
     *
     * @var bool
     * @access private
     */
    var $_useCache = true;

    /**
     * Defines whether values should be serialized before saving.
     *
     * @var bool
     * @access private
     */
    var $_serialize = false;

    /**
     * Return PEAR Error objects on failures
     *
     * @var bool
     * @access private
     */
    var $_usePEARError = false;

    // }}}

    // {{{ Auth_PrefManager() [constructor]

    /**
     * Constructor
     *
     * Options:
     *  table: The table to get prefs from. [preferences]
     *  userColumn: The field name to search for userid's [user_id]
     *  nameColumn: The field name to search for preference names [pref_name]
     *  valueColumn: The field name to search for preference values [pref_value]
     *  defaultUser: The userid assigned to default values [__default__]
     *  cacheName: The name of cache in the session variable ($_SESSION[cacheName]) [prefsCache]
     *  useCache: Whether or not values should be cached.
     *  serialize: Should preference values be serialzed before saving?
     *
     * @param string $dsn The DSN of the database connection to make, or a DB object.
     * @param array $properties An array of properties to set.
     * @param string $defaultUser The default user to manage for.
     * @return void
     * @access public
     */
    function Auth_PrefManager($dsn, $properties = null)
    {
        $this->_dsn = $dsn;

        if (is_array($properties)) {
            if (isset($properties["table"])) {
                $this->_table = $properties["table"];
            }
            if (isset($properties["userColumn"])) {
                $this->_userColumn = $properties["userColumn"];
            }
            if (isset($properties["nameColumn"])) {
                $this->_nameColumn = $properties["nameColumn"];
            }
            if (isset($properties["valueColumn"])) {
                $this->_valueColumn = $properties["valueColumn"];
            }
            if (isset($properties["defaultUser"])) {
                $this->_defaultUser = $properties["defaultUser"];
            }
            if (isset($properties["cacheName"])) {
                $this->_cacheName = $properties["cacheName"];
            }
            if (isset($properties["useCache"])) {
                $this->useCache($properties["useCache"]);
            }
            if (isset($properties["serialize"])) {
                $this->_serialize = $properties["serialize"];
            }
            if (isset($properties["usePEARError"])) {
                $this->_usePEARError = $properties['usePEARError'];
            }
        }
    }

    // }}}

    // {{{ clearCache()

    /**
     * Cleans out the cache.
     *
     * @access public
     */
    function clearCache()
    {
        unset($_SESSION[$this->_cacheName]);
    }

    // }}}
    // {{{ setReturnDefaults()

    /**
     * Sets whether defaults should be returned if a user doesn't have a specific value set
     *
     * @param bool $returnDefaults Should defaults be returned
     * @access public
     */
    function setReturnDefaults($returnDefaults = true)
    {
        $this->_returnDefaults = $returnDefaults;
    }

    // }}}
    // {{{ useCache()

    /**
     * Sets whether the cache should be used.
     *
     * @param bool $use Should the cache be used.
     * @access public
     */
    function useCache($use = true)
    {
        $this->_useCache = $use;
        if ($this->_useCache) {
            if (   !isset($_SESSION[$this->_cacheName])
                || !is_array($_SESSION[$this->_cacheName])) {
                $_SESSION[$this->_cacheName] = array();
            }
        }
    }

    // }}}
    // {{{ usePEARError()

    /**
     * Sets whether PEAR Error objects should be returned on errors
     *
     * @param bool $use Should PEAR Errors be returned on error
     * @access public
     */
    function usePEARError($use = true)
    {
        $this->_usePEARError = $use;
    }

    // }}}

    // {{{ getPref()

    /**
     * Get a preference for the specified user, or, if returning default values
     * is enabled, the default.
     *
     * @param string $user_id The user to get the preference for.
     * @param string $pref_id The preference to get.
     * @param bool $showDefaults Should default values be searched (overrides the global setting).
     * @return mixed The value if it's found, or null if it isn't.
     * @access public
     */
    function getPref($user_id, $pref_id, $showDefaults = true)
    {
        if (   $this->_useCache
            && isset($_SESSION[$this->_cacheName][$user_id][$pref_id])) {

            // Value is cached for the specified user, so give them the cached copy.
            return $_SESSION[$this->_cacheName][$user_id][$pref_id];

        } else {

            $err = $this->_prepare();
            if ($err !== true) {
                return $this->_handleError($err->getMessage(), $err->getCode(), null);
            }

            // Not cached, search the database for this user's preference.
            $sql = "SELECT * FROM ! WHERE ! = ? AND ! = ?";

            $result = $this->_db->query($sql,
                    array(
                        $this->_db->quoteIdentifier($this->_table),
                        $this->_db->quoteIdentifier($this->_userColumn),
                        $user_id,
                        $this->_db->quoteIdentifier($this->_nameColumn),
                        $pref_id,
                        )
                    );

            if (DB::isError($result)) {

                return $this->_handleError($result->getMessage(), $result->getCode(), null);

            } elseif ($result->numRows() > 0) {

                // The query found a value, so we can cache that, and then return it.
                $row = $result->fetchRow(DB_FETCHMODE_ASSOC);

                $value = $this->_unpack($row[$this->_valueColumn]);

                if ($this->_useCache) {
                    $_SESSION[$this->_cacheName][$user_id][$pref_id] = $value;
                }

                return $value;

            } elseif (   $this->_returnDefaults
                      && $showDefaults) {

                return $this->getPref($this->_defaultUser, $pref_id, false);

            } else {

                // We've used up all the resources we're allowed to search, so return a null.
                return null;

            }
        }
    }

    // }}}
    // {{{ getDefaultPref()

    /**
    * A shortcut function for getPref($this->_defaultUser, $pref_id, $value),
    * useful if you have a logged in user, but want to get defaults anyway.
    *
    * @param string $pref_id The name of the preference to get.
    * @return mixed The value if it's found, or null if it isn't.
    * @access public
    */
    function getDefaultPref($pref_id)
    {
        return $this->getPref($this->_defaultUser, $pref_id);
    }

    // }}}

    // {{{ setPref()

    /**
     * Set a preference for the specified user.
     *
     * @param string $user_id The user to set for.
     * @param string $pref_id The preference to set.
     * @param mixed $value The value it should be set to.
     * @return bool Sucess or failure.
     * @access public
     */
    function setPref($user_id, $pref_id, $value)
    {
        $err = $this->_prepare();
        if ($err !== true) {
            return $this->_handleError($err->getMessage(), $err->getCode(), false);
        }

        // Start off by checking if the preference is already set (if it is we need to do
        // an UPDATE, if not, it's an INSERT.
        $exists = $this->_exists($user_id, $pref_id);

        if (PEAR::isError($exists)) {
            return $this->_handleError($exists->getMessage(), $exists->getCode(), false);
        } elseif ($exists === true) {
            $sql = "UPDATE ! SET ! = ? WHERE ! = ? AND ! = ?";

            $result = $this->_db->query($sql,
                    array(
                        $this->_db->quoteIdentifier($this->_table),
                        $this->_db->quoteIdentifier($this->_valueColumn),
                        $this->_pack($value),
                        $this->_db->quoteIdentifier($this->_userColumn),
                        $user_id,
                        $this->_db->quoteIdentifier($this->_nameColumn),
                        $pref_id,
                        )
                    );
        } else {
            $sql = "INSERT INTO ! (!, !, !) VALUES (?, ?, ?)";

            $result = $this->_db->query($sql,
                    array(
                        $this->_db->quoteIdentifier($this->_table),
                        $this->_db->quoteIdentifier($this->_userColumn),
                        $this->_db->quoteIdentifier($this->_nameColumn),
                        $this->_db->quoteIdentifier($this->_valueColumn),
                        $user_id,
                        $pref_id,
                        $this->_pack($value),
                        )
                    );
        }

        if (DB::isError($result)) {
            return $this->_handleError($result->getMessage(), $result->getCode(), false);
        } else {
            if ($this->_useCache) {
                $_SESSION[$this->_cacheName][$user_id][$pref_id] = $value;
            }
            return true;
        }
    }

    // }}}
    // {{{ setDefaultPref()

    /**
    * A shortcut function for setPref($this->_defaultUser, $pref_id, $value)
    *
    * @param string $pref_id The name of the preference to set.
    * @param mixed $value The value to set it to.
    * @return bool Sucess or failure.
    * @access public
    */
    function setDefaultPref($pref_id, $value)
    {
        return $this->setPref($this->_defaultUser, $pref_id, $value);
    }

    // }}}

    // {{{ deletePref()

    /**
    * Deletes a preference for the specified user.
    *
    * @param string $user_id The userid of the user to delete from.
    * @param string $pref_id The preference to delete.
    * @return bool Success/Failure
    * @access public
    */
    function deletePref($user_id, $pref_id)
    {
        $err = $this->_prepare();
        if ($err !== true) {
            return $this->_handleError($err->getMessage(), $err->getCode(), false);
        }

        $exists = $this->_exists($user_id, $pref_id);

        if (PEAR::isError($exists)) {
            return $this->_handleError($exists->getMessage(), $exists->getCode(), false);
        } elseif ($exists === true) {

            $sql = "DELETE FROM ! WHERE ! = ? AND ! = ?";
            $result = $this->_db->query($sql,
                    array(
                        $this->_db->quoteIdentifier($this->_table),
                        $this->_db->quoteIdentifier($this->_userColumn),
                        $user_id,
                        $this->_db->quoteIdentifier($this->_nameColumn),
                        $pref_id,
                        )
                    );

            if (DB::isError($result)) {
                return $this->_handleError($result->getMessage(), $result->getCode(), false);
            } else {
                if ($this->_useCache) {
                    unset($_SESSION[$this->_cacheName][$user_id][$pref_id]);
                }
                return true;
            }
        } else {
            // user doesnt have requested preference
            return true;
        }
    }

    // }}}
    // {{{ deleteDefaultPref()

    /**
    * Deletes a preference for the default user.
    *
    * @param string $pref_id The preference to delete.
    * @return bool Success/Failure
    * @access public
    */
    function deleteDefaultPref($pref_id)
    {
        return $this->deletePref($this->_defaultUser, $pref_id);
    }

    // }}}

    // {{{ _connect()

    /**
     * Connect to the database
     *
     * @param string $dsn The dsn to connect with
     * @return mixed True on success PEAR_Error on failure
     */
    function _connect($dsn) {

        // Connect to the database.
        if (is_string($dsn) || is_array($dsn)) {
            $this->_db = &DB::connect($dsn);
        } else if (is_subclass_of($dsn, 'db_common')) {
            $this->_db = &$dsn;
        } else if (DB::isError($dsn)) {
            $this->_lastError = "DB Error: ".$dsn->getMessage();
            return PEAR::raiseError($dsn->getMessage(), $dsn->getCode());
        } else {
            $this->_lastError = "Invalid DSN specified.";
            return PEAR::raiseError('The given DSN was not valid in file ' . __FILE__ . ' at line ' . __LINE__,
                    41,
                    PEAR_ERROR_RETURN);
        }

        if (DB::isError($this->_db)) {
            $this->_lastError = "DB Error: ".$this->_db->getMessage();
            return PEAR::raiseError($this->_db->getMessage(), $this->_db->getCode());
        } else {
            return true;
        }
    }

    // }}}
    // {{{ _exists()

    /**
     * Checks if a preference exists in the database.
     *
     * @param string $user_id The userid of the preference owner.
     * @param string $pref_id The preference to check for.
     * @return bool True if the preference exists.
     * @access private
     */
    function _exists($user_id, $pref_id)
    {
        $sql = "SELECT COUNT(!) FROM ! WHERE ! = ? AND ! = ?";
        $result = $this->_db->getOne($sql,
                array(
                    $this->_db->quoteIdentifier($this->_nameColumn),
                    $this->_db->quoteIdentifier($this->_table),
                    $this->_db->quoteIdentifier($this->_userColumn),
                    $user_id,
                    $this->_db->quoteIdentifier($this->_nameColumn),
                    $pref_id,
                    )
                );
        if (DB::isError($result)) {
            $this->_lastError = $result->getMessage();
            return PEAR::raiseError($result->getMessage(), $result->getCode());
        } else {
            return $result > 0;
        }
    }

    // }}}
    // {{{ _handleError()

    /**
     * Handle an Error
     *
     * @param string $message The error message to set
     * @param mixed $ret The value to return
     * @return mixed
     */
    function _handleError($message, $code, $ret) {

        $this->_lastError = $message;

        if ($this->_usePEARError) {

            return PEAR::raiseError($message, $code);

        } else {

            return $ret;

        }

    }

    // }}}
    // {{{ _pack()

    /**
     * Does anything needed to prepare a value for saving in the database.
     *
     * @param mixed $value The value to be saved.
     * @return string The value in a format valid for saving to the database.
     * @access private
     */
    function _pack($value)
    {
        if ($this->_serialize) {
            return serialize($value);
        } else {
            return $value;
        }
    }

    // }}}
    // {{{ _prepare()

    /**
     * Make sure we have a database connection
     *
     * @return mixed True or a DB error object
     */
    function _prepare()
    {
        if (!DB::isConnection($this->_db)) {
            $res = $this->_connect($this->_dsn);
            if (PEAR::isError($res)) {
                return $res;
            }
        }
        return true;
    }

    // }}}
    // {{{ _unpack()

    /**
     * Does anything needed to create a value of the preference, such as unserializing.
     *
     * @param string $value The value of the preference.
     * @return mixed The unpacked version of the preference.
     * @access private
     */
    function _unpack($value)
    {
        if ($this->_serialize) {
            return unserialize($value);
        } else {
            return $value;
        }
    }

    // }}}

}

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
?>
