<?php
/**
 * Bus route type.
 */
namespace App\Form;

use App\Entity\BusLine;
use App\Entity\BusRoute;
use App\Entity\Stop;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class StopType.
 *
 */
class BusRouteType extends AbstractType
{
    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting from the
     * top most type. Type extensions can further modify the form.
     *
     * @see FormTypeExtensionInterface::buildForm()
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'busLine',
            EntityType::class,
            [
                'class' => BusLine::class,
            ]
        );

        $builder->add(
            'stop',
            EntityType::class,
            [
                'class' => Stop::class,
            ]
        );
        $builder->add(
            'stop_order',
            NumberType::class,
            [
                'label' => 'label.order',
                'required' => true,
                'attr' => ['max_length' => 10],
            ]
        );
    }

    /**
     * Configure options.
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BusRoute::class,
        ]);
    }

    /**
     * Returns the prefix of the template block name for this type.
     *
     * The block prefix defaults to the underscored short class name with
     * the "Type" suffix removed (e.g. "UserProfileType" => "user_profile").
     *
     * @return string The prefix of the template block name
     */
    public function getBlockPrefix(): string
    {
        return 'bus_route';
    }
}
