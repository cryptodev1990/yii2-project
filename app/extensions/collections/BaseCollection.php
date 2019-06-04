<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

namespace app\extensions\collections;

use app\extensions\collections\traits\ArrayTrait;
use app\extensions\collections\traits\ConvertibleTrait;
use app\extensions\collections\traits\SortableTrait;
use ArrayAccess;
use Arrayzy\Interfaces\DoubleEndedQueueInterface;
use Arrayzy\Interfaces\TraversableInterface;
use Arrayzy\Traits\DoubleEndedQueueTrait;
use Arrayzy\Traits\TraversableTrait;
use Countable;
use IteratorAggregate;

/**
 * Abstract BaseCollection class to manage elements with improved functionality
 */
abstract class BaseCollection implements DoubleEndedQueueInterface, TraversableInterface,
    IteratorAggregate, ArrayAccess, Countable, CollectionInterface
{
    /**
     * @var array Array of items
     */
    protected $elements;

    /**
     * @var string Specific class to determine item's type
     */
    protected $_itemClass;

    /**
     * Include some helpful traits
     */
    use TraversableTrait,
        ConvertibleTrait,
        DoubleEndedQueueTrait,
        SortableTrait,
        ArrayTrait;
}