<?php
namespace Concrete\Core\Entity\Attribute\Key\Type;

use Concrete\Core\Entity\Attribute\Value\Value\BooleanValue;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="BooleanAttributeKeyTypes")
 */
class BooleanType extends Type
{
    /**
     * @ORM\Column(type="boolean")
     */
    protected $akCheckedByDefault = false;

    public function getAttributeTypeHandle()
    {
        return 'boolean';
    }

    /**
     * @return mixed
     */
    public function isCheckedByDefault()
    {
        return $this->akCheckedByDefault;
    }

    /**
     * @param mixed $isCheckedByDefault
     */
    public function setIsCheckedByDefault($isCheckedByDefault)
    {
        $this->akCheckedByDefault = $isCheckedByDefault;
    }

    public function getAttributeValue()
    {
        return new BooleanValue();
    }

}
