<?php

namespace Sbehnfeldt\Webapp\PropelDbEngine\Base;

use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Sbehnfeldt\Webapp\PropelDbEngine\LoginAttempt as ChildLoginAttempt;
use Sbehnfeldt\Webapp\PropelDbEngine\LoginAttemptQuery as ChildLoginAttemptQuery;
use Sbehnfeldt\Webapp\PropelDbEngine\Map\LoginAttemptTableMap;

/**
 * Base class that represents a query for the 'login_attempts' table.
 *
 *
 *
 * @method     ChildLoginAttemptQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildLoginAttemptQuery orderByUsername($order = Criteria::ASC) Order by the username column
 * @method     ChildLoginAttemptQuery orderByAttemptedAt($order = Criteria::ASC) Order by the attempted_at column
 * @method     ChildLoginAttemptQuery orderByRemember($order = Criteria::ASC) Order by the remember column
 * @method     ChildLoginAttemptQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method     ChildLoginAttemptQuery orderByLogoutAt($order = Criteria::ASC) Order by the logout_at column
 * @method     ChildLoginAttemptQuery orderByNote($order = Criteria::ASC) Order by the note column
 *
 * @method     ChildLoginAttemptQuery groupById() Group by the id column
 * @method     ChildLoginAttemptQuery groupByUsername() Group by the username column
 * @method     ChildLoginAttemptQuery groupByAttemptedAt() Group by the attempted_at column
 * @method     ChildLoginAttemptQuery groupByRemember() Group by the remember column
 * @method     ChildLoginAttemptQuery groupByUserId() Group by the user_id column
 * @method     ChildLoginAttemptQuery groupByLogoutAt() Group by the logout_at column
 * @method     ChildLoginAttemptQuery groupByNote() Group by the note column
 *
 * @method     ChildLoginAttemptQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildLoginAttemptQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildLoginAttemptQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildLoginAttemptQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildLoginAttemptQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildLoginAttemptQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildLoginAttemptQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     ChildLoginAttemptQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     ChildLoginAttemptQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     ChildLoginAttemptQuery joinWithUser($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the User relation
 *
 * @method     ChildLoginAttemptQuery leftJoinWithUser() Adds a LEFT JOIN clause and with to the query using the User relation
 * @method     ChildLoginAttemptQuery rightJoinWithUser() Adds a RIGHT JOIN clause and with to the query using the User relation
 * @method     ChildLoginAttemptQuery innerJoinWithUser() Adds a INNER JOIN clause and with to the query using the User relation
 *
 * @method     \Sbehnfeldt\Webapp\PropelDbEngine\UserQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildLoginAttempt|null findOne(ConnectionInterface $con = null) Return the first ChildLoginAttempt matching the query
 * @method     ChildLoginAttempt findOneOrCreate(ConnectionInterface $con = null) Return the first ChildLoginAttempt matching the query, or a new ChildLoginAttempt object populated from the query conditions when no match is found
 *
 * @method     ChildLoginAttempt|null findOneById(int $id) Return the first ChildLoginAttempt filtered by the id column
 * @method     ChildLoginAttempt|null findOneByUsername(string $username) Return the first ChildLoginAttempt filtered by the username column
 * @method     ChildLoginAttempt|null findOneByAttemptedAt(string $attempted_at) Return the first ChildLoginAttempt filtered by the attempted_at column
 * @method     ChildLoginAttempt|null findOneByRemember(boolean $remember) Return the first ChildLoginAttempt filtered by the remember column
 * @method     ChildLoginAttempt|null findOneByUserId(int $user_id) Return the first ChildLoginAttempt filtered by the user_id column
 * @method     ChildLoginAttempt|null findOneByLogoutAt(string $logout_at) Return the first ChildLoginAttempt filtered by the logout_at column
 * @method     ChildLoginAttempt|null findOneByNote(string $note) Return the first ChildLoginAttempt filtered by the note column *

 * @method     ChildLoginAttempt requirePk($key, ConnectionInterface $con = null) Return the ChildLoginAttempt by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLoginAttempt requireOne(ConnectionInterface $con = null) Return the first ChildLoginAttempt matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildLoginAttempt requireOneById(int $id) Return the first ChildLoginAttempt filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLoginAttempt requireOneByUsername(string $username) Return the first ChildLoginAttempt filtered by the username column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLoginAttempt requireOneByAttemptedAt(string $attempted_at) Return the first ChildLoginAttempt filtered by the attempted_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLoginAttempt requireOneByRemember(boolean $remember) Return the first ChildLoginAttempt filtered by the remember column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLoginAttempt requireOneByUserId(int $user_id) Return the first ChildLoginAttempt filtered by the user_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLoginAttempt requireOneByLogoutAt(string $logout_at) Return the first ChildLoginAttempt filtered by the logout_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLoginAttempt requireOneByNote(string $note) Return the first ChildLoginAttempt filtered by the note column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildLoginAttempt[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildLoginAttempt objects based on current ModelCriteria
 * @method     ChildLoginAttempt[]|ObjectCollection findById(int $id) Return ChildLoginAttempt objects filtered by the id column
 * @method     ChildLoginAttempt[]|ObjectCollection findByUsername(string $username) Return ChildLoginAttempt objects filtered by the username column
 * @method     ChildLoginAttempt[]|ObjectCollection findByAttemptedAt(string $attempted_at) Return ChildLoginAttempt objects filtered by the attempted_at column
 * @method     ChildLoginAttempt[]|ObjectCollection findByRemember(boolean $remember) Return ChildLoginAttempt objects filtered by the remember column
 * @method     ChildLoginAttempt[]|ObjectCollection findByUserId(int $user_id) Return ChildLoginAttempt objects filtered by the user_id column
 * @method     ChildLoginAttempt[]|ObjectCollection findByLogoutAt(string $logout_at) Return ChildLoginAttempt objects filtered by the logout_at column
 * @method     ChildLoginAttempt[]|ObjectCollection findByNote(string $note) Return ChildLoginAttempt objects filtered by the note column
 * @method     ChildLoginAttempt[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class LoginAttemptQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Sbehnfeldt\Webapp\PropelDbEngine\Base\LoginAttemptQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'webapp', $modelName = '\\Sbehnfeldt\\Webapp\\PropelDbEngine\\LoginAttempt', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildLoginAttemptQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildLoginAttemptQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildLoginAttemptQuery) {
            return $criteria;
        }
        $query = new ChildLoginAttemptQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildLoginAttempt|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(LoginAttemptTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = LoginAttemptTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildLoginAttempt A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, username, attempted_at, remember, user_id, logout_at, note FROM login_attempts WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildLoginAttempt $obj */
            $obj = new ChildLoginAttempt();
            $obj->hydrate($row);
            LoginAttemptTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildLoginAttempt|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildLoginAttemptQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(LoginAttemptTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildLoginAttemptQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(LoginAttemptTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLoginAttemptQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(LoginAttemptTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(LoginAttemptTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LoginAttemptTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the username column
     *
     * Example usage:
     * <code>
     * $query->filterByUsername('fooValue');   // WHERE username = 'fooValue'
     * $query->filterByUsername('%fooValue%', Criteria::LIKE); // WHERE username LIKE '%fooValue%'
     * </code>
     *
     * @param     string $username The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLoginAttemptQuery The current query, for fluid interface
     */
    public function filterByUsername($username = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($username)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LoginAttemptTableMap::COL_USERNAME, $username, $comparison);
    }

    /**
     * Filter the query on the attempted_at column
     *
     * Example usage:
     * <code>
     * $query->filterByAttemptedAt('2011-03-14'); // WHERE attempted_at = '2011-03-14'
     * $query->filterByAttemptedAt('now'); // WHERE attempted_at = '2011-03-14'
     * $query->filterByAttemptedAt(array('max' => 'yesterday')); // WHERE attempted_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $attemptedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLoginAttemptQuery The current query, for fluid interface
     */
    public function filterByAttemptedAt($attemptedAt = null, $comparison = null)
    {
        if (is_array($attemptedAt)) {
            $useMinMax = false;
            if (isset($attemptedAt['min'])) {
                $this->addUsingAlias(LoginAttemptTableMap::COL_ATTEMPTED_AT, $attemptedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($attemptedAt['max'])) {
                $this->addUsingAlias(LoginAttemptTableMap::COL_ATTEMPTED_AT, $attemptedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LoginAttemptTableMap::COL_ATTEMPTED_AT, $attemptedAt, $comparison);
    }

    /**
     * Filter the query on the remember column
     *
     * Example usage:
     * <code>
     * $query->filterByRemember(true); // WHERE remember = true
     * $query->filterByRemember('yes'); // WHERE remember = true
     * </code>
     *
     * @param     boolean|string $remember The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLoginAttemptQuery The current query, for fluid interface
     */
    public function filterByRemember($remember = null, $comparison = null)
    {
        if (is_string($remember)) {
            $remember = in_array(strtolower($remember), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(LoginAttemptTableMap::COL_REMEMBER, $remember, $comparison);
    }

    /**
     * Filter the query on the user_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUserId(1234); // WHERE user_id = 1234
     * $query->filterByUserId(array(12, 34)); // WHERE user_id IN (12, 34)
     * $query->filterByUserId(array('min' => 12)); // WHERE user_id > 12
     * </code>
     *
     * @see       filterByUser()
     *
     * @param     mixed $userId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLoginAttemptQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(LoginAttemptTableMap::COL_USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(LoginAttemptTableMap::COL_USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LoginAttemptTableMap::COL_USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query on the logout_at column
     *
     * Example usage:
     * <code>
     * $query->filterByLogoutAt('2011-03-14'); // WHERE logout_at = '2011-03-14'
     * $query->filterByLogoutAt('now'); // WHERE logout_at = '2011-03-14'
     * $query->filterByLogoutAt(array('max' => 'yesterday')); // WHERE logout_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $logoutAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLoginAttemptQuery The current query, for fluid interface
     */
    public function filterByLogoutAt($logoutAt = null, $comparison = null)
    {
        if (is_array($logoutAt)) {
            $useMinMax = false;
            if (isset($logoutAt['min'])) {
                $this->addUsingAlias(LoginAttemptTableMap::COL_LOGOUT_AT, $logoutAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($logoutAt['max'])) {
                $this->addUsingAlias(LoginAttemptTableMap::COL_LOGOUT_AT, $logoutAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LoginAttemptTableMap::COL_LOGOUT_AT, $logoutAt, $comparison);
    }

    /**
     * Filter the query on the note column
     *
     * Example usage:
     * <code>
     * $query->filterByNote('fooValue');   // WHERE note = 'fooValue'
     * $query->filterByNote('%fooValue%', Criteria::LIKE); // WHERE note LIKE '%fooValue%'
     * </code>
     *
     * @param     string $note The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLoginAttemptQuery The current query, for fluid interface
     */
    public function filterByNote($note = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($note)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LoginAttemptTableMap::COL_NOTE, $note, $comparison);
    }

    /**
     * Filter the query by a related \Sbehnfeldt\Webapp\PropelDbEngine\User object
     *
     * @param \Sbehnfeldt\Webapp\PropelDbEngine\User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildLoginAttemptQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof \Sbehnfeldt\Webapp\PropelDbEngine\User) {
            return $this
                ->addUsingAlias(LoginAttemptTableMap::COL_USER_ID, $user->getId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(LoginAttemptTableMap::COL_USER_ID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByUser() only accepts arguments of type \Sbehnfeldt\Webapp\PropelDbEngine\User or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the User relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildLoginAttemptQuery The current query, for fluid interface
     */
    public function joinUser($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('User');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'User');
        }

        return $this;
    }

    /**
     * Use the User relation User object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Sbehnfeldt\Webapp\PropelDbEngine\UserQuery A secondary query class using the current class as primary query
     */
    public function useUserQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'User', '\Sbehnfeldt\Webapp\PropelDbEngine\UserQuery');
    }

    /**
     * Use the User relation User object
     *
     * @param callable(\Sbehnfeldt\Webapp\PropelDbEngine\UserQuery):\Sbehnfeldt\Webapp\PropelDbEngine\UserQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withUserQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useUserQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the relation to User table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \Sbehnfeldt\Webapp\PropelDbEngine\UserQuery The inner query object of the EXISTS statement
     */
    public function useUserExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('User', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the relation to User table for a NOT EXISTS query.
     *
     * @see useUserExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Sbehnfeldt\Webapp\PropelDbEngine\UserQuery The inner query object of the NOT EXISTS statement
     */
    public function useUserNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('User', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Exclude object from result
     *
     * @param   ChildLoginAttempt $loginAttempt Object to remove from the list of results
     *
     * @return $this|ChildLoginAttemptQuery The current query, for fluid interface
     */
    public function prune($loginAttempt = null)
    {
        if ($loginAttempt) {
            $this->addUsingAlias(LoginAttemptTableMap::COL_ID, $loginAttempt->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the login_attempts table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(LoginAttemptTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            LoginAttemptTableMap::clearInstancePool();
            LoginAttemptTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(LoginAttemptTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(LoginAttemptTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            LoginAttemptTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            LoginAttemptTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // LoginAttemptQuery
