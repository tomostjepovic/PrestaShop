<?php
namespace PrestaShop\Module\B2BWholesale\Controller\Admin;

use PrestaShop\Module\B2BWholesale\Entity\ActivityType;
use PrestaShop\Module\B2BWholesale\Form\ActivityTypeType;

use PrestaShop\PrestaShop\Core\Form\IdentifiableObject\Builder\FormBuilderInterface;
use PrestaShop\PrestaShop\Core\Grid\Search\SearchCriteria;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;

class ActivityTypeController extends FrameworkBundleAdminController
{
    public function listAction(): Response
    {
        $searchCriteria = new SearchCriteria(
            [],
            'name',
            'asc',
            0,
            10
        );



        $activityTypeGridFactory = $this->get('prestashop.core.grid.activity_type_grid_factory');
        $activityTypesGrid = $activityTypeGridFactory->getGrid($searchCriteria);

        return $this->render('@Modules/b2bwholesale/views/templates/admin/activity_type.list.html.twig', [
            'activityTypesGrid' => $this->presentGrid($activityTypesGrid),
        ]);
    }

    private function getFormBuilder(): FormBuilderInterface
    {
        return $this->get('prestashop.core.form.identifiable_object.builder.manufacturer_form_builder');
    }

    public function createAction(Request $request): Response
    {
        $form = $this->createForm(ActivityTypeType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $activity_type = new ActivityType();
            $activity_type->setName($form->get('name')->getData());
            $em->persist($activity_type);
            $em->flush();
        }

        return $this->render(
            '@Modules/b2bwholesale/views/templates/admin/activity_type.html.twig',
            [
                 'form' => $form->createView()
            ]
        );
    }

    public function editAction(int $activityTypeId, Request $request): ?Response
    {
        if (!$activityTypeId) {
            return null;
        }
        $em = $this->getDoctrine()->getManager();
        $activity_type = $em->getRepository(ActivityType::class)->find($activityTypeId);

        $form = $this->createForm(ActivityTypeType::class, $activity_type);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $activity_type->setName($form->get('name')->getData());
            $em->flush();
            $this->addFlash('success', 'Activity type successfully updated!');

            return $this->redirectToRoute('activity_type_list');
        }

        return $this->render(
            '@Modules/b2bwholesale/views/templates/admin/activity_type.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    public function deleteAction(int $activityTypeId): Response
    {
        $em = $this->getDoctrine()->getManager();
        $activity_type = $em->getRepository(ActivityType::class)->find($activityTypeId);
        if ($activity_type) {
            $em->remove($activity_type);
            $em->flush();
            $this->addFlash('success', 'Activity type successfully deleted!');
        }

        return $this->redirectToRoute('activity_type_list');
    }
}
