<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Task;
use App\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskFormType extends AbstractType
{
    /**
     * @var \App\Repository\CategoryRepository
     */
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ["attr" => ["class" => "myclass"]])
            ->add('status', ChoiceType::class, [

                    'choices' => [
                        'Pending' => Task::STATUS_PENDING,
                        'In progress' => Task::STATUS_IN_PROGRESS,
                        'Done' => Task::STATUS_DONE,
                    ]]
            )
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'title',
//                'choices' => $this->categoryRepository->findAll()
            ])
            ->add('deadline', DateTimeType::class, array('widget'=> 'single_text'))
            ->add('priority', ChoiceType::class, [

                    'choices' => [
                        'Low' => Task::PRIORITY_LOW,
                        'Medium' => Task::PRIORITY_MEDIUM,
                        'High' => Task::PRIORITY_HIGH,
                    ]]
            )
            ->add('Submit', SubmitType::class, ["attr" => ["class" => "btn btn-primary"]]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
