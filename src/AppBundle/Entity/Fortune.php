<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Fortune
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\FortuneRepository")
 */
class Fortune
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *@Assert\NotBlank()
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *@Assert\NotBlank()
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    /**
     * @var string
     *@Assert\NotBlank()
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createAt", type="datetime")
     */
    private $createAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="upVote", type="integer")
     */
    private $upVote;

    /**
     * @var integer
     *
     * @ORM\Column(name="downVote", type="integer")
     */
    private $downVote;

    /**
    *@ORM\OneToMany(targetEntity="Comment", mappedBy="fortune")
    *
    */
    private $comments;

    /**
    * @var integer
    * @ORM\Column(name="validate", type="integer")
    *
    */
    private $validate;

    //Construct avec valeurs par défaut
    public function __construct()
    {
      $this->createAt = new \DateTime();
      $this->upVote = 0;
      $this->downVote = 0;
      $this->validate = 0;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Fortune
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return Fortune
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Fortune
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set createAt
     *
     * @param \DateTime $createAt
     *
     * @return Fortune
     */
    public function setCreateAt($createAt)
    {
        $this->createAt = $createAt;

        return $this;
    }

    /**
     * Get createAt
     *
     * @return \DateTime
     */
    public function getCreateAt()
    {
        return $this->createAt;
    }

    public function getUpVote()
    {
        return $this->upVote;
    }

    public function voteUp()
    {
        $this->upVote = $this->upVote + 1;
        return $this;
    }

    public function getDownVote()
    {
        return $this->downVote;
    }

    public function voteDown()
    {
        $this->downVote = $this->downVote + 1;
        return $this;
    }

    /**
     * Get comments
     *
     * @return integer
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set validate
     * @param integer $validate
     * @return integer
     */
     public function setValidate()
     {
         $this->validate++;
         return $this;
     }

    /**
     * Get validate
     *
     * @return integer
     */
    public function getvalidate()
    {
        return $this->validate;
    }

}
