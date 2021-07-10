<?php

namespace Sbehnfeldt\Webapp\PropelDbEngine\Map;

use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;
use Sbehnfeldt\Webapp\PropelDbEngine\TokenAuth;
use Sbehnfeldt\Webapp\PropelDbEngine\TokenAuthQuery;


/**
 * This class defines the structure of the 'token_auths' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class TokenAuthTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.TokenAuthTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'webapp';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'token_auths';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Sbehnfeldt\\Webapp\\PropelDbEngine\\TokenAuth';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'TokenAuth';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 4;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 4;

    /**
     * the column name for the id field
     */
    const COL_ID = 'token_auths.id';

    /**
     * the column name for the cookie_hash field
     */
    const COL_COOKIE_HASH = 'token_auths.cookie_hash';

    /**
     * the column name for the expires field
     */
    const COL_EXPIRES = 'token_auths.expires';

    /**
     * the column name for the user_id field
     */
    const COL_USER_ID = 'token_auths.user_id';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'CookieHash', 'Expires', 'UserId', ),
        self::TYPE_CAMELNAME     => array('id', 'cookieHash', 'expires', 'userId', ),
        self::TYPE_COLNAME       => array(TokenAuthTableMap::COL_ID, TokenAuthTableMap::COL_COOKIE_HASH, TokenAuthTableMap::COL_EXPIRES, TokenAuthTableMap::COL_USER_ID, ),
        self::TYPE_FIELDNAME     => array('id', 'cookie_hash', 'expires', 'user_id', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'CookieHash' => 1, 'Expires' => 2, 'UserId' => 3, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'cookieHash' => 1, 'expires' => 2, 'userId' => 3, ),
        self::TYPE_COLNAME       => array(TokenAuthTableMap::COL_ID => 0, TokenAuthTableMap::COL_COOKIE_HASH => 1, TokenAuthTableMap::COL_EXPIRES => 2, TokenAuthTableMap::COL_USER_ID => 3, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'cookie_hash' => 1, 'expires' => 2, 'user_id' => 3, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, )
    );

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var string[]
     */
    protected $normalizedColumnNameMap = [
        'Id' => 'ID',
        'TokenAuth.Id' => 'ID',
        'id' => 'ID',
        'tokenAuth.id' => 'ID',
        'TokenAuthTableMap::COL_ID' => 'ID',
        'COL_ID' => 'ID',
        'token_auths.id' => 'ID',
        'CookieHash' => 'COOKIE_HASH',
        'TokenAuth.CookieHash' => 'COOKIE_HASH',
        'cookieHash' => 'COOKIE_HASH',
        'tokenAuth.cookieHash' => 'COOKIE_HASH',
        'TokenAuthTableMap::COL_COOKIE_HASH' => 'COOKIE_HASH',
        'COL_COOKIE_HASH' => 'COOKIE_HASH',
        'cookie_hash' => 'COOKIE_HASH',
        'token_auths.cookie_hash' => 'COOKIE_HASH',
        'Expires' => 'EXPIRES',
        'TokenAuth.Expires' => 'EXPIRES',
        'expires' => 'EXPIRES',
        'tokenAuth.expires' => 'EXPIRES',
        'TokenAuthTableMap::COL_EXPIRES' => 'EXPIRES',
        'COL_EXPIRES' => 'EXPIRES',
        'token_auths.expires' => 'EXPIRES',
        'UserId' => 'USER_ID',
        'TokenAuth.UserId' => 'USER_ID',
        'userId' => 'USER_ID',
        'tokenAuth.userId' => 'USER_ID',
        'TokenAuthTableMap::COL_USER_ID' => 'USER_ID',
        'COL_USER_ID' => 'USER_ID',
        'user_id' => 'USER_ID',
        'token_auths.user_id' => 'USER_ID',
    ];

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('token_auths');
        $this->setPhpName('TokenAuth');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Sbehnfeldt\\Webapp\\PropelDbEngine\\TokenAuth');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('cookie_hash', 'CookieHash', 'VARCHAR', true, 255, null);
        $this->addColumn('expires', 'Expires', 'TIMESTAMP', true, null, 'CURRENT_TIMESTAMP');
        $this->addForeignKey('user_id', 'UserId', 'INTEGER', 'users', 'id', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('User', '\\Sbehnfeldt\\Webapp\\PropelDbEngine\\User', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':user_id',
    1 => ':id',
  ),
), 'CASCADE', 'NO ACTION', null, false);
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? TokenAuthTableMap::CLASS_DEFAULT : TokenAuthTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (TokenAuth object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = TokenAuthTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = TokenAuthTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + TokenAuthTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = TokenAuthTableMap::OM_CLASS;
            /** @var TokenAuth $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            TokenAuthTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = TokenAuthTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = TokenAuthTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var TokenAuth $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                TokenAuthTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(TokenAuthTableMap::COL_ID);
            $criteria->addSelectColumn(TokenAuthTableMap::COL_COOKIE_HASH);
            $criteria->addSelectColumn(TokenAuthTableMap::COL_EXPIRES);
            $criteria->addSelectColumn(TokenAuthTableMap::COL_USER_ID);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.cookie_hash');
            $criteria->addSelectColumn($alias . '.expires');
            $criteria->addSelectColumn($alias . '.user_id');
        }
    }

    /**
     * Remove all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be removed as they are only loaded on demand.
     *
     * @param Criteria $criteria object containing the columns to remove.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function removeSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->removeSelectColumn(TokenAuthTableMap::COL_ID);
            $criteria->removeSelectColumn(TokenAuthTableMap::COL_COOKIE_HASH);
            $criteria->removeSelectColumn(TokenAuthTableMap::COL_EXPIRES);
            $criteria->removeSelectColumn(TokenAuthTableMap::COL_USER_ID);
        } else {
            $criteria->removeSelectColumn($alias . '.id');
            $criteria->removeSelectColumn($alias . '.cookie_hash');
            $criteria->removeSelectColumn($alias . '.expires');
            $criteria->removeSelectColumn($alias . '.user_id');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(TokenAuthTableMap::DATABASE_NAME)->getTable(TokenAuthTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a TokenAuth or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or TokenAuth object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TokenAuthTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Sbehnfeldt\Webapp\PropelDbEngine\TokenAuth) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(TokenAuthTableMap::DATABASE_NAME);
            $criteria->add(TokenAuthTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = TokenAuthQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            TokenAuthTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                TokenAuthTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the token_auths table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return TokenAuthQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a TokenAuth or Criteria object.
     *
     * @param mixed               $criteria Criteria or TokenAuth object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TokenAuthTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from TokenAuth object
        }

        if ($criteria->containsKey(TokenAuthTableMap::COL_ID) && $criteria->keyContainsValue(TokenAuthTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.TokenAuthTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = TokenAuthQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // TokenAuthTableMap