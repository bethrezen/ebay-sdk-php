<?php
/**
 * The contents of this file was generated using the WSDLs as provided by eBay.
 *
 * DO NOT EDIT THIS FILE!
 */

namespace DTS\eBaySDK\Shopping\Types;

/**
 *
 * @property \DTS\eBaySDK\Shopping\Types\SimpleUserType $User
 * @property \DTS\eBaySDK\Shopping\Types\FeedbackHistoryType $FeedbackHistory
 * @property \DTS\eBaySDK\Shopping\Types\FeedbackDetailType[] $FeedbackDetails
 */
class GetUserProfileResponseType extends \DTS\eBaySDK\Shopping\Types\AbstractResponseType
{
    /**
     * @var array Properties belonging to objects of this class.
     */
    private static $propertyTypes = [
        'User' => [
            'type' => 'DTS\eBaySDK\Shopping\Types\SimpleUserType',
            'repeatable' => false,
            'attribute' => false,
            'elementName' => 'User'
        ],
        'FeedbackHistory' => [
            'type' => 'DTS\eBaySDK\Shopping\Types\FeedbackHistoryType',
            'repeatable' => false,
            'attribute' => false,
            'elementName' => 'FeedbackHistory'
        ],
        'FeedbackDetails' => [
            'type' => 'DTS\eBaySDK\Shopping\Types\FeedbackDetailType',
            'repeatable' => true,
            'attribute' => false,
            'elementName' => 'FeedbackDetails'
        ]
    ];

    /**
     * @param array $values Optional properties and values to assign to the object.
     */
    public function __construct(array $values = [])
    {
        list($parentValues, $childValues) = self::getParentValues(self::$propertyTypes, $values);

        parent::__construct($parentValues);

        if (!array_key_exists(__CLASS__, self::$properties)) {
            self::$properties[__CLASS__] = array_merge(self::$properties[get_parent_class()], self::$propertyTypes);
        }

        if (!array_key_exists(__CLASS__, self::$xmlNamespaces)) {
            self::$xmlNamespaces[__CLASS__] = 'xmlns="urn:ebay:apis:eBLBaseComponents"';
        }

        $this->setValues(__CLASS__, $childValues);
    }
}