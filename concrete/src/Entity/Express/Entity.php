<?php
namespace Concrete\Core\Entity\Express;

use Concrete\Core\Attribute\CategoryObjectInterface;
use Concrete\Core\Express\Search\ColumnSet\ColumnSet;
use Concrete\Core\Express\Search\ColumnSet\DefaultSet;
use Concrete\Core\Permission\ObjectInterface;
use Concrete\Core\Tree\Node\Node;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\Concrete\Core\Entity\Express\EntityRepository")
 * @ORM\Table(name="ExpressEntities")
 * @ORM\HasLifecycleCallbacks
 */
class Entity implements CategoryObjectInterface, ObjectInterface
{
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected $handle;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(type="object", nullable=true)
     */
    protected $result_column_set;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $include_in_public_list = true;

    /**
     * @ORM\Column(type="integer")
     */
    protected $entity_results_node_id;

    /**
     * @ORM\OneToMany(targetEntity="\Concrete\Core\Entity\Attribute\Key\ExpressKey", mappedBy="entity", cascade={"persist", "remove"})
     **/
    protected $attributes;

    /**
     * @ORM\OneToMany(targetEntity="Association", mappedBy="source_entity", cascade={"persist", "remove"})
     **/
    protected $associations;

    /**
     * @ORM\OneToMany(targetEntity="Form", mappedBy="entity", cascade={"persist", "remove"})
     **/
    protected $forms;

    /**
     * @ORM\OneToOne(targetEntity="Form", cascade={"persist"})
     **/
    protected $default_view_form;

    /**
     * @ORM\OneToOne(targetEntity="Form", cascade={"persist"})
     **/
    protected $default_edit_form;

    /**
     * @ORM\OneToMany(targetEntity="Entry", mappedBy="entity", cascade={"persist", "remove"})
     **/
    protected $entries;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created_date;

    /** @ORM\PostRemove */
    public function afterRemove()
    {
        $node = Node::getByID($this->getEntityResultsNodeId());
        if (is_object($node)) {
            $node->delete();
        }
    }

    public function __construct()
    {
        $this->created_date = new \DateTime();
        $this->attributes = new ArrayCollection();
        $this->forms = new ArrayCollection();
        $this->associations = new ArrayCollection();
        $this->entries = new ArrayCollection();
        $this->result_column_set = new DefaultSet($this->getAttributeKeyCategory());
    }

    /**
     * @return mixed
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * @param mixed $entries
     */
    public function setEntries($entries)
    {
        $this->entries = $entries;
    }

    /**
     * @return mixed
     */
    public function getHandle()
    {
        return $this->handle;
    }

    /**
     * @param mixed $handle
     */
    public function setHandle($handle)
    {
        $this->handle = $handle;
    }

    /**
     * @return mixed
     */
    public function getIncludeInPublicList()
    {
        return $this->include_in_public_list;
    }

    /**
     * @param mixed $include_in_public_list
     */
    public function setIncludeInPublicList($include_in_public_list)
    {
        $this->include_in_public_list = $include_in_public_list;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getCreatedDate()
    {
        return $this->created_date;
    }

    /**
     * @param mixed $created_date
     */
    public function setCreatedDate($created_date)
    {
        $this->created_date = $created_date;
    }

    /**
     * @return ColumnSet
     */
    public function getResultColumnSet()
    {
        return $this->result_column_set;
    }

    /**
     * @param mixed $result_column_set
     */
    public function setResultColumnSet($result_column_set)
    {
        $this->result_column_set = $result_column_set;
    }

    /**
     * @return mixed
     */
    public function getDefaultViewForm()
    {
        return $this->default_view_form;
    }

    /**
     * @param mixed $default_view_form
     */
    public function setDefaultViewForm($default_view_form)
    {
        $this->default_view_form = $default_view_form;
    }

    /**
     * @return mixed
     */
    public function getDefaultEditForm()
    {
        return $this->default_edit_form;
    }

    /**
     * @param mixed $default_edit_form
     */
    public function setDefaultEditForm($default_edit_form)
    {
        $this->default_edit_form = $default_edit_form;
    }


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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return ArrayCollection[]
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * @return mixed
     */
    public function getAssociations()
    {
        return $this->associations;
    }

    /**
     * @param mixed $associations
     */
    public function setAssociations($associations)
    {
        $this->associations = $associations;
    }

    /**
     * @return mixed
     */
    public function getForms()
    {
        return $this->forms;
    }

    /**
     * @param mixed $forms
     */
    public function setForms($forms)
    {
        $this->forms = $forms;
    }

    /**
     * @return mixed
     */
    public function getEntityResultsNodeId()
    {
        return $this->entity_results_node_id;
    }

    /**
     * @param mixed $entity_results_node_id
     */
    public function setEntityResultsNodeId($entity_results_node_id)
    {
        $this->entity_results_node_id = $entity_results_node_id;
    }

    public function getAttributeKeyCategory()
    {
        return \Core::make('\Concrete\Core\Attribute\Category\ExpressCategory', array($this));
    }

    public function getPermissionObjectIdentifier()
    {
        return $this->getId();
    }

    public function getPermissionResponseClassName()
    {
        return '\\Concrete\\Core\\Permission\\Response\\ExpressEntityResponse';
    }

    public function getPermissionAssignmentClassName()
    {
        return false;
    }

    public function getPermissionObjectKeyCategoryHandle()
    {
        return false;
    }

}
