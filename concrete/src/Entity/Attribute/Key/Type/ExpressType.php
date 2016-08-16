<?php
namespace Concrete\Core\Entity\Attribute\Key\Type;

use Concrete\Core\Entity\Attribute\Value\Value\ExpressValue;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="ExpressAttributeKeyTypes")
 */
class ExpressType extends Type
{

    /**
     * @ORM\ManyToOne(targetEntity="\Concrete\Core\Entity\Express\Entity")
     * @ORM\JoinColumn(name="exEntityID", referencedColumnName="id")
     **/
    protected $entity;

    /**
     * @return mixed
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param mixed $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    public function getAttributeValue()
    {
        return new ExpressValue();
    }

}
