<?php

namespace Zoop\Order\DataModel;

use \DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Zoop\Common\DataModel\Address;
use Zoop\Order\DataModel\Total;
use Zoop\Order\DataModel\Commission;

interface OrderInterface
{
    /**
     * @return string
     */
    public function getId();

    /**
     *
     * @return string
     */
    public function getStore();

    /**
     *
     * @return Total
     */
    public function getTotal();

    /**
     *
     * @return string
     */
    public function getShippingMethod();

    /**
     *
     * @return int
     */
    public function getLegacyId();

    /**
     *
     * @return string
     */
    public function getState();

    /**
     *
     * @return History
     */
    public function getHistory();

    /**
     * @return Commission
     */
    public function getCommission();

    /**
     *
     * @return string
     */
    public function getEmail();

    /**
     *
     * @return string
     */
    public function getFirstName();

    /**
     *
     * @return string
     */
    public function getLastName();

    /**
     *
     * @return string
     */
    public function getFullName();

    /**
     *
     * @return string
     */
    public function getPhone();

    /**
     *
     * @return Address
     */
    public function getAddress();

    /**
     *
     * @return string
     */
    public function getCoupon();

    /**
     *
     * @return boolean
     */
    public function getInvoiceSent();

    /**
     *
     * @return ArrayCollection
     */
    public function getPromotions();

    /**
     *
     * @return string
     */
    public function getPaymentMethod();

    /**
     *
     * @return DateTime
     */
    public function getDateCompleted();

    /**
     *
     * @return boolean
     */
    public function getHasProducts();

    /**
     *
     * @return boolean
     */
    public function getIsComplete();

    /**
     *
     * @return boolean
     */
    public function getIsWaitingForPayment();
}
