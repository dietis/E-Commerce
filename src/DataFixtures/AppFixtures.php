<?php
// src/DataFixtures/AppFixtures.php
namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
            $user = new User();
            $user->setEmail('root@root.com');
            $user->setUsername('root');
            $user->setRoles(array('ROLE_ADMIN'));

            $password = $this->encoder->encodePassword($user, 'root');
            $user->setPassword($password);

            $manager->persist($user);
        $manager->flush();
    }
}
