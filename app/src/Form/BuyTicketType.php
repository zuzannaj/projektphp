<?php
/**
 * Buy ticket type.
 */

namespace App\Form;

use App\Entity\BusLine;
use App\Entity\BusRoute;
use App\Entity\Stop;
use App\Entity\Ticket;
use App\Entity\User;
use App\Repository\BusRouteRepository;
use App\Repository\StopRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class BusTicketType.
 *
 */
class BuyTicketType extends AbstractType
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
            'lastStop',
            EntityType::class,
            [
                'class' => BusRoute::class,
                /*'query_builder' => function (BusRouteRepository $er) {
                    return $er->createQueryBuilder('br')
                        ->leftJoin('br.stop', 's')
                        ->leftJoin('br.bus_line', 'bl')
                        ->where('bl.number = ?1')
                        ->setParameter(1, 'numberr'); } */
                'query_builder' => function (BusRouteRepository  $r) {
                    return $r->showLine('124');
                },
            ]
        );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
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
        return 'ticket';
    }
}
