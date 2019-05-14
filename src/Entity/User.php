<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OrderBy;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Price", mappedBy="iduser")
     */
    private $prices;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Profile", mappedBy="user")
     */
    private $profile;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Slider", mappedBy="user")

     */
    private $sliders;

    /**
     * * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="poluch")
     * @ORM\OrderBy({"Date": "DESC"})
     */
    private $message;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="author")
     * @ORM\OrderBy({"Date": "DESC"})
     */
    private $messages;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Day", mappedBy="user")
     */
    private $days;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Time", mappedBy="brone")
     */
    private $times;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Recall", mappedBy="user")
     * @ORM\OrderBy({"date": "DESC"})
     */
    private $recall;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Recall", mappedBy="master")
     * @ORM\OrderBy({"date": "DESC"})
     */
    private $recalls;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $master;

    /**
     * @ORM\Column(type="integer")
     */
    private $view;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ads", mappedBy="author")
     * @ORM\OrderBy({"date": "DESC"})
     */
    private $ads;

    public function __construct()
    {
        $this->prices = new ArrayCollection();
        $this->sliders = new ArrayCollection();
        $this->frommessage = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->days = new ArrayCollection();
        $this->times = new ArrayCollection();
        $this->recall = new ArrayCollection();
        $this->recalls = new ArrayCollection();
        $this->ads = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Price[]
     */
    public function getPrices(): Collection
    {
        return $this->prices;
    }

    public function addPrice(Price $price): self
    {
        if (!$this->prices->contains($price)) {
            $this->prices[] = $price;
            $price->setIduser($this);
        }

        return $this;
    }

    public function removePrice(Price $price): self
    {
        if ($this->prices->contains($price)) {
            $this->prices->removeElement($price);
            // set the owning side to null (unless already changed)
            if ($price->getIduser() === $this) {
                $price->setIduser(null);
            }
        }

        return $this;
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(Profile $profile): self
    {
        $this->profile = $profile;

        // set the owning side of the relation if necessary
        if ($this !== $profile->getUser()) {
            $profile->setUser($this);
        }

        return $this;
    }

    /**
     * @return Collection|Slider[]
     */
    public function getSliders(): Collection
    {
        return $this->sliders;
    }

    public function addSlider(Slider $slider): self
    {
        if (!$this->sliders->contains($slider)) {
            $this->sliders[] = $slider;
            $slider->setUser($this);
        }

        return $this;
    }

    public function removeSlider(Slider $slider): self
    {
        if ($this->sliders->contains($slider)) {
            $this->sliders->removeElement($slider);
            // set the owning side to null (unless already changed)
            if ($slider->getUser() === $this) {
                $slider->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessage(): Collection
    {
        return $this->message;
    }

    public function addMessage(?Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->message[] = $message;
            $message->setPoluch($this);
        }


        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessages(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setAuthor($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
            // set the owning side to null (unless already changed)
            if ($message->getAuthor() === $this) {
                $message->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Day[]
     */
    public function getDays(): Collection
    {
        return $this->days;
    }

    public function addDay(Day $day): self
    {
        if (!$this->days->contains($day)) {
            $this->days[] = $day;
            $day->setUser($this);
        }

        return $this;
    }

    public function removeDay(Day $day): self
    {
        if ($this->days->contains($day)) {
            $this->days->removeElement($day);
            // set the owning side to null (unless already changed)
            if ($day->getUser() === $this) {
                $day->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Time[]
     */
    public function getTimes(): Collection
    {
        return $this->times;
    }

    public function addTime(Time $time): self
    {
        if (!$this->times->contains($time)) {
            $this->times[] = $time;
            $time->setBrone($this);
        }

        return $this;
    }

    public function removeTime(Time $time): self
    {
        if ($this->times->contains($time)) {
            $this->times->removeElement($time);
            // set the owning side to null (unless already changed)
            if ($time->getBrone() === $this) {
                $time->setBrone(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Recall[]
     */

    public function getRecall(): Collection
    {
        return $this->recall;
    }

    public function getRecalls(): Collection
    {
        return $this->recalls;
    }

    public function addRecall(Recall $recall): self
    {
        if (!$this->recalls->contains($recall)) {
            $this->recalls[] = $recall;
            $recall->setMaster($this);
        }

        return $this;
    }

    public function removeRecall(Recall $recall): self
    {
        if ($this->recalls->contains($recall)) {
            $this->recalls->removeElement($recall);
            // set the owning side to null (unless already changed)
            if ($recall->getMaster() === $this) {
                $recall->setMaster(null);
            }
        }

        return $this;
    }

    public function getMaster(): ?string
    {
        return $this->master;
    }

    public function setMaster(string $master): self
    {
        $this->master = $master;

        return $this;
    }

    public function getView(): ?int
    {
        return $this->view;
    }

    public function setView(int $view): self
    {
        $this->view = $view;

        return $this;
    }

    /**
     * @return Collection|Ads[]
     */
    public function getAds(): Collection
    {
        return $this->ads;
    }

    public function addAd(Ads $ad): self
    {
        if (!$this->ads->contains($ad)) {
            $this->ads[] = $ad;
            $ad->setAuthor($this);
        }

        return $this;
    }

    public function removeAd(Ads $ad): self
    {
        if ($this->ads->contains($ad)) {
            $this->ads->removeElement($ad);
            // set the owning side to null (unless already changed)
            if ($ad->getAuthor() === $this) {
                $ad->setAuthor(null);
            }
        }

        return $this;
    }

}
