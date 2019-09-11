<?php
/**
 * Bus line fixture.
 */
namespace App\DataFixtures;

use App\Entity\BusLine;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class BusLineFixtures.
 */
class BusLineFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager Object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(10, 'bus_lines', function ($i) {
            $busline = new BusLine();
            $busline->setNumber($this->faker->numberBetween('100', '999'));

            return $busline;
        });

        $manager->flush();
    }
}
