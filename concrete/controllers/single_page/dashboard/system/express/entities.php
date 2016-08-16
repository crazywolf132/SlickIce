<?php
namespace Concrete\Controller\SinglePage\Dashboard\System\Express;

use Concrete\Core\Attribute\Category\SearchIndexer\ExpressSearchIndexer;
use Concrete\Core\Entity\Express\Entity;
use Concrete\Core\Entity\Express\Form;
use Concrete\Core\Page\Controller\DashboardPageController;
use Concrete\Core\Tree\Node\Node;
use Concrete\Core\Tree\Type\ExpressEntryResults;
use Doctrine\DBAL\Schema\Schema;

class Entities extends DashboardPageController
{
    public function add()
    {
        $this->set('pageTitle', t('Add Data Object'));
        if ($this->request->isMethod('POST')) {
            if (!$this->token->validate('add_entity')) {
                $this->error->add($this->token->getErrorMessage());
            }
            $sec = \Core::make('helper/security');
            $vs = \Core::make('helper/validation/strings');

            $name = $sec->sanitizeString($this->request->request->get('name'));
            $handle = $sec->sanitizeString($this->request->request->get('handle'));

            if (!$vs->handle($handle)) {
                $this->error->add(t('You must create a handle for your data object. It may contain only lowercase letters and underscores.'), 'handle');
            }

            if (!$name) {
                $this->error->add(t('You must give your data object a name.'), 'name');
            }

            if (!$this->error->has()) {
                $entity = new Entity();
                $entity->setName($this->request->request->get('name'));
                $entity->setHandle($this->request->request->get('handle'));
                $entity->setDescription($this->request->request->get('description'));

                $form = new Form();
                $form->setEntity($entity);
                $form->setName('Form');
                $entity->setDefaultEditForm($form);
                $entity->setDefaultViewForm($form);

                // Create a results node
                $tree = ExpressEntryResults::get();
                $node = $tree->getRootTreeNodeObject();
                $node = \Concrete\Core\Tree\Node\Type\ExpressEntryResults::add($entity->getName(), $node);

                $entity->setEntityResultsNodeId($node->getTreeNodeID());
                $this->entityManager->persist($entity);
                $this->entityManager->flush();

                $indexer = $entity->getAttributeKeyCategory()->getSearchIndexer();
                if (is_object($indexer)) {
                    $indexer->createRepository($entity->getAttributeKeyCategory());
                }

                $this->flash('success', t('Object added successfully.'));
                $this->redirect('/dashboard/system/express/entities', 'view_entity', $entity->getId());
            }
        }

        $this->render('/dashboard/system/express/entities/add');
    }

    public function view()
    {
        $r = $this->entityManager->getRepository('\Concrete\Core\Entity\Express\Entity');
        $entities = $r->findAll(array(), array('name' => 'asc'));
        $this->set('entities', $entities);
    }

    public function delete()
    {
        $entity = $this->entityManager->getRepository('Concrete\Core\Entity\Express\Entity')
            ->findOneById($this->request->request->get('entity_id'));

        if (!is_object($entity)) {
            $this->error->add(t("Invalid express entity."));
        }
        if (!$this->token->validate('delete_entity')) {
            $this->error->add($this->token->getErrorMessage());
        }
        if (!$this->error->has()) {
            /**
             * @var $entity Entity
             */
            $entity->setDefaultEditForm(null);
            $entity->setDefaultViewForm(null);
            foreach($entity->getForms() as $form) {
                // fuck off, doctrine
                $this->entityManager->remove($form);
            }
            $this->entityManager->flush();

            $this->entityManager->remove($entity);
            $this->entityManager->flush();
            $this->flash('success', t('Entity deleted successfully.'));
            $this->redirect('/dashboard/system/express/entities');
        }

    }

    public function view_entity($id = null)
    {
        $r = $this->entityManager->getRepository('\Concrete\Core\Entity\Express\Entity');
        $entity = $r->findOneById($id);
        if (is_object($entity)) {
            $this->set('entity', $entity);
            $this->set('pageTitle', t('Object Details'));
            $this->render('/dashboard/system/express/entities/view_details');
        } else {
            $this->view();
        }
    }

    public function edit($id = null)
    {
        $tree = ExpressEntryResults::get();
        $this->set('tree', $tree);
        $this->requireAsset('core/topics');
        $r = $this->entityManager->getRepository('\Concrete\Core\Entity\Express\Entity');
        $this->entity = $r->findOneById($id);
        if (is_object($this->entity)) {
            $node = Node::getByID($this->entity->getEntityResultsNodeId());
            if (is_object($node)) {
                $folder = $node->getTreeNodeParentObject();
                $this->set('folder', $folder);
            }
            $forms = array('' => t('** Select Form'));
            $defaultViewFormID = 0;
            $defaultEditFormID = 0;
            foreach($this->entity->getForms() as $form) {
                $forms[$form->getID()] = $form->getName();
            }
            if (is_object($this->entity->getDefaultViewForm())) {
                $defaultViewFormID = $this->entity->getDefaultViewForm()->getID();
            }
            if (is_object($this->entity->getDefaultEditForm())) {
                $defaultEditFormID = $this->entity->getDefaultEditForm()->getID();
            }
            $this->set('defaultEditFormID', $defaultEditFormID);
            $this->set('defaultViewFormID', $defaultViewFormID);
            $this->set('forms', $forms);
            $this->set('entity', $this->entity);
            $this->set('pageTitle', t('Edit Entity'));
            $this->render('/dashboard/system/express/entities/edit');
        } else {
            $this->view();
        }
    }


    public function update($id = null)
    {
        $this->edit($id);
        $entity = $this->entity;
        if (!$this->token->validate('update_entity')) {
            $this->error->add($this->token->getErrorMessage());
        }

        $sec = \Core::make('helper/security');
        $vs = \Core::make('helper/validation/strings');

        $name = $sec->sanitizeString($this->request->request->get('name'));
        $handle = $sec->sanitizeString($this->request->request->get('handle'));

        if (!$vs->handle($handle)) {
            $this->error->add(t('You must create a handle for your data object. It may contain only lowercase letters and underscores.'), 'handle');
        }

        if (!$name) {
            $this->error->add(t('You must give your data object a name.'), 'name');
        }

        if (!$this->request->request->get('entity_results_node_id')) {
            $this->error->add(t('You must choose where the results for your entity are going live.'));
        }
        $viewForm = null;
        $editForm = null;
        foreach($this->entity->getForms() as $form) {
            if ($form->getID() == $this->request->request->get('default_edit_form_id')) {
                $editForm = $form;
            }
            if ($form->getID() == $this->request->request->get('default_view_form_id')) {
                $viewForm = $form;
            }
        }
        if (!is_object($viewForm)) {
            $this->error->add(t('You must specify a valid default view form.'));
        }
        if (!is_object($editForm)) {
            $this->error->add(t('You must specify a valid default edit form.'));
        }
        if (!$this->error->has()) {

            $previousEntity = clone $entity;

            $entity->setName($name);
            $entity->setHandle($handle);
            $entity->setDescription($this->request->request->get('description'));
            $entity->setDefaultViewForm($viewForm);
            $entity->setDefaultEditForm($editForm);
            $this->entityManager->persist($entity);
            $this->entityManager->flush();

            /**
             * @var $indexer ExpressSearchIndexer
             */
            $indexer = $entity->getAttributeKeyCategory()->getSearchIndexer();
            $indexer->updateRepository($previousEntity, $entity);

            $resultsNode = Node::getByID($entity->getEntityResultsNodeId());
            $folder = Node::getByID($this->request->request('entity_results_node_id'));
            if (is_object($folder)) {
                $resultsNode->move($folder);
            }

            $this->flash('success', t('Object updated successfully.'));
            $this->redirect('/dashboard/system/express/entities', 'view_entity', $entity->getId());
        }
    }

}
