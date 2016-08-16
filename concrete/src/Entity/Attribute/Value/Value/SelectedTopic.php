<?php
namespace Concrete\Core\Entity\Attribute\Value\Value;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="TopicAttributeSelectedTopics")
 */
class SelectedTopic
{
    /**
     * @ORM\Id @ORM\Column(type="integer", options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $avTreeTopicNodeID;

    /**
     * @ORM\ManyToOne(targetEntity="TopicsValue")
     * @ORM\JoinColumn(name="avID", referencedColumnName="avID")
     */
    protected $value;

    /**
     * @ORM\Column(type="integer", options={"unsigned":true})
     */
    protected $treeNodeID;

    /**
     * @return mixed
     */
    public function getTreeNodeID()
    {
        return $this->treeNodeID;
    }

    /**
     * @param mixed $treeNodeID
     */
    public function setTreeNodeID($treeNodeID)
    {
        $this->treeNodeID = $treeNodeID;
    }

    /**
     * @return mixed
     */
    public function getAttributeValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setAttributeValue($value)
    {
        $this->value = $value;
    }
}
