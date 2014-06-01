<?php

namespace Zoop\Order\DataModel;

use \DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Zoop\Common\DataModel\Address;
use Zoop\Order\DataModel\Total;
use Zoop\Order\DataModel\Commission;
use Zoop\Order\DataModel\OrderInterface;
use Zoop\Store\DataModel\Store;
use Zoop\Order\DataModel\Item\SingleItem;
use Zoop\Order\DataModel\Item\Bundle;
use Zoop\Shard\Stamp\DataModel\CreatedOnTrait;
use Zoop\Shard\Stamp\DataModel\UpdatedOnTrait;
use Zoop\Promotion\DataModel\PromotionInterface;
use Zoop\Payment\DataModel\TransactionInterface;
//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zoop\Shard\Annotation\Annotations as Shard;

/**
 * @ODM\Document
 * @Shard\AccessControl({
 *     @Shard\Permission\Basic(roles="*", allow="*"),
 *     @Shard\Permission\Transition(
 *         roles="*",
 *         allow={
 *             "in-progress->checkout-start",
 *             "checkout-start->payment-in-progress",
 *             "payment-in-progress->redirected-to-third-party-payment",
 *             "payment-in-progress->payment-failed",
 *             "payment-in-progress->waiting-for-payment",
 *             "payment-in-progress->payment-processed",
 *             "redirected-to-third-party-payment->payment-in-progress",
 *             "payment-processed->pending",
 *             "waiting-for-payment->payment-processed",
 *             "waiting-for-payment->payment-failed",
 *             "pending->payment-held",
 *             "pending->payment-reversed",
 *             "pending->payment-charged-back",
 *             "pending->picked",
 *             "pending->packed",
 *             "pending->cancelled",
 *             "pending->shipped",
 *             "pending->partially-refunded",
 *             "pending->fully-refuneded",
 *             "payment-held->payment-released",
 *             "picked->payment-held",
 *             "picked->payment-reversed",
 *             "picked->payment-charged-back",
 *             "picked->partially-refunded",
 *             "picked->fully-refuneded",
 *             "packed->payment-held",
 *             "packed->payment-reversed",
 *             "packed->payment-charged-back",
 *             "packed->partially-refunded",
 *             "packed->fully-refuneded",
 *             "cancelled->payment-held",
 *             "cancelled->payment-reversed",
 *             "cancelled->payment-charged-back",
 *             "cancelled->partially-refunded",
 *             "cancelled->fully-refuneded",
 *             "shipped->payment-held",
 *             "shipped->payment-reversed",
 *             "shipped->payment-charged-back",
 *             "shipped->partially-refunded",
 *             "shipped->fully-refuneded",
 *             "picked->packed",
 *             "packed->shipped"
 *         }
 *     )
 * })
 */
class Order implements OrderInterface
{
    use CreatedOnTrait;
    use UpdatedOnTrait;

    /**
     * @ODM\Id(strategy="UUID")
     */
    protected $id;

    /**
     * @ODM\Int
     * @ODM\Index(unique = true)
     */
    protected $legacyId;

    /**
     * @ODM\ReferenceMany(
     *     discriminatorField="type",
     *     discriminatorMap={
     *         "UnlimitedPromotion"   = "Zoop\Legacy\Promotion\DataModel\UnlimitedPromotion",
     *         "LimitedPromotion"     = "Zoop\Legacy\Promotion\DataModel\LimitedPromotion"
     *     }, 
     *     inversedBy="orders"
     * )
     * @Shard\Serializer\Eager
     * @Shard\Unserializer\Ignore
     */
    protected $promotions;

    /**
     * @ODM\ReferenceMany(
     *     discriminatorField="type",
     *     discriminatorMap={
     *         "UnlimitedPromotion"   = "Zoop\Legacy\Promotion\DataModel\UnlimitedPromotion",
     *         "LimitedPromotion"     = "Zoop\Legacy\Promotion\DataModel\LimitedPromotion"
     *     }, 
     *     inversedBy="orders"
     * )
     * @Shard\Serializer\Eager
     * @Shard\Unserializer\Ignore
     */
    protected $promotionRegistry;

    /**
     * @ODM\String
     * @Shard\Zones
     * @Shard\Validator\Required
     */
    protected $store;

    /**
     *
     * @ODM\EmbedOne(targetDocument="Zoop\Order\DataModel\Total")
     */
    protected $total;

    /**
     *
     * @ODM\EmbedMany(
     *     discriminatorField="type",
     *     discriminatorMap={
     *         "SingleItem"     = "Zoop\Order\DataModel\Item\SingleItem",
     *         "Bundle"         = "Zoop\Order\DataModel\Item\Bundle"
     *     }
     * )
     */
    protected $items;

    /**
     *
     * @ODM\String
     */
    protected $shippingMethod;

    /**
     *
     * @ODM\String
     */
    protected $paymentMethod;

    /**
     * @ODM\String
     * @Shard\State({
     *     "shipped",
     *     "in-progress",
     *     "checkout-start",
     *     "payment-in-progress",
     *     "redirected-to-third-party-payment",
     *     "payment-failed",
     *     "waiting-for-payment",
     *     "payment-reversed",
     *     "payment-processed",
     *     "payment-released",
     *     "payment-held",
     *     "pending",
     *     "picked",
     *     "packed",
     *     "cancelled",
     *     "partially-refunded",
     *     "fully-refunded",
     *     "payment-charged-back"
     * })
     */
    protected $state = 'in-progress';

    /**
     * @ODM\EmbedMany(targetDocument="Zoop\Order\DataModel\History")
     */
    protected $history;

    /**
     * @ODM\EmbedOne(targetDocument="Zoop\Order\DataModel\Commission")
     */
    protected $commission;

    /**
     *
     * @ODM\String
     */
    protected $email;

    /**
     *
     * @ODM\String
     */
    protected $firstName;

    /**
     *
     * @ODM\String
     */
    protected $lastName;

    /**
     *
     * @ODM\String
     */
    protected $phone;

    /**
     *
     * @ODM\EmbedOne(targetDocument="Zoop\Common\DataModel\Address")
     */
    protected $address;

    /**
     *
     * @ODM\String
     */
    protected $coupon;

    /**
     *
     * @ODM\Boolean
     */
    protected $invoiceSent = false;

    /**
     *
     * @ODM\Boolean
     */
    protected $isComplete = false;

    /**
     *
     * @ODM\Boolean
     */
    protected $isWaitingForPayment = false;

    /**
     *
     * @ODM\Date
     */
    protected $dateCompleted;

    /**
     *
     * @ODM\Boolean
     */
    protected $hasProducts = false;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->promotions = new ArrayCollection();
        $this->history = new ArrayCollection();
//        $this->transactions = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @return string
     */
    public function getStore()
    {
        return $this->store;
    }

    /**
     *
     * @param string $store
     */
    public function setStore(Store $store)
    {
        $this->store = $store->getId();
    }

    /**
     *
     * @return Total
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     *
     * @param Total $total
     */
    public function setTotal(Total $total)
    {
        $this->total = $total;
    }

    /**
     *
     * @return string
     */
    public function getShippingMethod()
    {
        return $this->shippingMethod;
    }

    /**
     *
     * @param string $shippingMethod
     */
    public function setShippingMethod($shippingMethod)
    {
        $this->shippingMethod = $shippingMethod;
    }

    /**
     *
     * @return int
     */
    public function getLegacyId()
    {
        return $this->legacyId;
    }

    /**
     *
     * @param int $legacyId
     */
    public function setLegacyId($legacyId)
    {
        $this->legacyId = (int) $legacyId;
    }

    /**
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     *
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     *
     * @return ArrayCollection
     */
    public function getHistory()
    {
        if(!isset($this->history)) {
            $this->history = new ArrayCollection();
        }
        return $this->history;
    }

    /**
     *
     * @param ArrayCollection $history
     */
    public function setHistory(ArrayCollection $history)
    {
        $this->history = $history;
    }

    /**
     *
     * @param Histroy $history
     */
    public function addHistory(Histroy $history)
    {
        $this->getHistory()->add($history);
    }

    /**
     * @return ArrayCollection
     */
    public function getTransactions()
    {
        return $this->transactions;
    }

    /**
     * @param ArrayCollection $transactions
     */
    public function setTransactions($transactions)
    {
        $this->transactions = $transactions;
    }

    /**
     * @param TransactionInterface $transaction
     */
    public function addTransaction(TransactionInterface $transaction)
    {
        $this->getTransactions()->add($transaction);
    }

    /**
     * @return Commission
     */
    public function getCommission()
    {
        return $this->commission;
    }

    /**
     * @param Commission $commission
     */
    public function setCommission(Commission $commission)
    {
        $this->commission = $commission;
    }

    /**
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     *
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     *
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    /**
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     *
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     *
     * @return Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     *
     * @param Address $address
     */
    public function setAddress(Address $address)
    {
        $this->address = $address;
    }

    /**
     *
     * @return string
     */
    public function getCoupon()
    {
        return $this->coupon;
    }

    /**
     *
     * @param string $coupon
     */
    public function setCoupon($coupon)
    {
        $this->coupon = $coupon;
    }

    /**
     *
     * @return boolean
     */
    public function getInvoiceSent()
    {
        return $this->invoiceSent;
    }

    /**
     *
     * @param boolean $invoiceSent
     */
    public function setInvoiceSent($invoiceSent)
    {
        $this->invoiceSent = (bool) $invoiceSent;
    }

    /**
     *
     * @return ArrayCollection
     */
    public function getPromotions()
    {
        return $this->promotions;
    }

    /**
     *
     * @return string
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     *
     * @return DateTime
     */
    public function getDateCompleted()
    {
        return $this->dateCompleted;
    }

    /**
     *
     * @param ArrayCollection $promotions
     */
    public function setPromotions(ArrayCollection $promotions)
    {
        $this->promotions = $promotions;
    }

    /**
     *
     * @param PromotionInterface $promotion
     */
    public function addPromotion(PromotionInterface $promotion)
    {
        if (!$this->getPromotions()->contains($promotion)) {
            $this->getPromotions()->add($promotion);
        }
    }

    public function clearPromotions()
    {
        $this->promotions = new ArrayCollection;
    }

    /**
     *
     * @param string $paymentMethod
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    }

    /**
     *
     * @param DateTime $dateCompleted
     */
    public function setDateCompleted(DateTime $dateCompleted)
    {
        $this->dateCompleted = $dateCompleted;
    }

    /**
     *
     * @return boolean
     */
    public function getHasProducts()
    {
        return (($this->getTotal()->getProductListPrice() > 0) || $this->hasProducts);
    }

    /**
     *
     * @param boolean $hasProducts
     */
    public function setHasProducts($hasProducts)
    {
        $this->hasProducts = (boolean) $hasProducts;
    }

    /**
     *
     * @return boolean
     */
    public function getIsComplete()
    {
        return $this->isComplete;
    }

    /**
     *
     * @param boolean $isComplete
     */
    public function setIsComplete($isComplete)
    {
        $this->isComplete = (boolean) $isComplete;
    }

    /**
     *
     * @return boolean
     */
    public function getIsWaitingForPayment()
    {
        return $this->isWaitingForPayment;
    }

    /**
     *
     * @param boolean $isWaitingForPayment
     */
    public function setIsWaitingForPayment($isWaitingForPayment)
    {
        $this->isWaitingForPayment = (boolean) $isWaitingForPayment;
    }

    /**
     * 
     * @return ArrayCollection
     */
    public function getItems()
    {
        if(!isset($this->items)) {
            $this->items = new ArrayCollection();
        }
        return $this->items;
    }

    /**
     * 
     * @param array|ArrayCollection $items
     */
    public function setItems($items)
    {
        if (!$items instanceof ArrayCollection) {
            $items = new ArrayCollection($items);
        }
        $this->items = $items;
    }

    /**
     * 
     * @param AbstractItem $item
     */
    public function addItem(AbstractItem $item)
    {
        if (!$this->getItems()->contains($item)) {
            $this->getItems()->add($item);
        }
    }
}
