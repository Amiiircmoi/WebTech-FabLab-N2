<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/b-y!M&e/dashboard/b-y!B&o', name: 'app_dashboard_')]
class DashboardController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('dashboard/index.html.twig', []);
    }

    #[Route('/demandes', name: 'form_list')]
    public function formList(): Response
    /*
    Types d'événements
    */

    #[Route('/types-evenements', name: 'type_list')]
    public function typeList(EventTypeRepository $eventTypeRepository): Response
    {
        return $this->render('dashboard/event_type/index.html.twig', [
            'types' => $eventTypeRepository->findBy([], ['position' => 'ASC']),
        ]);
    }

    #[Route('/types-evenements/nouveau', name: 'type_new', methods: ['GET', 'POST'])]
    public function newType(Request $request, EventTypeRepository $eventTypeRepository): Response
    {
        $eventType = new EventType();
        $form = $this->createForm(EventTypeType::class, $eventType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $eventType->setPosition($eventTypeRepository->count([]) + 1);
            $eventTypeRepository->save($eventType, true);

            return $this->redirectToRoute('app_dashboard_type_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dashboard/event_type/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/types-evenements/{id}', name: 'type_edit', methods: ['GET', 'POST'])]
    public function editType(Request $request, EventType $eventType, EventTypeRepository $eventTypeRepository): Response
    {
        $form = $this->createForm(EventTypeType::class, $eventType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $eventTypeRepository->save($eventType, true);

            return $this->redirectToRoute('app_dashboard_type_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dashboard/event_type/edit.html.twig', [
            'eventType' => $eventType,
            'form' => $form,
        ]);
    }

    #[Route('/types-evenements/remove/{id}', name: 'type_delete', methods: ['POST'])]
    public function deleteType(Request $request, EventType $eventType, EventTypeRepository $eventTypeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eventType->getId(), $request->request->get('_token'))) {
            $eventTypeRepository->remove($eventType, true);
        }

        return $this->redirectToRoute('app_dashboard_type_list', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/types-evenements/{id}/move/{direction}', name: 'type_move', methods: ['GET'])]
    public function moveType(EventType $eventType, string $direction, EventTypeRepository $eventTypeRepository): Response
    {
        $eventTypeRepository->move($eventType, $direction);

        return $this->redirectToRoute('app_dashboard_type_list', [], Response::HTTP_SEE_OTHER);
    }
}
