<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Conversation;
use App\Entity\Message;
use App\Entity\Skill;
use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtures extends Fixture
{

    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        /* SKILL */

        $skillLangue = new Skill("Accueil des visiteurs");
        $skillGestion = new Skill("Gestion des évènements");
        $skillAssistance = new Skill("Assistance aux athlètes");

        /* ADRESSE */

        $adresse1 = new Address('10 Rue des Cerisiers, 75001 Paris', 48.8599, 2.3466);
        $adresse2 = new Address('25 Avenue des Lilas, 13001 Marseille', 43.2965, 5.3698);
        $adresse3 = new Address('24 Avenue des Lilas, 13001 Marseille', 43.2965, 5.3698);
        $adresse4 = new Address('23 Avenue des Lilas, 13001 Marseille', 43.2965, 5.3698);
        $adresse5 = new Address('22 Avenue des Lilas, 13001 Marseille', 43.2965, 5.3698);
        $adresse6 = new Address('21 Avenue des Lilas, 13001 Marseille', 43.2965, 5.3698);

        $adresseSkill1 = new Address('11 Rue des Cerisiers, 75001 Paris', 48.8599, 2.3466);
        $adresseSkill2 = new Address('12 Rue des Cerisiers, 75001 Paris', 48.8599, 2.3466);

        /* TASK */

        $taskAccueillir = new Task(
            "Accueil des visiteurs",
            20,
            new \DateTime("2024-07-24"),
            new \DateTime("2024-08-09"),
            "Accueillir et orienter les visiteurs aux différents sites olympiques."
        );

        $taskAccueillir->addSkill($skillLangue);
        $taskAccueillir->setAddress($adresseSkill1);

        $taskAssister = new Task(
            "Assistance aux athlètes",
            15,
            new \DateTime("2024-07-24"),
            new \DateTime("2024-08-09"),
            "Fournir une assistance aux athlètes dans stands olympiques."
        );

        $taskAssister->addSkill($skillAssistance);
        $taskAssister->setAddress($adresseSkill2);

        /* UTILISATEUR */

        $userDev = new User("dev@gmail.com", "root", "root", "root.jpg");
        $userDev->setPassword($this->passwordHasher->hashPassword($userDev, "root"));
        $userDev->setRoles(["ROLE_ADMIN"]);
        $userDev->setAddress($adresse1);
        $userDev->addSkill($skillAssistance);
        $userDev->addTask($taskAccueillir);

        $userBastien = new User("jolybastien@gmail.com", "joly", "bastien", "ppBastien.jpg");
        $userBastien->setPassword($this->passwordHasher->hashPassword($userBastien, "bastien"));
        $userBastien->setAddress($adresse2);
        $userBastien->addSkill($skillLangue);
        $userBastien->addTask($taskAssister);

        $userJohan = new User("morgajohan@gmail.com", "morga", "johan", "ppJohan.jpg");
        $userJohan->setPassword($this->passwordHasher->hashPassword($userJohan, "johan"));
        $userJohan->setAddress($adresse3);
        $userJohan->addSkill($skillLangue);
        $userJohan->addTask($taskAccueillir);

        $userRaph = new User("victorraphael@gmail.com", "victor", "raphael", "ppRaphael.jpg");
        $userRaph->setPassword($this->passwordHasher->hashPassword($userRaph, "raphael"));
        $userRaph->setAddress($adresse4);
        $userRaph->addSkill($skillLangue);
        $userRaph->addTask($taskAssister);

        $userArthur = new User("jarriauarthur@gmail.com", "jarriau", "arthur", "ppArthur.jpg");
        $userArthur->setPassword($this->passwordHasher->hashPassword($userArthur, "arthur"));
        $userArthur->setAddress($adresse5);
        $userArthur->addSkill($skillAssistance);
        $userArthur->addTask($taskAccueillir);

        $userSean = new User("reybozsean@gmail.com", "reyboz", "sean", "ppSean.jpg");
        $userSean->setPassword($this->passwordHasher->hashPassword($userSean, "sean"));
        $userSean->setAddress($adresse6);
        $userSean->addSkill($skillLangue);
        $userSean->addTask($taskAssister);

        $conversionAccueillir = new Conversation('Conversation Accueillir');
        $conversionAccueillir->setTask($taskAccueillir);
        $conversionAccueillir->addUser($userArthur);
        $conversionAccueillir->addUser($userDev);


        $conversionAssister = new Conversation('Conversation Assister');
        $conversionAssister->setTask($taskAssister);
        $conversionAssister->addUser($userSean);
        $conversionAssister->addUser($userDev);

        $messageAccueillir1 = new Message(
            'Rendez-vous Parc des Princes demain à 17h',
            new \DateTime('2024-08-24 15:03:55')
        );
        $messageAccueillir2 = new Message('OK parfait à demain !', new \DateTime('2024-08-24 15:07:12'));
        $messageAssister1 = new Message(
            'Vous viendrez aider les athlètes de javelot demain',
            new \DateTime('2024-08-24 15:03:55')
        );
        $messageAssister2 = new Message('OK parfait à demain !', new \DateTime('2024-08-24 15:07:12'));

        $messageAccueillir1->setUser($userDev);
        $messageAccueillir1->setConversation($conversionAccueillir);
        $messageAccueillir2->setUser($userArthur);
        $messageAccueillir2->setConversation($conversionAccueillir);

        $messageAssister1->setUser($userDev);
        $messageAssister1->setConversation($conversionAssister);
        $messageAssister2->setUser($userSean);
        $messageAssister2->setConversation($conversionAssister);


        $manager->persist($skillLangue);
        $manager->persist($skillGestion);
        $manager->persist($skillAssistance);

        $manager->persist($adresse1);
        $manager->persist($adresse2);
        $manager->persist($adresse3);
        $manager->persist($adresse4);
        $manager->persist($adresse5);
        $manager->persist($adresse6);
        $manager->persist($adresseSkill1);
        $manager->persist($adresseSkill2);

        $manager->persist($taskAccueillir);
        $manager->persist($taskAssister);

        $manager->persist($userDev);
        $manager->persist($userBastien);
        $manager->persist($userJohan);
        $manager->persist($userRaph);
        $manager->persist($userArthur);
        $manager->persist($userSean);

        $manager->persist($conversionAccueillir);
        $manager->persist($conversionAssister);

        $manager->persist($messageAccueillir1);
        $manager->persist($messageAccueillir2);
        $manager->persist($messageAssister1);
        $manager->persist($messageAssister2);

        $manager->flush();
    }
}
