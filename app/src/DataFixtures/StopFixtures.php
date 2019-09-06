<?php
/**
 * Stop fixture.
 */
namespace App\DataFixtures;

use App\Entity\Stop;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class StopFixtures.
 */
class StopFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager Object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(10, 'stops', function ($i) {
            $stop = new Stop();
            $stop->setCity($this->faker->word);
            $stop->setName($this->faker->sentence);

            return $stop;
        });

        $manager->flush();
    }
}

