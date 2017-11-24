<?php
/**
 * Copyright © 2011-2017 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\ProductMostOrdered\Model\ResourceModel\Product;

use Magento\Catalog\Model\ResourceModel\Product\Collection as ProductCollection;

/**
 * Catalog product most viewed items collection
 *
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class Collection extends ProductCollection
{
    /**
     * Period
     *
     * @var string
     */
    protected $_period;
    	
    /**
     * Tables per period
     *
     * @var array
     */
    protected $tableForPeriod = [
        'daily'   => 'sales_bestsellers_aggregated_daily',
        'monthly' => 'sales_bestsellers_aggregated_monthly',
        'yearly'  => 'sales_bestsellers_aggregated_yearly',
    ];
    
    /**
     * Set period
     * @codeCoverageIgnore
     *
     * @param string $period
     * @return $this
     */
    public function setPeriod($period)
    {
        $this->_period = $period;
        return $this;
    }
    
    /**
     * Return table per period
     *
     * @param string $period
     * @return mixed
     */
    public function getTableByAggregationPeriod($period)
    {
        return $this->tableForPeriod[$period];
    }
        	
    /**
     * Add orders count
     *
     * @param string $from
     * @param string $to
     * @return $this
     */
    public function addOrdersCount($from='', $to='')
    {
        $this->getSelect()
			->join(
				['a' => $this->getTable($this->getTableByAggregationPeriod($this->_period))],
				'e.entity_id = a.product_id',
				['ordered_qty' => 'SUM(a.qty_ordered)']
			)
			->group('e.entity_id')
			->order('ordered_qty ' . self::SORT_ORDER_DESC);

        if ($from != '' && $to != '') {
            $this->getSelect()
				->where('a.period >= ?', $from)
				->where('a.period <= ?', $to);
        }
        return $this;
    }
    
    /**
     * Add store availability filter. Include availability product
     * for store website
     *
     * @param null|string|bool|int|Store $store
     * @return $this
     */
    public function addStoreFilter($store=null)
    {
        parent::addStoreFilter($store);       
        $this->getSelect()->where('a.store_id=?', $this->getStoreId());        

        return $this;
    }    
}
