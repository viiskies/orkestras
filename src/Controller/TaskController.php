<?php

namespace App\Controller;

use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TaskController extends Controller
{


    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/task", name="task")
     */
    public function index()
    {
//        $controller_name = 'TaskController';
        return $this->render('task/index.html.twig', [
            'controller_name' => 'TaskController',
        ]);
    }

    /**
     * @Route("/task/create", name="task.create")
     */
    public function create(Request $request)
    {
        $task = new Task();
        $task->setTitle('My amazing title');
        $form = $this->createFormBuilder($task)
            ->add('title', TextType::class)
            ->add('status', ChoiceType::class, [

                'choices' => [
                    'Pending' => Task::STATUS_PENDING,
                    'In progress' => Task::STATUS_IN_PROGRESS,
                    'Done' => Task::STATUS_DONE,
                ]]
            )
            ->add('deadline', DateTimeType::class)
            ->add('priority', ChoiceType::class, [

                'choices' => [
                    'Low' => Task::PRIORITY_LOW,
                    'Medium' => Task::PRIORITY_MEDIUM,
                    'High' => Task::PRIORITY_HIGH,
                ]]
            )
            ->add('Submit', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            /** @var Task $data */
            $data = $form->getData();
            $data->setCreateAt(new \DateTime());

            $this->entityManager->persist($data);
            $this->entityManager->flush();

            return $this->redirect('/task');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }
}
