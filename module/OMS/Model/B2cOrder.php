<?php


namespace Module\OMS\Model;


class B2cOrder extends Model
{
    protected $table = 'sdb_b2c_orders';

    /**
     * 一对一 关联  b2b_orders表
     * @return \Hyperf\Database\Model\Relations\BelongsTo|B2cOrder
     */
    public function b2bOrder()
    {
        return $this->belongsTo(B2bOrder::class, 'org_id', 'order_id');
    }
}