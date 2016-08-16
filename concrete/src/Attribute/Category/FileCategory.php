<?php
namespace Concrete\Core\Attribute\Category;

use Concrete\Core\Attribute\Category\SearchIndexer\StandardSearchIndexerInterface;
use Concrete\Core\Entity\Attribute\Key\FileKey;
use Concrete\Core\Entity\Attribute\Key\Key;
use Concrete\Core\Entity\Attribute\Type;

class FileCategory extends AbstractStandardCategory
{

    public function createAttributeKey()
    {
        return new FileKey();
    }

    public function getIndexedSearchTable()
    {
        return 'FileSearchIndexAttributes';
    }

    public function getIndexedSearchPrimaryKeyValue($mixed)
    {
        return $mixed->getFileID();
    }

    public function getSearchIndexFieldDefinition()
    {
        return array(
            'columns' => array(
                array(
                    'name' => 'fID',
                    'type' => 'integer',
                    'options' => array('unsigned' => true, 'default' => 0, 'notnull' => true),
                ),
            ),
            'primary' => array('fID'),
        );
    }

    public function getAttributeRepository()
    {
        return $this->entityManager->getRepository('\Concrete\Core\Entity\Attribute\Key\FileKey');
    }

    public function getAttributeValues($version)
    {
        $query = $this->entityManager->createQuery('select fav from Concrete\Core\Entity\Attribute\Value\FileValue fav
          inner join fav.version fv inner join fv.file f where fv.fvID = :fvID and f.fID = :fID');
        $query->setParameter('fID', $version->getFile()->getFileID());
        $query->setParameter('fvID', $version->getFileVersionID());

        return $query->getResult();
    }

    public function getAttributeValue(Key $key, $file)
    {
        $r = $this->entityManager->getRepository('\Concrete\Core\Entity\Attribute\Value\FileValue');
        $value = $r->findOneBy(array(
            'version' => $file->getVersion(),
            'attribute_key' => $key,
        ));

        return $value;
    }

}
