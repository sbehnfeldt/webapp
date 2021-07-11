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
use Sbehnfeldt\Webapp\PropelDbEngine\Group as ChildGroup;
use Sbehnfeldt\Webapp\PropelDbEngine\GroupQuery as ChildGroupQuery;
use Sbehnfeldt\Webapp\PropelDbEngine\Map\GroupTableMap;

/**
 * Base class that represents a query for the 'groups' table.
 *
 *
 *
 * @method     ChildGroupQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildGroupQuery orderByGroupname($order = Criteria::ASC) Order by the groupname column
 * @method     ChildGroupQuery orderByDescription($order = Criteria::ASC) Order by the description column
 *
 * @method     ChildGroupQuery groupById() Group by the id column
 * @method     ChildGroupQuery groupByGroupname() Group by the groupname column
 * @method     ChildGroupQuery groupByDescription() Group by the description column
 *
 * @method     ChildGroupQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildGroupQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildGroupQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildGroupQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildGroupQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildGroupQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildGroupQuery leftJoinGroupMemberRelatedByGroupId($relationAlias = null) Adds a LEFT JOIN clause to the query using the GroupMemberRelatedByGroupId relation
 * @method     ChildGroupQuery rightJoinGroupMemberRelatedByGroupId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GroupMemberRelatedByGroupId relation
 * @method     ChildGroupQuery innerJoinGroupMemberRelatedByGroupId($relationAlias = null) Adds a INNER JOIN clause to the query using the GroupMemberRelatedByGroupId relation
 *
 * @method     ChildGroupQuery joinWithGroupMemberRelatedByGroupId($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the GroupMemberRelatedByGroupId relation
 *
 * @method     ChildGroupQuery leftJoinWithGroupMemberRelatedByGroupId() Adds a LEFT JOIN clause and with to the query using the GroupMemberRelatedByGroupId relation
 * @method     ChildGroupQuery rightJoinWithGroupMemberRelatedByGroupId() Adds a RIGHT JOIN clause and with to the query using the GroupMemberRelatedByGroupId relation
 * @method     ChildGroupQuery innerJoinWithGroupMemberRelatedByGroupId() Adds a INNER JOIN clause and with to the query using the GroupMemberRelatedByGroupId relation
 *
 * @method     ChildGroupQuery leftJoinGroupMemberRelatedByUserId($relationAlias = null) Adds a LEFT JOIN clause to the query using the GroupMemberRelatedByUserId relation
 * @method     ChildGroupQuery rightJoinGroupMemberRelatedByUserId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GroupMemberRelatedByUserId relation
 * @method     ChildGroupQuery innerJoinGroupMemberRelatedByUserId($relationAlias = null) Adds a INNER JOIN clause to the query using the GroupMemberRelatedByUserId relation
 *
 * @method     ChildGroupQuery joinWithGroupMemberRelatedByUserId($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the GroupMemberRelatedByUserId relation
 *
 * @method     ChildGroupQuery leftJoinWithGroupMemberRelatedByUserId() Adds a LEFT JOIN clause and with to the query using the GroupMemberRelatedByUserId relation
 * @method     ChildGroupQuery rightJoinWithGroupMemberRelatedByUserId() Adds a RIGHT JOIN clause and with to the query using the GroupMemberRelatedByUserId relation
 * @method     ChildGroupQuery innerJoinWithGroupMemberRelatedByUserId() Adds a INNER JOIN clause and with to the query using the GroupMemberRelatedByUserId relation
 *
 * @method     \Sbehnfeldt\Webapp\PropelDbEngine\GroupMemberQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildGroup|null findOne(ConnectionInterface $con = null) Return the first ChildGroup matching the query
 * @method     ChildGroup findOneOrCreate(ConnectionInterface $con = null) Return the first ChildGroup matching the query, or a new ChildGroup object populated from the query conditions when no match is found
 *
 * @method     ChildGroup|null findOneById(int $id) Return the first ChildGroup filtered by the id column
 * @method     ChildGroup|null findOneByGroupname(string $groupname) Return the first ChildGroup filtered by the groupname column
 * @method     ChildGroup|null findOneByDescription(string $description) Return the first ChildGroup filtered by the description column *

 * @method     ChildGroup requirePk($key, ConnectionInterface $con = null) Return the ChildGroup by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGroup requireOne(ConnectionInterface $con = null) Return the first ChildGroup matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGroup requireOneById(int $id) Return the first ChildGroup filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGroup requireOneByGroupname(string $groupname) Return the first ChildGroup filtered by the groupname column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGroup requireOneByDescription(string $description) Return the first ChildGroup filtered by the description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGroup[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildGroup objects based on current ModelCriteria
 * @method     ChildGroup[]|ObjectCollection findById(int $id) Return ChildGroup objects filtered by the id column
 * @method     ChildGroup[]|ObjectCollection findByGroupname(string $groupname) Return ChildGroup objects filtered by the groupname column
 * @method     ChildGroup[]|ObjectCollection findByDescription(string $description) Return ChildGroup objects filtered by the description column
 * @method     ChildGroup[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class GroupQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Sbehnfeldt\Webapp\PropelDbEngine\Base\GroupQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'webapp', $modelName = '\\Sbehnfeldt\\Webapp\\PropelDbEngine\\Group', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildGroupQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildGroupQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildGroupQuery) {
            return $criteria;
        }
        $query = new ChildGroupQuery();
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
     * @return ChildGroup|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(GroupTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = GroupTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildGroup A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, groupname, description FROM groups WHERE id = :p0';
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
            /** @var ChildGroup $obj */
            $obj = new ChildGroup();
            $obj->hydrate($row);
            GroupTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildGroup|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildGroupQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(GroupTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildGroupQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(GroupTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildGroupQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(GroupTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(GroupTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GroupTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the groupname column
     *
     * Example usage:
     * <code>
     * $query->filterByGroupname('fooValue');   // WHERE groupname = 'fooValue'
     * $query->filterByGroupname('%fooValue%', Criteria::LIKE); // WHERE groupname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $groupname The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGroupQuery The current query, for fluid interface
     */
    public function filterByGroupname($groupname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($groupname)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GroupTableMap::COL_GROUPNAME, $groupname, $comparison);
    }

    /**
     * Filter the query on the description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
     * $query->filterByDescription('%fooValue%', Criteria::LIKE); // WHERE description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGroupQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GroupTableMap::COL_DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query by a related \Sbehnfeldt\Webapp\PropelDbEngine\GroupMember object
     *
     * @param \Sbehnfeldt\Webapp\PropelDbEngine\GroupMember|ObjectCollection $groupMember the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGroupQuery The current query, for fluid interface
     */
    public function filterByGroupMemberRelatedByGroupId($groupMember, $comparison = null)
    {
        if ($groupMember instanceof \Sbehnfeldt\Webapp\PropelDbEngine\GroupMember) {
            return $this
                ->addUsingAlias(GroupTableMap::COL_ID, $groupMember->getGroupId(), $comparison);
        } elseif ($groupMember instanceof ObjectCollection) {
            return $this
                ->useGroupMemberRelatedByGroupIdQuery()
                ->filterByPrimaryKeys($groupMember->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByGroupMemberRelatedByGroupId() only accepts arguments of type \Sbehnfeldt\Webapp\PropelDbEngine\GroupMember or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the GroupMemberRelatedByGroupId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGroupQuery The current query, for fluid interface
     */
    public function joinGroupMemberRelatedByGroupId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('GroupMemberRelatedByGroupId');

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
            $this->addJoinObject($join, 'GroupMemberRelatedByGroupId');
        }

        return $this;
    }

    /**
     * Use the GroupMemberRelatedByGroupId relation GroupMember object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Sbehnfeldt\Webapp\PropelDbEngine\GroupMemberQuery A secondary query class using the current class as primary query
     */
    public function useGroupMemberRelatedByGroupIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinGroupMemberRelatedByGroupId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'GroupMemberRelatedByGroupId', '\Sbehnfeldt\Webapp\PropelDbEngine\GroupMemberQuery');
    }

    /**
     * Use the GroupMemberRelatedByGroupId relation GroupMember object
     *
     * @param callable(\Sbehnfeldt\Webapp\PropelDbEngine\GroupMemberQuery):\Sbehnfeldt\Webapp\PropelDbEngine\GroupMemberQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withGroupMemberRelatedByGroupIdQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useGroupMemberRelatedByGroupIdQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the GroupMemberRelatedByGroupId relation to the GroupMember table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \Sbehnfeldt\Webapp\PropelDbEngine\GroupMemberQuery The inner query object of the EXISTS statement
     */
    public function useGroupMemberRelatedByGroupIdExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('GroupMemberRelatedByGroupId', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the GroupMemberRelatedByGroupId relation to the GroupMember table for a NOT EXISTS query.
     *
     * @see useGroupMemberRelatedByGroupIdExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Sbehnfeldt\Webapp\PropelDbEngine\GroupMemberQuery The inner query object of the NOT EXISTS statement
     */
    public function useGroupMemberRelatedByGroupIdNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('GroupMemberRelatedByGroupId', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Filter the query by a related \Sbehnfeldt\Webapp\PropelDbEngine\GroupMember object
     *
     * @param \Sbehnfeldt\Webapp\PropelDbEngine\GroupMember|ObjectCollection $groupMember the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGroupQuery The current query, for fluid interface
     */
    public function filterByGroupMemberRelatedByUserId($groupMember, $comparison = null)
    {
        if ($groupMember instanceof \Sbehnfeldt\Webapp\PropelDbEngine\GroupMember) {
            return $this
                ->addUsingAlias(GroupTableMap::COL_ID, $groupMember->getUserId(), $comparison);
        } elseif ($groupMember instanceof ObjectCollection) {
            return $this
                ->useGroupMemberRelatedByUserIdQuery()
                ->filterByPrimaryKeys($groupMember->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByGroupMemberRelatedByUserId() only accepts arguments of type \Sbehnfeldt\Webapp\PropelDbEngine\GroupMember or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the GroupMemberRelatedByUserId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGroupQuery The current query, for fluid interface
     */
    public function joinGroupMemberRelatedByUserId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('GroupMemberRelatedByUserId');

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
            $this->addJoinObject($join, 'GroupMemberRelatedByUserId');
        }

        return $this;
    }

    /**
     * Use the GroupMemberRelatedByUserId relation GroupMember object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Sbehnfeldt\Webapp\PropelDbEngine\GroupMemberQuery A secondary query class using the current class as primary query
     */
    public function useGroupMemberRelatedByUserIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinGroupMemberRelatedByUserId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'GroupMemberRelatedByUserId', '\Sbehnfeldt\Webapp\PropelDbEngine\GroupMemberQuery');
    }

    /**
     * Use the GroupMemberRelatedByUserId relation GroupMember object
     *
     * @param callable(\Sbehnfeldt\Webapp\PropelDbEngine\GroupMemberQuery):\Sbehnfeldt\Webapp\PropelDbEngine\GroupMemberQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withGroupMemberRelatedByUserIdQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useGroupMemberRelatedByUserIdQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the GroupMemberRelatedByUserId relation to the GroupMember table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \Sbehnfeldt\Webapp\PropelDbEngine\GroupMemberQuery The inner query object of the EXISTS statement
     */
    public function useGroupMemberRelatedByUserIdExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('GroupMemberRelatedByUserId', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the GroupMemberRelatedByUserId relation to the GroupMember table for a NOT EXISTS query.
     *
     * @see useGroupMemberRelatedByUserIdExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Sbehnfeldt\Webapp\PropelDbEngine\GroupMemberQuery The inner query object of the NOT EXISTS statement
     */
    public function useGroupMemberRelatedByUserIdNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('GroupMemberRelatedByUserId', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Exclude object from result
     *
     * @param   ChildGroup $group Object to remove from the list of results
     *
     * @return $this|ChildGroupQuery The current query, for fluid interface
     */
    public function prune($group = null)
    {
        if ($group) {
            $this->addUsingAlias(GroupTableMap::COL_ID, $group->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the groups table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GroupTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            GroupTableMap::clearInstancePool();
            GroupTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(GroupTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(GroupTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            GroupTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            GroupTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // GroupQuery
