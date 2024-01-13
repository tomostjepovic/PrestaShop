<?php
namespace PrestaShop\Module\B2BWholesale\Core\Grid\Query;

use Doctrine\DBAL\Connection;
use PrestaShop\PrestaShop\Core\Grid\Query\AbstractDoctrineQueryBuilder;
use PrestaShop\PrestaShop\Core\Grid\Search\SearchCriteriaInterface;

final class ActivityTypeQueryBuilder extends AbstractDoctrineQueryBuilder
{
    /**
     * @var int
     */
    private $contextLangId;

    /**
     * @var int
     */
    private $contextShopId;

    /**
     * @param Connection $connection
     * @param string $dbPrefix
     * @param int $contextLangId
     * @param int $contextShopId
     */
    public function __construct(Connection $connection, $dbPrefix, $contextLangId, $contextShopId)
    {
        parent::__construct($connection, $dbPrefix);

        $this->contextLangId = $contextLangId;
        $this->contextShopId = $contextShopId;
    }

    public function getSearchQueryBuilder(SearchCriteriaInterface $searchCriteria)
    {
        $qb = $this->getBaseQuery();
        $qb->select('at.id_activity_type, atl.name')
            ->orderBy(
                $searchCriteria->getOrderBy(),
                $searchCriteria->getOrderWay()
            )
            ->setFirstResult($searchCriteria->getOffset())
            ->setMaxResults($searchCriteria->getLimit());

        foreach ($searchCriteria->getFilters() as $filterName => $filterValue) {
            if ('id_activity_type' === $filterName) {
                $qb->andWhere("at.id_activity_type = :$filterName");
                $qb->setParameter($filterName, $filterValue);

                continue;
            }

            $qb->andWhere("$filterName LIKE :$filterName");
            $qb->setParameter($filterName, '%'.$filterValue.'%');
        }

        return $qb;
    }

    public function getCountQueryBuilder(SearchCriteriaInterface $searchCriteria)
    {
        $qb = $this->getBaseQuery();
        $qb->select('COUNT(at.id_activity_type)');

        return $qb;
    }

    private function getBaseQuery()
    {
        return $this->connection
            ->createQueryBuilder()
            ->from($this->dbPrefix.'activity_type', 'at')
            ->leftJoin(
                'at',
                $this->dbPrefix.'activity_type_lang',
                'atl',
                'at.id_activity_type = atl.id_activity_type AND atl.id_lang = :context_lang_id'
            )
            ->leftJoin(
                'at',
                $this->dbPrefix.'activity_type_shop',
                'ats',
                'at.id_activity_type = ats.id_activity_type AND ats.id_shop = :context_shop_id'
            )
            ->setParameter('context_lang_id', $this->contextLangId)
            ->setParameter('context_shop_id', $this->contextShopId)
            ;
    }
}
