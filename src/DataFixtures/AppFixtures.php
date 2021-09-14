<?php

namespace App\DataFixtures;

use App\Entity\Menu;
use App\Entity\MenuEntry;
use App\Entity\MenuSection;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

class AppFixtures extends Fixture
{
    private PasswordHasherFactoryInterface $passwordHasher;
    
    public function __construct(PasswordHasherFactoryInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail("admin@example.com");
        $user->setRoles(["ROLE_ADMIN"]);
        $hasher = $this->passwordHasher->getPasswordHasher($user);
        $user->setPassword($hasher->hash("adminpassword"));
        $manager->persist($user);
        $menu = new Menu();
        $menu->activate();
        $manager->persist($menu);
        $apetizers = MenuSection::newMenuSection("Antipasti", 0);
        $manager->persist($apetizers);
        $menu->addSection($apetizers);
        $mainCourses = MenuSection::newMenuSection("Primi Piatti", 1);
        $manager->persist($mainCourses);
        $menu->addSection($mainCourses);
        $secondDishes = MenuSection::newMenuSection("Secondi Piatti", 2);
        $manager->persist($secondDishes);
        $menu->addSection($secondDishes);
        for($i = 0; $i < 3; $i++) {
            $apetizer = MenuEntry::withData("apetizer$i", 10.5, mt_rand(5,20));
            $manager->persist($apetizer);
            $apetizers->addEntry($apetizer);
            $mainCourse = MenuEntry::withData("mainCourse$i", 10.5, mt_rand(5,20));
            $manager->persist($mainCourse);
            $mainCourses->addEntry($mainCourse);
            $secondDish = MenuEntry::withData("secondDish$i", 10.5, mt_rand(5,20));
            $manager->persist($secondDish);
            $secondDishes->addEntry($secondDish);
        }

        $manager->flush();
    }
}
