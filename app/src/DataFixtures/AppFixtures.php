<?php
/**
 * App fixtures.
 */
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class AppFixtures
 *
 */
class AppFixtures extends Fixture
{

    /**
     * Load.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
