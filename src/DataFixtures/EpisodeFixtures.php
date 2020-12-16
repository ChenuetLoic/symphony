<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    private $slugify;

    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 50; $i++) {
            $episode = new Episode();
            $episode->setNumber($faker->numberBetween(1,20));
            $episode->setTitle($faker->title);
            $episode->setSlug($this->slugify->generate($episode->getTitle()));
            $episode->setSeason($this->getReference('season_'.rand(0,19)));
            $episode->setSynopsis($faker->text(200));
            $manager->persist($episode);
            $this->addReference('episode_' . $i, $episode);
        }
        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [SeasonFixtures::class];
    }
}
