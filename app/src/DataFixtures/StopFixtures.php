<?php
/**
 * Stop Fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Stop;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

/**
 * Class StopFixtures
 * @package App\DataFixtures
 */
class StopFixtures extends AbstractBaseFixtures
{
    /**
     * Load.
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->faker = Factory::create();
        $this->manager = $manager;

        for ($i = 0; $i < 10; ++$i) {
            $stop= new Stop();
            $stop->setCity($this->faker->word);
            $stop->setName($this->faker->sentence);
            $this->manager->persist($stop);
        }

        $manager->flush();
    }
}
