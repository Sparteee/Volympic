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



        //prod
        $skillLangue = new Skill("Accueil des visiteurs");
        $skillGestion = new Skill("Gestion des évènements");
        $skillAssistance = new Skill("Assistance aux athlètes");


        $adresse1 = new Address('10 Rue des Cerisiers, 75001 Paris', 48.8599, 2.3466);
        $adresse2 = new Address('25 Avenue des Lilas, 13001 Marseille', 43.2965, 5.3698);
        $adresse3 = new Address('24 Avenue des Lilas, 13001 Marseille', 43.2965, 5.3698);
        $adresse4 = new Address('23 Avenue des Lilas, 13001 Marseille', 43.2965, 5.3698);
        $adresse5 = new Address('11 Rue des Cerisiers, 75001 Paris', 48.8599, 2.3466);
        $adresse6 = new Address('21 Avenue des Lilas, 13001 Marseille', 43.2965, 5.3698);
        $adresse7 = new Address('14 Rue des Cerisiers, 75001 Paris', 48.8599, 2.3466);
        $adresse8 = new Address('30 Avenue des Lilas, 13001 Marseille', 43.2965, 5.3698);
        $adresse9 = new Address('27 Avenue des Lilas, 13001 Marseille', 43.2965, 5.3698);
        $adresse10 = new Address('13 Rue des Cerisiers, 75001 Paris', 48.8599, 2.3466);
        $adresse11 = new Address('22 Avenue des Lilas, 13001 Marseille', 43.2965, 5.3698);
        $adresse12 = new Address('15 Rue des Cerisiers, 75001 Paris', 48.8599, 2.3466);
        $adresse13 = new Address('29 Avenue des Lilas, 13001 Marseille', 43.2965, 5.3698);
        $adresse14 = new Address('26 Avenue des Lilas, 13001 Marseille', 43.2965, 5.3698);
        $adresse15 = new Address('12 Rue des Cerisiers, 75001 Paris', 48.8599, 2.3466);
        $adresse16 = new Address('28 Avenue des Lilas, 13001 Marseille', 43.2965, 5.3698);
        $adresse17 = new Address('20 Rue des Cerisiers, 75001 Paris', 48.8599, 2.3466);
        $adresse18 = new Address('31 Avenue des Lilas, 13001 Marseille', 43.2965, 5.3698);
        $adresse19 = new Address('28 Rue des Cerisiers, 75001 Paris', 48.8599, 2.3466);
        $adresse20 = new Address('32 Avenue des Lilas, 13001 Marseille', 43.2965, 5.3698);

        $manager->persist($adresse1);
        $manager->persist($adresse2);
        $manager->persist($adresse3);

        $manager->persist($adresse4);
        $manager->persist($adresse5);
        $manager->persist($adresse6);
        $manager->persist($adresse7);
        $manager->persist($adresse8);
        $manager->persist($adresse9);
        $manager->persist($adresse10);
        $manager->persist($adresse11);
        $manager->persist($adresse12);
        $manager->persist($adresse13);
        $manager->persist($adresse14);
        $manager->persist($adresse15);
        $manager->persist($adresse16);
        $manager->persist($adresse17);
        $manager->persist($adresse18);
        $manager->persist($adresse19);
        $manager->persist($adresse20);


        $taskAccueillir = new Task(
            "Accueil des visiteurs",
            20,
            new \DateTime("2024-07-24"),
            new \DateTime("2024-08-09"),
            "Accueillir et orienter les visiteurs aux différents sites olympiques."
        );


        $userDev = new User("dev@gmail.com", "root", "root", "default.jpg");
        $userDev->setPassword($this->passwordHasher->hashPassword($userDev, "root"));
        $userDev->setRoles(["ROLE_ADMIN"]);
        $userDev->setAddress($adresse11);
        $userDev->addSkill($skillAssistance);

        $userBastien = new User("jolybastien@gmail.com", "Bastien", "Joly", "default.jpg");
        $userBastien->setPassword($this->passwordHasher->hashPassword($userBastien, "bastien"));
        $userBastien->setAddress($adresse12);
        $userBastien->addSkill($skillLangue);
        $userJohan = new User("morgajohan@gmail.com", "Johan", "Morga", "default.jpg");
        $userJohan->setPassword($this->passwordHasher->hashPassword($userJohan, "johan"));
        $userJohan->setAddress($adresse13);
        $userJohan->addSkill($skillLangue);

        $userRaph = new User("victorraphael@gmail.com", "Raphael", "Victor", "default.jpg");
        $userRaph->setPassword($this->passwordHasher->hashPassword($userRaph, "raphael"));
        $userRaph->setAddress($adresse14);
        $userRaph->addSkill($skillLangue);

        $userArthur = new User("jarriauarthur@gmail.com", "Arthur", "Jarriau", "default.jpg");
        $userArthur->setPassword($this->passwordHasher->hashPassword($userArthur, "arthur"));
        $userArthur->setAddress($adresse15);
        $userArthur->addSkill($skillAssistance);

        $userSean = new User("reybozsean@gmail.com", "Sean", "Reyboz", "default.jpg");
        $userSean->setPassword($this->passwordHasher->hashPassword($userSean, "sean"));
        $userSean->setAddress($adresse16);
        $userSean->addSkill($skillLangue);
        $manager->persist($userSean);
        $manager->persist($userArthur);
        $manager->persist($userRaph);
        $manager->persist($userJohan);
        $manager->persist($userBastien);
        $manager->persist($userDev);

        $taskAccueillir->addSkill($skillLangue);
        $taskAccueillir->setAddress($adresse1);
        $conversionAccueillir = new Conversation('Conversation Accueillir');
        $conversionAccueillir->setTask($taskAccueillir);




        $taskLogistique = new Task(
            "Support logistique",
            15,
            new \DateTime("2024-07-25"),
            new \DateTime("2024-08-10"),
            "Fournir un soutien logistique lors des événements olympiques, y compris la gestion des équipements et des fournitures."
        );

        $taskLogistique->addSkill($skillGestion);
        $taskLogistique->setAddress($adresse2);
        $conversionLogistique = new Conversation('Conversation Logistique');
        $conversionLogistique->setTask($taskLogistique);


        $taskAnimation = new Task(
            "Animation des activités",
            18,
            new \DateTime("2024-07-26"),
            new \DateTime("2024-08-11"),
            "Animer les différentes activités et programmes pour divertir les participants et les spectateurs."
        );
        $taskAnimation->addSkill($skillAssistance);
        $taskAnimation->setAddress($adresse3);
        $conversionAnimation = new Conversation('Conversation Animation');
        $conversionAnimation->setTask($taskAnimation);
        $conversionAnimation->addUser($userArthur);
        $conversionAnimation->addUser($userRaph);


        $taskCommunication = new Task(
            "Communication événementielle",
            22,
            new \DateTime("2024-07-27"),
            new \DateTime("2024-08-12"),
            "Contribuer à la communication et à la promotion des événements olympiques à travers divers canaux de communication."
        );
        $taskCommunication->addSkill($skillLangue);
        $taskCommunication->setAddress($adresse4);
        $conversionCommunication = new Conversation('Conversation Communication');
        $conversionCommunication->setTask($taskCommunication);
        $conversionCommunication->addUser($userArthur);
        $conversionCommunication->addUser($userSean);

        $taskSecurite = new Task(
            "Sécurité des sites",
            17,
            new \DateTime("2024-07-28"),
            new \DateTime("2024-08-13"),
            "Assurer la sécurité et le bien-être des visiteurs en patrouillant et en surveillant les différents sites olympiques."
        );
        $taskSecurite->addSkill($skillGestion);
        $taskSecurite->setAddress($adresse5);
        $conversionSecurite = new Conversation('Conversation Securite');
        $conversionSecurite->setTask($taskSecurite);
        $conversionSecurite->addUser($userArthur);
        $conversionSecurite->addUser($userDev);


        $taskRestauration = new Task(
            "Service de restauration",
            14,
            new \DateTime("2024-07-29"),
            new \DateTime("2024-08-14"),
            "Aider à fournir des services de restauration aux participants et aux spectateurs dans les différents lieux de compétition."
        );
        $taskRestauration->addSkill($skillAssistance);
        $taskRestauration->setAddress($adresse6);
        $conversionRestauration = new Conversation('Conversation Restauration');
        $conversionRestauration->setTask($taskRestauration);
        $conversionRestauration->addUser($userArthur);
        $conversionRestauration->addUser($userBastien);

        $taskEntretien = new Task(
            "Entretien des installations",
            16,
            new \DateTime("2024-07-30"),
            new \DateTime("2024-08-15"),
            "Assurer l'entretien et la propreté des installations sportives et des espaces publics pendant les Jeux olympiques."
        );
        $taskEntretien->addSkill($skillGestion);
        $taskEntretien->setAddress($adresse7);
        $conversionEntretien = new Conversation('Conversation Entretien');
        $conversionEntretien->setTask($taskEntretien);
        $conversionEntretien->addUser($userArthur);
        $conversionEntretien->addUser($userRaph);

        $taskCoordination = new Task(
            "Coordination des bénévoles",
            19,
            new \DateTime("2024-07-31"),
            new \DateTime("2024-08-16"),
            "Coordonner les affectations et les horaires des bénévoles pour garantir une couverture adéquate lors des événements olympiques."
        );
        $taskCoordination->addSkill($skillLangue);
        $taskCoordination->setAddress($adresse8);
        $conversionCoordination = new Conversation('Conversation Coordination');
        $conversionCoordination->setTask($taskCoordination);
        $conversionCoordination->addUser($userArthur);
        $conversionCoordination->addUser($userSean);

        $taskTransport = new Task(
            "Gestion des transports",
            21,
            new \DateTime("2024-08-01"),
            new \DateTime("2024-08-17"),
            "Organiser et gérer les services de transport pour les athlètes, les officiels et les invités pendant les Jeux olympiques."
        );
        $taskTransport->addSkill($skillGestion);
        $taskTransport->setAddress($adresse9);
        $conversionTransport = new Conversation('Conversation Transport');
        $conversionTransport->setTask($taskTransport);
        $conversionTransport->addUser($userArthur);
        $conversionTransport->addUser($userDev);

        $taskEnvironnement = new Task(
            "Gestion environnementale",
            23,
            new \DateTime("2024-08-02"),
            new \DateTime("2024-08-18"),
            "Mener des initiatives de gestion environnementale pour promouvoir la durabilité et minimiser l'impact environnemental des Jeux olympiques."
        );
        $taskEnvironnement->addSkill($skillAssistance);
        $taskEnvironnement->setAddress($adresse10);
        $conversionEnvironnement = new Conversation('Conversation Environnement');
        $conversionEnvironnement->setTask($taskEnvironnement);
        $conversionEnvironnement->addUser($userArthur);
        $conversionEnvironnement->addUser($userBastien);


        //persit des données
        $manager->persist($skillLangue);
        $manager->persist($skillGestion);
        $manager->persist($skillAssistance);

        $manager->persist($taskAccueillir);
        $manager->persist($taskLogistique);
        $manager->persist($taskAnimation);
        $manager->persist($taskCommunication);
        $manager->persist($taskSecurite);
        $manager->persist($taskRestauration);
        $manager->persist($taskEntretien);
        $manager->persist($taskCoordination);
        $manager->persist($taskTransport);
        $manager->persist($taskEnvironnement);

        $manager->persist($conversionAnimation);
        $manager->persist($conversionAccueillir);
        $manager->persist($conversionCommunication);
        $manager->persist($conversionSecurite);
        $manager->persist($conversionRestauration);
        $manager->persist($conversionEntretien);
        $manager->persist($conversionCoordination);
        $manager->persist($conversionTransport);
        $manager->persist($conversionEnvironnement);


        $manager->flush();



    }
}
