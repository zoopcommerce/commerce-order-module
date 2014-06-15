<?php

namespace Zoop\Order\DataModel;

use \DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Zoop\Common\DataModel\Address;
use Zoop\Order\DataModel\Item\AbstractItem;
use Zoop\Order\DataModel\Total;
use Zoop\Order\DataModel\Commission;
use Zoop\Order\DataModel\History;
use Zoop\Promotion\DataModel\PromotionInterface;
use Zoop\Store\DataModel\Store;

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
     * @param string $store
     */
    public function setStore(Store $store);

    /**
     *
     * @return Total
     */
    public function getTotal();

    /**
     *
     * @param Total $total
     */
    public function setTotal(Total $total);

    /**
     *
     * @return string
     */
    public function getShippingMethod();

    /**
     *
     * @param string $shippingMethod
     */
    public function setShippingMethod($shippingMethod);

    /**
     *
     * @return int
     */
    public function getLegacyId();

    /**
     *
     * @param int $legacyId
     */
    public function setLegacyId($legacyId);

    /**
     *
     * @return string
     */
    public function getState();

    /**
     *
     * @param string $state
     */
    public function setState($state);

    /**
     *
     * @return ArrayCollection
     */
    public function getHistory();

    /**
     *
     * @param ArrayCollection $history
     */
    public function setHistory(ArrayCollection $history);

    /**
     *
     * @param History $history
     */
    public function addHistory(History $history);

    /**
     * @return Commission
     */
    public function getCommission();

    /**
     *
     * @param Commission $commission
     */
    public function setCommission(Commission $commission);

    /**
     *
     * @return string
     */
    public function getEmail();

    /**
     *
     * @param string $email
     */
    public function setEmail($email);

    /**
     *
     * @return string
     */
    public function getFirstName();

    /**
     *
     * @param string $firstName
     */
    public function setFirstName($firstName);

    /**
     *
     * @return string
     */
    public function getLastName();

    /**
     *
     * @param string $lastName
     */
    public function setLastName($lastName);

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
     * @param string $phone
     */
    public function setPhone($phone);

    /**
     *
     * @return Address
     */
    public function getAddress();

    /**
     *
     * @param Address $address
     */
    public function setAddress(Address $address);

    /**
     *
     * @return string
     */
    public function getCoupon();

    /**
     *
     * @param string $coupon
     */
    public function setCoupon($coupon);

    /**
     *
     * @return boolean
     */
    public function isInvoiceSent();

    /**
     *
     * @param string $coupon
     */
    public function setIsInvoiceSent($invoiceSent);

    /**
     *
     * @return ArrayCollection
     */
    public function getPromotions();

    /**
     *
     * @param ArrayCollection $promotions
     */
    public function setPromotions(ArrayCollection $promotions);

    /**
     *
     * @param PromotionInterface $promotion
     */
    public function addPromotion(PromotionInterface $promotion);

    /**
     *
     * @return string
     */
    public function getPaymentMethod();

    /**
     *
     * @param string $paymentMethod
     */
    public function setPaymentMethod($paymentMethod);

    /**
     *
     * @return DateTime
     */
    public function getDateCompleted();

    /**
     *
     * @param DateTime $dateCompleted
     */
    public function setDateCompleted(DateTime $dateCompleted);

    /**
     *
     * @return boolean
     */
    public function hasProducts();

    /**
     *
     * @return boolean
     */
    public function isComplete();

    /**
     *
     * @param boolean $isComplete
     */
    public function setIsComplete($isComplete);

    /**
     *
     * @return boolean
     */
    public function isWaitingForPayment();

    /**
     *
     * @param boolean $isWaitingForPayment
     */
    public function setIsWaitingForPayment($isWaitingForPayment);
    
     /**
     * 
     * @return ArrayCollection
     */
    public function getItems();

    /**
     * 
     * @param array|ArrayCollection $items
     */
    public function setItems($items);

    /**
     * 
     * @param AbstractItem $item
     */
    public function addItem(AbstractItem $item);
}
