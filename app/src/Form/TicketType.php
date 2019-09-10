<?php
/**
 * Ticket type.
 */

namespace App\Form;

use App\Entity\BusLine;
use App\Entity\Ticket;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class StopType.
 *
 */
class TicketType extends AbstractType
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
            'firstStop',
            TextType::class,
            [
                'label' => 'label.first_stop',
                'required' => true,
                'attr' => ['max_length' => 255],
            ]
        );
        $builder->add(
            'lastStop',
            TextType::class,
            [
                'label' => 'label.first_stop',
                'required' => true,
                'attr' => ['max_length' => 255],
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

