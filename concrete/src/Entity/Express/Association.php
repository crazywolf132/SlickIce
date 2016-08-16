<?php
namespace Concrete\Core\Entity\Express;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\Table(name="ExpressEntityAssociations")
 */
abstract class Association
{
    abstract public function getAssociationBuilder();

    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Entity")
     **/
    protected $source_entity;

    /**
     * @ORM\OneToOne(targetEntity="Entity")
     **/
    protected $target_entity;

    /**
     * @ORM\OneToMany(targetEntity="\Concrete\Core\Entity\Express\Control\AssociationControl", mappedBy="association", cascade={"remove"})
     */
    protected $controls;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $target_property_name;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $inversed_by_property_name;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTargetPropertyName()
    {
        return $this->target_property_name;
    }

    /**
     * @param mixed $name
     */
    public function setTargetPropertyName($target_property_name)
    {
        $this->target_property_name = $target_property_name;
    }

    /**
     * @return mixed
     */
    public function getInversedByPropertyName()
    {
        return $this->inversed_by_property_name;
    }

    /**
     * @param mixed $inversed_by_property_name
     */
    public function setInversedByPropertyName($inversed_by_property_name)
    {
        $this->inversed_by_property_name = $inversed_by_property_name;
    }

    /**
     * @return mixed
     */
    public function getSourceEntity()
    {
        return $this->source_entity;
    }

    /**
     * @param mixed $source_entity
     */
    public function setSourceEntity($source_entity)
    {
        $this->source_entity = $source_entity;
    }

    /**
     * @return mixed
     */
    public function getTargetEntity()
    {
        return $this->target_entity;
    }

    /**
     * @param mixed $target_entity
     */
    public function setTargetEntity($target_entity)
    {
        $this->target_entity = $target_entity;
    }

    public function getComputedTargetPropertyName()
    {
        if ($this->getTargetPropertyName()) {
            return $this->getTargetPropertyName();
        } else {
            return uncamelcase($this->getTargetEntity()->getName());
        }
    }

    public function getComputedInversedByPropertyName()
    {
        if ($this->getInversedByPropertyName()) {
            return $this->getInversedByPropertyName();
        } else {
            return uncamelcase($this->getSourceEntity()->getName());
        }
    }

    abstract public function getFormatter();
    abstract public function getSaveHandler();
}
