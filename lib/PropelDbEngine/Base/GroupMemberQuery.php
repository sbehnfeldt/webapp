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
use Sbehnfeldt\Webapp\PropelDbEngine\GroupMember as ChildGroupMember;
use Sbehnfeldt\Webapp\PropelDbEngine\GroupMemberQuery as ChildGroupMemberQuery;
use Sbehnfeldt\Webapp\PropelDbEngine\Map\GroupMemberTableMap;

/**
 * Base class that represents a query for the 'group_members' table.
 *
 *
 *
 * @method     ChildGroupMemberQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildGroupMemberQuery orderByGroupId($order = Criteria::ASC) Order by the group_id column
 * @method     ChildGroupMemberQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 *
 * @method     ChildGroupMemberQuery groupById() Group by the id column
 * @method     ChildGroupMemberQuery groupByGroupId() Group by the group_id column
 * @method     ChildGroupMemberQuery groupByUserId() Group by the user_id column
 *
 * @method     ChildGroupMemberQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildGroupMemberQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildGroupMemberQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildGroupMemberQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildGroupMemberQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildGroupMemberQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildGroupMemberQuery leftJoinGroupRelatedByGroupId($relationAlias = null) Adds a LEFT JOIN clause to the query using the GroupRelatedByGroupId relation
 * @method     ChildGroupMemberQuery rightJoinGroupRelatedByGroupId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GroupRelatedByGroupId relation
 * @method     ChildGroupMemberQuery innerJoinGroupRelatedByGroupId($relationAlias = null) Adds a INNER JOIN clause to the query using the GroupRelatedByGroupId relation
 *
 * @method     ChildGroupMemberQuery joinWithGroupRelatedByGroupId($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the GroupRelatedByGroupId relation
 *
 * @method     ChildGroupMemberQuery leftJoinWithGroupRelatedByGroupId() Adds a LEFT JOIN clause and with to the query using the GroupRelatedByGroupId relation
 * @method     ChildGroupMemberQuery rightJoinWithGroupRelatedByGroupId() Adds a RIGHT JOIN clause and with to the query using the GroupRelatedByGroupId relation
 * @method     ChildGroupMemberQuery innerJoinWithGroupRelatedByGroupId() Adds a INNER JOIN clause and with to the query using the GroupRelatedByGroupId relation
 *
 * @method     ChildGroupMemberQuery leftJoinGroupRelatedByUserId($relationAlias = null) Adds a LEFT JOIN clause to the query using the GroupRelatedByUserId relation
 * @method     ChildGroupMemberQuery rightJoinGroupRelatedByUserId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GroupRelatedByUserId relation
 * @method     ChildGroupMemberQuery innerJoinGroupRelatedByUserId($relationAlias = null) Adds a INNER JOIN clause to the query using the GroupRelatedByUserId relation
 *
 * @method     ChildGroupMemberQuery joinWithGroupRelatedByUserId($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the GroupRelatedByUserId relation
 *
 * @method     ChildGroupMemberQuery leftJoinWithGroupRelatedByUserId() Adds a LEFT JOIN clause and with to the query using the GroupRelatedByUserId relation
 * @method     ChildGroupMemberQuery rightJoinWithGroupRelatedByUserId() Adds a RIGHT JOIN clause and with to the query using the GroupRelatedByUserId relation
 * @method     ChildGroupMemberQuery innerJoinWithGroupRelatedByUserId() Adds a INNER JOIN clause and with to the query using the GroupRelatedByUserId relation
 *
 * @method     \Sbehnfeldt\Webapp\PropelDbEngine\GroupQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildGroupMember|null findOne(ConnectionInterface $con = null) Return the first ChildGroupMember matching the query
 * @method     ChildGroupMember findOneOrCreate(ConnectionInterface $con = null) Return the first ChildGroupMember matching the query, or a new ChildGroupMember object populated from the query conditions when no match is found
 *
 * @method     ChildGroupMember|null findOneById(int $id) Return the first ChildGroupMember filtered by the id column
 * @method     ChildGroupMember|null findOneByGroupId(int $group_id) Return the first ChildGroupMember filtered by the group_id column
 * @method     ChildGroupMember|null findOneByUserId(int $user_id) Return the first ChildGroupMember filtered by the user_id column *

 * @method     ChildGroupMember requirePk($key, ConnectionInterface $con = null) Return the ChildGroupMember by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGroupMember requireOne(ConnectionInterface $con = null) Return the first ChildGroupMember matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGroupMember requireOneById(int $id) Return the first ChildGroupMember filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGroupMember requireOneByGroupId(int $group_id) Return the first ChildGroupMember filtered by the group_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGroupMember requireOneByUserId(int $user_id) Return the first ChildGroupMember filtered by the user_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGroupMember[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildGroupMember objects based on current ModelCriteria
 * @method     ChildGroupMember[]|ObjectCollection findById(int $id) Return ChildGroupMember objects filtered by the id column
 * @method     ChildGroupMember[]|ObjectCollection findByGroupId(int $group_id) Return ChildGroupMember objects filtered by the group_id column
 * @method     ChildGroupMember[]|ObjectCollection findByUserId(int $user_id) Return ChildGroupMember objects filtered by the user_id column
 * @method     ChildGroupMember[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class GroupMemberQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Sbehnfeldt\Webapp\PropelDbEngine\Base\GroupMemberQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'webapp', $modelName = '\\Sbehnfeldt\\Webapp\\PropelDbEngine\\GroupMember', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildGroupMemberQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildGroupMemberQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildGroupMemberQuery) {
            return $criteria;
        }
        $query = new ChildGroupMemberQuery();
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
     * @return ChildGroupMember|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(GroupMemberTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = GroupMemberTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildGroupMember A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, group_id, user_id FROM group_members WHERE id = :p0';
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
            /** @var ChildGroupMember $obj */
            $obj = new ChildGroupMember();
            $obj->hydrate($row);
            GroupMemberTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildGroupMember|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildGroupMemberQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(GroupMemberTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildGroupMemberQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(GroupMemberTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildGroupMemberQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(GroupMemberTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(GroupMemberTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GroupMemberTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the group_id column
     *
     * Example usage:
     * <code>
     * $query->filterByGroupId(1234); // WHERE group_id = 1234
     * $query->filterByGroupId(array(12, 34)); // WHERE group_id IN (12, 34)
     * $query->filterByGroupId(array('min' => 12)); // WHERE group_id > 12
     * </code>
     *
     * @see       filterByGroupRelatedByGroupId()
     *
     * @param     mixed $groupId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGroupMemberQuery The current query, for fluid interface
     */
    public function filterByGroupId($groupId = null, $comparison = null)
    {
        if (is_array($groupId)) {
            $useMinMax = false;
            if (isset($groupId['min'])) {
                $this->addUsingAlias(GroupMemberTableMap::COL_GROUP_ID, $groupId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($groupId['max'])) {
                $this->addUsingAlias(GroupMemberTableMap::COL_GROUP_ID, $groupId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GroupMemberTableMap::COL_GROUP_ID, $groupId, $comparison);
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
     * @see       filterByGroupRelatedByUserId()
     *
     * @param     mixed $userId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGroupMemberQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(GroupMemberTableMap::COL_USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(GroupMemberTableMap::COL_USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GroupMemberTableMap::COL_USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query by a related \Sbehnfeldt\Webapp\PropelDbEngine\Group object
     *
     * @param \Sbehnfeldt\Webapp\PropelDbEngine\Group|ObjectCollection $group The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGroupMemberQuery The current query, for fluid interface
     */
    public function filterByGroupRelatedByGroupId($group, $comparison = null)
    {
        if ($group instanceof \Sbehnfeldt\Webapp\PropelDbEngine\Group) {
            return $this
                ->addUsingAlias(GroupMemberTableMap::COL_GROUP_ID, $group->getId(), $comparison);
        } elseif ($group instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GroupMemberTableMap::COL_GROUP_ID, $group->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByGroupRelatedByGroupId() only accepts arguments of type \Sbehnfeldt\Webapp\PropelDbEngine\Group or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the GroupRelatedByGroupId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGroupMemberQuery The current query, for fluid interface
     */
    public function joinGroupRelatedByGroupId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('GroupRelatedByGroupId');

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
            $this->addJoinObject($join, 'GroupRelatedByGroupId');
        }

        return $this;
    }

    /**
     * Use the GroupRelatedByGroupId relation Group object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Sbehnfeldt\Webapp\PropelDbEngine\GroupQuery A secondary query class using the current class as primary query
     */
    public function useGroupRelatedByGroupIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinGroupRelatedByGroupId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'GroupRelatedByGroupId', '\Sbehnfeldt\Webapp\PropelDbEngine\GroupQuery');
    }

    /**
     * Use the GroupRelatedByGroupId relation Group object
     *
     * @param callable(\Sbehnfeldt\Webapp\PropelDbEngine\GroupQuery):\Sbehnfeldt\Webapp\PropelDbEngine\GroupQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withGroupRelatedByGroupIdQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useGroupRelatedByGroupIdQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the GroupRelatedByGroupId relation to the Group table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \Sbehnfeldt\Webapp\PropelDbEngine\GroupQuery The inner query object of the EXISTS statement
     */
    public function useGroupRelatedByGroupIdExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('GroupRelatedByGroupId', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the GroupRelatedByGroupId relation to the Group table for a NOT EXISTS query.
     *
     * @see useGroupRelatedByGroupIdExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Sbehnfeldt\Webapp\PropelDbEngine\GroupQuery The inner query object of the NOT EXISTS statement
     */
    public function useGroupRelatedByGroupIdNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('GroupRelatedByGroupId', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Filter the query by a related \Sbehnfeldt\Webapp\PropelDbEngine\Group object
     *
     * @param \Sbehnfeldt\Webapp\PropelDbEngine\Group|ObjectCollection $group The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGroupMemberQuery The current query, for fluid interface
     */
    public function filterByGroupRelatedByUserId($group, $comparison = null)
    {
        if ($group instanceof \Sbehnfeldt\Webapp\PropelDbEngine\Group) {
            return $this
                ->addUsingAlias(GroupMemberTableMap::COL_USER_ID, $group->getId(), $comparison);
        } elseif ($group instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GroupMemberTableMap::COL_USER_ID, $group->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByGroupRelatedByUserId() only accepts arguments of type \Sbehnfeldt\Webapp\PropelDbEngine\Group or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the GroupRelatedByUserId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGroupMemberQuery The current query, for fluid interface
     */
    public function joinGroupRelatedByUserId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('GroupRelatedByUserId');

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
            $this->addJoinObject($join, 'GroupRelatedByUserId');
        }

        return $this;
    }

    /**
     * Use the GroupRelatedByUserId relation Group object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Sbehnfeldt\Webapp\PropelDbEngine\GroupQuery A secondary query class using the current class as primary query
     */
    public function useGroupRelatedByUserIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinGroupRelatedByUserId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'GroupRelatedByUserId', '\Sbehnfeldt\Webapp\PropelDbEngine\GroupQuery');
    }

    /**
     * Use the GroupRelatedByUserId relation Group object
     *
     * @param callable(\Sbehnfeldt\Webapp\PropelDbEngine\GroupQuery):\Sbehnfeldt\Webapp\PropelDbEngine\GroupQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withGroupRelatedByUserIdQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useGroupRelatedByUserIdQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the GroupRelatedByUserId relation to the Group table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \Sbehnfeldt\Webapp\PropelDbEngine\GroupQuery The inner query object of the EXISTS statement
     */
    public function useGroupRelatedByUserIdExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('GroupRelatedByUserId', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the GroupRelatedByUserId relation to the Group table for a NOT EXISTS query.
     *
     * @see useGroupRelatedByUserIdExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Sbehnfeldt\Webapp\PropelDbEngine\GroupQuery The inner query object of the NOT EXISTS statement
     */
    public function useGroupRelatedByUserIdNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('GroupRelatedByUserId', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Exclude object from result
     *
     * @param   ChildGroupMember $groupMember Object to remove from the list of results
     *
     * @return $this|ChildGroupMemberQuery The current query, for fluid interface
     */
    public function prune($groupMember = null)
    {
        if ($groupMember) {
            $this->addUsingAlias(GroupMemberTableMap::COL_ID, $groupMember->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the group_members table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GroupMemberTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            GroupMemberTableMap::clearInstancePool();
            GroupMemberTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(GroupMemberTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(GroupMemberTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            GroupMemberTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            GroupMemberTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // GroupMemberQuery
