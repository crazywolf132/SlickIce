<?php
namespace Concrete\Core\Express\Form\Control\View;

use Concrete\Core\Entity\Express\Entry;
use Concrete\Core\Express\Form\Control\EntityPropertyControlView;
use Concrete\Core\Express\Form\Control\RendererInterface;
use Concrete\Core\Express\Form\RendererFactory;

class AssociationControlViewRenderer implements RendererInterface
{
    protected $application;
    protected $entry;
    protected $factory;

    public function __construct(Entry $entry)
    {
        $this->entry = $entry;
    }

    public function build(RendererFactory $factory)
    {
        $this->factory = $factory;
        $this->application = $factory->getApplication();
    }

    public function render()
    {
        $template = $this->application->make('environment')->getPath(
            DIRNAME_ELEMENTS .
            '/' . DIRNAME_EXPRESS .
            '/' . DIRNAME_EXPRESS_VIEW_CONTROLS .
            '/' . DIRNAME_EXPRESS_FORM_CONTROLS_ASSOCIATION .
            '/' . 'list.php'
        );

        $association = $this->factory->getControl()->getAssociation();
        /*
         * @var $association \Concrete\Core\Entity\Express\Association
         */
        $related = $this->entry->getAssociations();
        $view = new EntityPropertyControlView($this->factory);
        foreach($related as $relatedAssociation) {
            if ($relatedAssociation->getAssociation()->getID() == $association->getID()) {
                $view->addScopeItem('entities', $relatedAssociation->getSelectedEntries());
            }
        }
        $view->addScopeItem('control', $this->factory->getControl());
        $view->addScopeItem('formatter', $association->getFormatter());

        return $view->render($template);
    }
}
