<?php


namespace Module\OMS\Model;


class B2bOrder extends Model
{
    protected $table = 'b2b_orders';

    /**
     * 关联 sdb_b2c_orders 表  一对一关系
     * @return \Hyperf\Database\Model\Relations\HasOne|B2cOrder
     */
    public function b2cOrder()
    {
        return $this->hasOne(B2cOrder::class, 'order_id', 'org_id');
    }

    /**
     * 关联 order_invoice 表  一对一关系
     * @return \Hyperf\Database\Model\Relations\HasOne|OrderInvoice
     */
    public function orderInvoice()
    {
        return $this->hasOne(OrderInvoice::class, 'org_id', 'org_id');
    }

    /**
     * 关联b2b_allocation 表 一对多关系
     */
    public function allocation()
    {
        return $this->hasMany();
    }
}