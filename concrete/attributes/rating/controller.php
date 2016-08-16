<?php
namespace Concrete\Attribute\Rating;

use Concrete\Core\Attribute\FontAwesomeIconFormatter;
use Concrete\Core\Entity\Attribute\Key\Type\RatingType;
use Concrete\Core\Entity\Attribute\Value\Value\RatingValue;
use Loader;
use Concrete\Core\Attribute\Controller as AttributeTypeController;

class Controller extends AttributeTypeController
{
    protected $searchIndexFieldDefinition = array(
        'type' => 'decimal',
        'options' => array('precision' => 14, 'scale' => 4, 'default' => 0, 'notnull' => false),
    );

    public function getIconFormatter()
    {
        return new FontAwesomeIconFormatter('star');
    }


    public function getDisplayValue()
    {
        $value = $this->getValue() / 20;
        $rt = $this->app->make('helper/rating');
        return $rt->outputDisplay($value);
    }

    public function form()
    {
        $caValue = 0;
        if (is_object($this->attributeValue)) {
            $caValue = $this->getValue() / 20;
        }
        $rt = Loader::helper('form/rating');
        echo $rt->rating($this->field('value'), $caValue);
    }

    public function searchForm($list)
    {
        $minRating = $this->request('value');
        $minRating = $minRating * 20;
        $list->filterByAttribute($this->attributeKey->getAttributeKeyHandle(), $minRating, '>=');

        return $list;
    }

    public function createAttributeValue($rating)
    {
        $value = new RatingValue();
        if ($rating == '') {
            $rating = 0;
        }
        $value->setValue($rating);

        return $value;
    }

    public function createAttributeValueFromRequest()
    {
        $data = $this->post();
        return $this->createAttributeValue($data['value'] * 20);
    }

    public function search()
    {
        $rt = $this->app->make('helper/form/rating');
        echo $rt->rating($this->field('value'), $this->request('value'));
    }

    public function createAttributeKeyType()
    {
        return new RatingType();
    }
}
