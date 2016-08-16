<?php
namespace Concrete\Core\Express\Form;

use Concrete\Core\Entity\Express\Entry;
use Concrete\Core\Entity\Express\Form;

interface RendererInterface
{
    public function render(Form $form, Entry $entry = null);
}
