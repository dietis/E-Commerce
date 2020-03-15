<?php
// src/DataFixtures/AppFixtures.php
namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Store;

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
            $user->setCity('Marseille !!!');
            $user->setStreet('88, Jean mermoz');
            $user->setState('France');
            $password = $this->encoder->encodePassword($user, 'root');
            $user->setPassword($password);

            $manager->persist($user);

            $fakestore = new Store();
            $fakestore->setName('No seller');
            $fakestore->setDescription('For product without a store');
            $fakestore->setEnabled(1);
            $fakestore->setCreatedAt(new \DateTime());
            $fakestore->setUpdatedAt(new \DateTime());
            $fakestore->setIdStore(1);

            $manager->persist($fakestore);


            $newstore = new Store();
            $newstore->setName('Nikee');
            $newstore->setDescription('Sportswear');
            $newstore->setEnabled(1);
            $newstore->setCreatedAt(new \DateTime());
            $newstore->setUpdatedAt(new \DateTime());
            $newstore->setIdStore(2);

            $manager->persist($newstore);

        $manager->flush();
    }
}
