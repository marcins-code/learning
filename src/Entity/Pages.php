<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Knp\Menu\NodeInterface;
use Traversable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PagesRepository")
 */
class Pages implements NodeInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="TITLE", type="string", length=255)
     */
    private $title;

    /**
     * page | link | pdf
     * @var string
     *
     * @ORM\Column(name="CONTENT_TYPE", type="string", length=255)
     */
    private $contentType;

    /**
     * A page can have one parent
     *
     * @var FacetPage
     *
     * @ORM\ManyToOne(targetEntity="Pages", inversedBy="childrenPages")
     * @ORM\JoinColumn(name="PARENT_PAGE_ID", referencedColumnName="ID")
     */
    private $parentPage;


    /**
     * A parent can have multiple children
     *
     * @var arrayCollection
     *
     * @ORM\OneToMany(targetEntity="Pages", mappedBy="parentPage")
     *
     */
    private $childrenPages;

    /**
     * @var resource
     *
     * @ORM\Column(name="CONTENT", type="text", length=200000)
     */
    private $content;

//    /**
//     * Many pages could have many allowed roles
//     *
//     * @var arrayCollection
//     *
//     * @ORM\ManyToMany(targetEntity="Role")
//     * @ORM\JoinTable(name="PAGE_ALLOWED_ROLES",
//     *      joinColumns={@ORM\JoinColumn(name="page_id", referencedColumnName="ID")},
//     *      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="ID")}
//     *      )
//     */
//    private $allowedRoles;

    /**
     * @var string
     *
     * @ORM\Column(name="SLUG", type="string", nullable=true)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="PERMALINK", type="string", nullable=true)
     */
    private $permalink;

//    /**
//     * @var User
//     *
//     * @ORM\ManyToOne(targetEntity="User")
//     * @ORM\JoinColumns({
//     *   @ORM\JoinColumn(name="CREATED_BY", referencedColumnName="ID", nullable=false)
//     * })
//     *
//     */
//    private $author;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="CREATED_ON", type="datetime", nullable=false)
     */
    private $createdOn;

    /**
     * The default status of new pages is published
     *
     * @var string
     *
     * @ORM\Column(name="STATUS", type="string", nullable=false, )
     */
    private $status = 'published';

    /**
     * Page constructor.
     */
    public function __construct()
    {
//https://knpuniversity.com/screencast/collections/many-to-many-setup#doctrine-arraycollection
        $this->allowedRoles = new ArrayCollection();
        $this->childrenPages = new ArrayCollection();

    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * @param string $contentType
     */
    public function setContentType(string $contentType)
    {
        $this->contentType = $contentType;
    }

    /**
     * @return Page
     */
    public function getParentPage()
    {
        return $this->parentPage;
    }

    /**
     * @param Page $parentPage
     */
    public function setParentPage(Page $parentPage)
    {
        $this->parentPage = $parentPage;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content)
    {
        $this->content = $content;
    }

    /**
     * @return ArrayCollection|Role[]
     */
    public function getAllowedRoles()
    {
        return $this->allowedRoles;
    }

    /**
     * @param arrayCollection $allowedRoles
     */
    public function setAllowedRoles($allowedRoles)
    {
        $this->allowedRoles = $allowedRoles;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getPermalink()
    {
        return $this->permalink;
    }

    /**
     * @param string $permalink
     */
    public function setPermalink(string $permalink)
    {
        $this->permalink = $permalink;
    }

    /**
     * @return User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param FacetUser $author
     */
    public function setAuthor(User $author)
    {
        $this->author = $author;
    }

    /**
     * @return DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @param DateTime $createdOn
     */
    public function setCreatedOn(DateTime $createdOn)
    {
        $this->createdOn = $createdOn;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status)
    {
        $this->status = $status;
    }

    /**
     * @return ArrayCollection
     */
    public function getChildrenPages()
    {
        return $this->childrenPages;
    }

    /**
     * @param ArrayCollection $childrenPages
     */
    public function setChildrenPages($childrenPages)
    {
        $this->childrenPages = $childrenPages;
    }

    /**
     * Get the name of the node
     *
     * Each child of a node must have a unique name
     *
     * @return string
     */
    public function getName():string
    {
        return $this->title;
    }

    /**
     * Get the options for the factory to create the item for this node
     *
     * @return array
     * @throws Exception
     */
    public function getOptions():array
    {
        if ($this->contentType == 'page') {
            return [
                'route' => 'core_page_id',
                'routeParameters' => ['id' => $this->id]
            ];
        }

        if ($this->contentType == 'doc') {
            return [
                'uri' => '/' . $this->getContent()
            ];
        }

        if ($this->contentType == 'link') {
            return [
                'uri' => $this->content
            ];
        }

        throw new Exception('No valid options found for page type', 500);
    }

    /**
     * Get the child nodes implementing NodeInterface
     *
     * @return Traversable
     */
    public function getChildren(): Traversable

    {
        return $this->getChildren();
    }

    public function addChildrenPage(Page $childrenPage): self
    {
        if (!$this->childrenPages->contains($childrenPage)) {
            $this->childrenPages[] = $childrenPage;
            $childrenPage->setParentPage($this);
        }

        return $this;
    }

    public function removeChildrenPage(Page $childrenPage): self
    {
        if ($this->childrenPages->contains($childrenPage)) {
            $this->childrenPages->removeElement($childrenPage);
            // set the owning side to null (unless already changed)
            if ($childrenPage->getParentPage() === $this) {
                $childrenPage->setParentPage(null);
            }
        }

        return $this;
    }

    public function addAllowedRole(Role $allowedRole): self
    {
        if (!$this->allowedRoles->contains($allowedRole)) {
            $this->allowedRoles[] = $allowedRole;
        }

        return $this;
    }

    public function removeAllowedRole(Role $allowedRole): self
    {
        if ($this->allowedRoles->contains($allowedRole)) {
            $this->allowedRoles->removeElement($allowedRole);
        }

        return $this;
    }
}