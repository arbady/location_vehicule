<?php



namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserFixtures extends Fixture

{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');

        // on créé 10 users
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setNom($faker->firstName);
            $user->setPrenom($faker->lastName);
            $user->setSexe($faker->title('male'|'female'));
            $user->setDateNaissance($faker->dateTimeBetween($startDate = '-30 years', $endDate = 'now'));
            $user->setDateInscription($faker->dateTimeBetween($startDate = '-30 years', $endDate = 'now'));
            $user->setAdresse($faker->address);
            $user->setTelephone($faker->phoneNumber);
            $user->setEmail(sprintf('userdemo%d@example.com', $i));
            $user->setRoles(['ROLE_ALLOWED_TO_SWITCH']);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'userdemo'
            ));
            $manager->persist($user);
        }
        $manager->flush();
    }
}