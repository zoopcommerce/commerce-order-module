<?php

namespace Zoop\Order\DataModel;

use \DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Zoop\Order\DataModel\TotalInterface;
use Zoop\Order\DataModel\CommissionInterface;
use Zoop\Order\DataModel\OrderInterface;
use Zoop\Common\DataModel\AddressInterface;
use Zoop\Order\DataModel\HistoryInterface;
use Zoop\Order\DataModel\Item\ItemInterface;
use Zoop\Promotion\DataModel\PromotionInterface;
use Zoop\Shard\Stamp\DataModel\CreatedOnTrait;
use Zoop\Shard\Stamp\DataModel\CreatedByTrait;
use Zoop\Shard\Stamp\DataModel\UpdatedOnTrait;
use Zoop\Shard\Stamp\DataModel\UpdatedByTrait;
use Zoop\Store\DataModel\StoreTraitInterface;
use Zoop\Store\DataModel\StoreTrait;
use Zoop\Payment\DataModel\TransactionInterface;
//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zoop\Shard\Annotation\Annotations as Shard;

/**
 * @ODM\Document
 * @Shard\AccessControl({
 *     @Shard\Permission\Basic(roles="*", allow={"read", "create", "update::*"}),
 *     @Shard\Permission\Basic(
 *          roles={
 *              "zoop::admin",
 *              "partner::admin",
 *              "company::admin",
 *              "store::admin"
 *          },
 *          allow="delete"
 *     ),
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
 * 
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 * @SuppressWarnings(PHPMD.TooManyFields)
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 */
class Order implements OrderInterface, StoreTraitInterface
{
    use CreatedOnTrait;
    use CreatedByTrait;
    use StoreTrait;
    use UpdatedOnTrait;
    use UpdatedByTrait;

    /**
     * @ODM\Id(strategy="UUID")
     */
    protected $id;

    /**
     * @ODM\ReferenceMany(
     *     discriminatorField="type",
     *     discriminatorMap={
     *         "UnlimitedPromotion"   = "Zoop\Promotion\DataModel\UnlimitedPromotion",
     *         "LimitedPromotion"     = "Zoop\Promotion\DataModel\LimitedPromotion"
     *     },
     *     inversedBy="orders"
     * )
     * @Shard\Serializer\Eager
     * @Shard\Unserializer\Ignore
     */
    protected $promotions;

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
    protected $isInvoiceSent = false;

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

    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @return TotalInterface
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     *
     * @param TotalInterface $total
     */
    public function setTotal(TotalInterface $total)
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
     * @return array
     */
    public function getHistory()
    {
        if (!isset($this->history)) {
            $this->history = new ArrayCollection();
        }
        return $this->history;
    }

    /**
     *
     * @param array $history
     */
    public function setHistory($history)
    {
        if (is_array($history)) {
            $this->history = new ArrayCollection($history);
        } else {
            $this->history = $history;
        }
    }

    /**
     *
     * @param HistoryInterface $history
     */
    public function addHistory(HistoryInterface $history)
    {
        $this->getHistory()->add($history);
    }

    /**
     * @return array
     */
    public function getTransactions()
    {
        if (!isset($this->transactions)) {
            $this->transactions = new ArrayCollection();
        }
        return $this->transactions;
    }

    /**
     * @param array $transactions
     */
    public function setTransactions($transactions)
    {
        if (is_array($transactions)) {
            $this->transactions = new ArrayCollection($transactions);
        } else {
            $this->transactions = $transactions;
        }
    }

    /**
     * @param TransactionInterface $transaction
     */
    public function addTransaction(TransactionInterface $transaction)
    {
        $this->getTransactions()->add($transaction);
    }

    /**
     * @return CommissionInterface
     */
    public function getCommission()
    {
        return $this->commission;
    }

    /**
     * @param CommissionInterface $commission
     */
    public function setCommission(CommissionInterface $commission)
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
     * @return AddressInterface
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     *
     * @param AddressInterface $address
     */
    public function setAddress(AddressInterface $address)
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
    public function isInvoiceSent()
    {
        return $this->isInvoiceSent;
    }

    /**
     *
     * @param boolean $isInvoiceSent
     */
    public function setIsInvoiceSent($isInvoiceSent)
    {
        $this->isInvoiceSent = (bool) $isInvoiceSent;
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
     * @return array
     */
    public function getPromotions()
    {
        if (!isset($this->promotions)) {
            $this->promotions = new ArrayCollection;
        }
        return $this->promotions;
    }

    /**
     *
     * @param array|ArrayCollection $promotions
     */
    public function setPromotions($promotions)
    {
        if (is_array($promotions)) {
            $this->promotions = new ArrayCollection($promotions);
        } else {
            $this->promotions = $promotions;
        }
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

    /**
     *
     */
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
    public function hasProducts()
    {
        return count($this->getItems()) > 0;
    }

    /**
     *
     * @return boolean
     */
    public function isComplete()
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
    public function isWaitingForPayment()
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
     * @return array
     */
    public function getItems()
    {
        if (!isset($this->items)) {
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
        if (is_array($items)) {
            $items = new ArrayCollection($items);
        }
        $this->items = $items;
    }

    /**
     *
     * @param ItemInterface $item
     */
    public function addItem(ItemInterface $item)
    {
        if (!$this->getItems()->contains($item)) {
            $this->getItems()->add($item);
        }
    }
}
