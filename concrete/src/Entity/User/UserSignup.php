<?php
namespace Concrete\Core\Entity\User;

use Concrete\Core\Notification\Subject\SubjectInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="UserSignups"
 * )
 */
class UserSignup implements SubjectInterface
{

    /**
     * @ORM\Id @ORM\Column(type="integer", options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $usID;

    /**
     * @ORM\ManyToOne(targetEntity="\Concrete\Core\Entity\User\User"),
     * @ORM\JoinColumn(name="uID", referencedColumnName="uID")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="\Concrete\Core\Entity\User\User"),
     * @ORM\JoinColumn(name="createdBy", referencedColumnName="uID")
     */
    protected $createdBy;

    public function __construct(User $user, User $createdBy = null)
    {
        $this->user = $user;
        $this->createdBy = $createdBy;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    public function getNotificationDate()
    {
        return $this->user->getUserDateAdded();
    }

    /**
     * @return mixed
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }


    public function getUsersToExcludeFromNotification()
    {
        if (is_object($this->createdBy)) {
            return array($this->createdBy);
        }
    }


}
