<?php
// src/Entity/User.php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @UniqueEntity(fields="email", message="Email already taken")
 * @UniqueEntity(fields="username", message="Username already taken")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * The below length depends on the "algorithm" you use for encoding
     * the password, but this works well with bcrypt.
     *
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="array")
     */
    private $roles;

    /**
     * @ORM\Column(type="string", unique=true, nullable=true)
    */
    private $apiToken;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Order", mappedBy="fk_User")
     */
    private $User_orders;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ShoppingCart", mappedBy="fk_User", cascade={"persist", "remove"})
     */
    private $User_shoppingCart;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     */
    private $street;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     */
    private $state;


    public function __construct()
    {
        $this->roles = array('ROLE_USER');
        $this->User_orders = new ArrayCollection();
    }
    public function getId()
    {
        return $this->id;
    }
    public function getCity()
    {
        return $this->city;
    }
    public function setCity($city)
    {
        $this->city = $city;
    }
    public function getStreet()
    {
        return $this->street;
    }
    public function setStreet($street)
    {
        $this->street = $street;
    }
    public function getState()
    {
        return $this->state;
    }
    public function setState($state)
    {
        $this->state = $state;
    }


    // other properties and methods

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getSalt()
    {
        // The bcrypt and argon2i algorithms don't require a separate salt.
        // You *may* need a real salt if you choose a different encoder.
        return null;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function setRoles($role)
    {
        $this->roles = $role;
    }

    public function eraseCredentials()
    {
    }

    /**
     * @return Collection|Order[]
     */
    public function getUserOrders(): Collection
    {
        return $this->User_orders;
    }

    public function addUserOrder(Order $userOrder): self
    {
        if (!$this->User_orders->contains($userOrder)) {
            $this->User_orders[] = $userOrder;
            $userOrder->setFkUser($this);
        }

        return $this;
    }

    public function removeUserOrder(Order $userOrder): self
    {
        if ($this->User_orders->contains($userOrder)) {
            $this->User_orders->removeElement($userOrder);
            // set the owning side to null (unless already changed)
            if ($userOrder->getFkUser() === $this) {
                $userOrder->setFkUser(null);
            }
        }

        return $this;
    }

    public function getUserShoppingCart(): ?ShoppingCart
    {
        return $this->User_shoppingCart;
    }

    public function setUserShoppingCart(?ShoppingCart $User_shoppingCart): self
    {
        $this->User_shoppingCart = $User_shoppingCart;

        // set (or unset) the owning side of the relation if necessary
        $newFk_User = null === $User_shoppingCart ? null : $this;
        if ($User_shoppingCart->getFkUser() !== $newFk_User) {
            $User_shoppingCart->setFkUser($newFk_User);
        }

        return $this;
    }
}
