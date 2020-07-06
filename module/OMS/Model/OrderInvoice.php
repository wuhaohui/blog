<?php


namespace Module\OMS\Model;


class OrderInvoice extends Model
{
    protected $table = 'b2b_order_invoice';

    /**
     * @return \Hyperf\Database\Model\Relations\HasOne|B2bOrder
     */
    public function b2bOrder()
    {
        return $this->hasOne(B2bOrder::class, 'org_id', 'org_id');
    }
}