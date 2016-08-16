<?php
namespace Concrete\Core\Entity\Express\Control;

use Concrete\Core\Entity\Express\Entity;
use Concrete\Core\Entity\Express\Entry;
use Concrete\Core\Express\Form\Control\Form\AttributeKeyControlFormRenderer;
use Concrete\Core\Express\Form\Control\View\AttributeKeyControlViewRenderer;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="ExpressFormFieldSetAttributeKeyControls")
 */
class AttributeKeyControl extends Control
{
    /**
     * @ORM\ManyToOne(targetEntity="\Concrete\Core\Entity\Attribute\Key\Key")
     * @ORM\JoinColumn(name="akID", referencedColumnName="akID")
     */
    protected $attribute_key;

    /**
     * @return mixed
     */
    public function getAttributeKey()
    {
        return $this->attribute_key;
    }

    /**
     * @param mixed $attribute_key
     */
    public function setAttributeKey($attribute_key)
    {
        $this->attribute_key = $attribute_key;
    }

    public function getFormControlRenderer(Entry $entry = null)
    {
        return new AttributeKeyControlFormRenderer($entry);
    }

    public function getViewControlRenderer(Entry $entry)
    {
        return new AttributeKeyControlViewRenderer($entry);
    }

    public function getControlLabel()
    {
        return $this->getAttributeKey()->getAttributeKeyDisplayName();
    }

    public function getType()
    {
        return 'attribute_key';
    }

    public function jsonSerialize()
    {
        $data = parent::jsonSerialize();
        $data['attributeType'] = $this->getAttributeKey()->getAttributeTypeHandle();
        return $data;
    }
}
