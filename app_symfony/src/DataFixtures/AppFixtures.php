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


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        /* SKILL */

        $skillLangue = new Skill("Accueil des visiteurs");
        $skillGestion = new Skill("Gestion des évènements");
        $skillAssistance = new Skill("Assistance aux athlètes");

        /* ADRESSE */

        $adresse1 = new Address('10 Rue des Cerisiers, 75001 Paris', 48.8599, 2.3466);
        $adresse2 = new Address('25 Avenue des Lilas, 13001 Marseille', 43.2965, 5.3698);

        /* TASK */

        $taskAccueillir = new Task( "Accueil des visiteurs", "20",  new \DateTime("2024-07-24"), new \DateTime("2024-08-09"),"Accueillir et orienter les visiteurs aux différents sites olympiques.");

        $taskAccueillir->addSkill($skillLangue);
        $taskAccueillir->setAddress($adresse1);

        $taskAssister = new Task("Assistance aux athlètes","15",new \DateTime("2024-07-24"),new \DateTime("2024-08-09"),"Fournir une assistance aux athlètes dans stands olympiques.");

        $taskAssister->addSkill($skillAssistance);
        $taskAssister->setAddress($adresse2);

        /* UTILISATEUR */

        $userDev = new User( "dev@gmail.com", "root",  "root", "root", "root.jpg");
        $userDev->setAddress($adresse1);
        $userDev->addSkill($skillAssistance);
        $userDev->addTask($taskAccueillir);

        $userBastien = new User( "jolybastien@gmail.com",  "bastien",   "joly", "bastien", "ppBastien.jpg");
        $userBastien->setAddress($adresse2);
        $userBastien->addSkill($skillLangue);
        $userBastien->addTask($taskAssister);

        $userJohan = new User( "morgajohan@gmail.com", "johan",  "morga", "johan", "ppJohan.jpg");
        $userJohan->setAddress($adresse1);
        $userJohan->addSkill($skillLangue);
        $userJohan->addTask($taskAccueillir);

        $userRaph = new User("victorraphael@gmail.com","raphael", "victor", "raphael", "ppRaphael.jpg");
        $userRaph->setAddress($adresse2);
        $userRaph->addSkill($skillLangue);
        $userRaph->addTask($taskAssister);

        $userArthur = new User( "jarriauarthur@gmail.com", "arthur", "jarriau", "arthur", "ppArthur.jpg");
        $userArthur->setAddress($adresse1);
        $userArthur->addSkill($skillAssistance);
        $userArthur->addTask($taskAccueillir);

        $userSean = new User( "reybozsean@gmail.com", "sean",  "reyboz", "sean","ppSean.jpg");
        $userSean->setAddress($adresse2);
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

        $messageAccueillir1 = new Message('Rendez-vous Parc des Princes demain à 17h', new \DateTime('2024-08-24 15:03:55'));
        $messageAccueillir2 = new Message('OK parfait à demain !', new \DateTime('2024-08-24 15:07:12'));
        $messageAssister1 = new Message('Vous viendrez aider les athlètes de javelot demain', new \DateTime('2024-08-24 15:03:55'));
        $messageAssister2 = new Message('OK parfait à demain !', new \DateTime('2024-08-24 15:07:12'));

        $messageAccueillir1->setUser($userDev);
        $messageAccueillir1->setConversation($conversionAccueillir);
        $messageAccueillir2->setUser($userArthur);
        $messageAccueillir2->setConversation($conversionAccueillir);

        $messageAssister1->setUser($userDev);
        $messageAssister1->setConversation($conversionAssister);
        $messageAssister2->setUser($userSean);
        $messageAssister2->setConversation($conversionAssister);


        $manager->flush();
    }
}
