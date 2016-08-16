<?php
namespace Concrete\Core\Express\Search\ColumnSet;

use Concrete\Core\Attribute\Category\ExpressCategory;
use Concrete\Core\Entity\Express\Entry;
use Concrete\Core\Search\Column\Column;
use Concrete\Core\Search\Column\Set;
use Core;

class DefaultSet extends ColumnSet
{

    public static function getDateAdded(Entry $entry)
    {
        return Core::make('helper/date')->formatDateTime($entry->getDateCreated());
    }

    public function __construct(ExpressCategory $category)
    {
        parent::__construct($category);
        $this->addColumn(new Column('e.exEntryDateCreated', t('Date Added'), array('\Concrete\Core\Express\Search\ColumnSet\DefaultSet', 'getDateAdded')));
        $date = $this->getColumnByKey('e.exEntryDateCreated');
        $this->setDefaultSortColumn($date, 'desc');
    }



}
