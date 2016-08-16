<?php
namespace Concrete\Controller\Backend;

use Concrete\Core\Tree\Node\Node;
use Symfony\Component\HttpFoundation\JsonResponse;

class Tree extends UserInterface
{
    protected $tree;

    protected function getTree()
    {
        if (!isset($this->tree)) {
            $treeID = \Loader::helper('security')->sanitizeInt($_REQUEST['treeID']);
            $this->tree = \Concrete\Core\Tree\Tree::getByID($treeID);
        }
        return $this->tree;
    }

    protected function canAccess()
    {
        $tree = $this->getTree();
        $node = $tree->getRootTreeNodeObject();
        $np = new \Permissions($node);
        return $np->canViewTreeNode();
    }

    public function load()
    {
        $tree = $this->getTree();
        if (is_array($_REQUEST['treeNodeSelectedIDs'])) {
            $selectedIDs = array();
            foreach ($_REQUEST['treeNodeSelectedIDs'] as $nID) {
                $node = Node::getByID($nID);
                if (is_object($node) && $node->getTreeID() == $tree->getTreeID()) {
                    $selectedIDs[] = $node->getTreeNodeID();
                }
            }
            $tree->setSelectedTreeNodeIDs($selectedIDs);
        }

        $tree->setRequest($_REQUEST);
        $result = $tree->getJSON();
        return new JsonResponse($result);
    }
}
