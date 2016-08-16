<?php
namespace Concrete\Core\Entity\File\StorageLocation;

use Concrete\Core\File\StorageLocation\Configuration\ConfigurationInterface;
use Concrete\Core\File\StorageLocation\StorageLocationInterface;
use Database;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="FileStorageLocations")
 */
class StorageLocation implements StorageLocationInterface
{
    /**
     * @ORM\Column(type="string")
     */
    protected $fslName;

    /**
     * @ORM\Column(type="object")
     */
    protected $fslConfiguration;

    /**
     * @ORM\Id @ORM\Column(type="integer", options={"unsigned": true})
     * @ORM\GeneratedValue
     */
    protected $fslID;

    /**
     * @ORM\OneToMany(targetEntity="\Concrete\Core\Entity\File\File", mappedBy="storageLocation")
     **/
    protected $files;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $fslIsDefault = false;

    /**
     * @return int
     */
    public function getID()
    {
        return $this->fslID;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->fslName;
    }

    /** Returns the display name for this storage location (localized and escaped accordingly to $format)
     * @param string $format = 'html'
     *    Escape the result in html format (if $format is 'html').
     *    If $format is 'text' or any other value, the display name won't be escaped.
     *
     * @return string
     */
    public function getDisplayName($format = 'html')
    {
        $value = tc('StorageLocationName', $this->getName());
        switch ($format) {
            case 'html':
                return h($value);
            case 'text':
            default:
                return $value;
        }
    }

    /**
     * @param string $fslName
     */
    public function setName($fslName)
    {
        $this->fslName = $fslName;
    }

    /**
     * @param bool $fslIsDefault
     */
    public function setIsDefault($fslIsDefault)
    {
        $this->fslIsDefault = $fslIsDefault;
    }

    /**
     * @return \Concrete\Core\File\StorageLocation\Configuration\ConfigurationInterface
     */
    public function getConfigurationObject()
    {
        return $this->fslConfiguration;
    }

    /**
     * @return bool
     */
    public function isDefault()
    {
        return $this->fslIsDefault;
    }

    public function setConfigurationObject($configuration)
    {
        $this->fslConfiguration = $configuration;
    }

    public function getTypeObject()
    {
        $configuration = $this->getConfigurationObject();
        $type = $configuration->getTypeObject();

        return $type;
    }

    /**
     * Returns the proper file system object for the current storage location, by mapping
     * it through Flysystem.
     *
     * @return \League\Flysystem\Filesystem
     */
    public function getFileSystemObject()
    {
        $adapter = $this->getConfigurationObject()->getAdapter();
        $filesystem = new \League\Flysystem\Filesystem($adapter);

        return $filesystem;
    }

    public function delete()
    {
        $default = self::getDefault();
        $db = Database::get();

        $fIDs = $db->GetCol('select fID from Files where fslID = ?', array($this->getID()));
        foreach ($fIDs as $fID) {
            $file = \File::getByID($fID);
            if (is_object($file)) {
                $file->setFileStorageLocation($default);
            }
        }

        $em = \ORM::entityManager();
        $em->remove($this);
        $em->flush();
    }

    public function save()
    {
        $default = \Concrete\Core\File\StorageLocation\StorageLocation::getDefault();

        $em = \ORM::entityManager();
        $em->persist($this);

        if ($this->isDefault() && is_object($default) && $default->getID() != $this->getID()) {
            $default->setIsDefault(false);
            $em->persist($default);
        }

        $em->flush();
    }
}
