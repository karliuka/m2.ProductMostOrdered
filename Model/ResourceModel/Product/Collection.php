<?php
/**
 * Copyright © 2011-2018 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\ProductMostOrdered\Model\ResourceModel\Product;

use Magento\Catalog\Model\ResourceModel\Product\Collection as ProductCollection;

/**
 * Product Most Viewed Collection
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
     * Tables Per Period
     *
     * @var array
     */
    protected $tableForPeriod = [
        'daily'   => 'sales_bestsellers_aggregated_daily',
        'monthly' => 'sales_bestsellers_aggregated_monthly',
        'yearly'  => 'sales_bestsellers_aggregated_yearly',
    ];
    
    /**
     * Set Period
     *
     * @param string $period
     * @return Collection
     */
    public function setPeriod($period)
    {
        $this->_period = $period;
        return $this;
    }
    
    /**
     * Retrieve Table Per Period
     *
     * @param string $period
     * @return mixed
     */
    public function getTableByAggregationPeriod($period)
    {
        return $this->tableForPeriod[$period];
    }
        	
    /**
     * Add Orders Count
     *
     * @param string $from
     * @param string $to
     * @return Collection
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
     * Add Store Availability Filter
     *
     * @param null|string|bool|int|Store $store
     * @return Collection
     */
    public function addStoreFilter($store=null)
    {
        parent::addStoreFilter($store);       
        $this->getSelect()->where('a.store_id=?', $this->getStoreId());        

        return $this;
    }    
}
