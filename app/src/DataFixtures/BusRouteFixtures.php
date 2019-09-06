<?php
/**
 * Bus route fixtures.
 */

namespace App\DataFixtures;

use App\Entity\BusRoute;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class BusRouteFixtures.
 */
class BusRouteFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load.
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(50, 'bus_routes', function ($i) {
            $busroute = new BusRoute();
            $busroute->setBusLine($this->getRandomReference('bus_lines'));
            $busroute->setStop($this->getRandomReference('stops'));
            $busroute->setStopOrder($this->faker->numberBetween('1', '15'));

            return $busroute;
        });

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return array Array of dependencies
     */
    public function getDependencies(): array
    {
        return [StopFixtures::class, BusRouteFixtures::class];
    }
}
