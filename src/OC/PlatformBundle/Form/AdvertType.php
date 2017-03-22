<?php

namespace OC\PlatformBundle\Form;

use OC\PlatformBundle\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdvertType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // sql patterns: https://sql.sh/cours/where/like
        $pattern = 'D%'; // all categories that start with a D

        // it's a bad practice to let the builder type guessing
        $builder
            ->add('date', DateTimeType::class)
            ->add('title', TextType::class)
            ->add('author', TextType::class, ["label" => "Your Name"])
            ->add('content', TextareaType::class)
            ->add('image', ImageType::class, ["required" => false])// a form is a field! (both entities must be associated with Doctrine)
            //->add('categories', CollectionType::class, [ // to use that, uncomment the script in form.html.twig
            //    'entry_type' => CategoryType::class,
            //    'allow_add' => true,
            //    'allow_delete' => true
            //])
            ->add('categories', EntityType::class, [
                'class' => 'OCPlatformBundle:Category',
                'choice_label' => 'name',
                'multiple' => true,
                'query_builder' => function (CategoryRepository $repository) use ($pattern) {
                    return $repository->getLikeQueryBuilder($pattern);
                }
            ])
            ->add('save', SubmitType::class);

        // Si l'annonce n'est pas publiée, on affiche la checkbox "published", sinon on l'enlève
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,    // 1er argument : L'évènement qui nous intéresse : ici, PRE_SET_DATA
            function (FormEvent $event) { // 2e argument : La fonction à exécuter lorsque l'évènement est déclenché
                // On récupère notre objet Advert sous-jacent
                $advert = $event->getData();

                // Cette condition est importante, car une première exécution de PRE_SET_DATA est effectuée à l'initialisation du formulaire (sans objet)
                if (null === $advert) {
                    return; // On sort de la fonction sans rien faire lorsque $advert vaut null
                }

                // Si l'annonce n'est pas publiée, ou si elle n'existe pas encore en base (id est null)
                if (!$advert->getPublished() || null === $advert->getId()) {
                    // Alors on ajoute le champ published
                    $event->getForm()->add('published', CheckboxType::class, array('required' => false));
                } else {
                    // Sinon, on le supprime
                    $event->getForm()->remove('published');
                }
            });

        // Plus d'infos sur les évènements : https://symfony.com/doc/current/form/dynamic_form_modification.html
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'OC\PlatformBundle\Entity\Advert'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'oc_platformbundle_advert';
    }


}
