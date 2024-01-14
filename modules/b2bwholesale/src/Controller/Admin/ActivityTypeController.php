<?php
namespace PrestaShop\Module\B2BWholesale\Controller\Admin;

use PrestaShop\Module\B2BWholesale\Entity\ActivityType;
use PrestaShop\PrestaShop\Core\Form\IdentifiableObject\Builder\FormBuilderInterface;
use PrestaShop\PrestaShop\Core\Grid\Search\SearchCriteria;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PrestaShop\PrestaShop\Core\Form\IdentifiableObject\Handler\FormHandlerInterface;

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
        return $this->get('prestashop.module.b2bwholesale.form.identifiable_object.builder.activity_type_form_builder');
    }

    private function getFormHandler(): FormHandlerInterface
    {
        return $this->get('prestashop.module.b2bwholesale.form.identifiable_object.data_handler.activity_type_form_handler');
    }

    public function createAction(Request $request)
    {
        $form_builder = $this->getFormBuilder();
        $form = $form_builder->getForm();
        $form->handleRequest($request);

        $formHandler = $this->getFormHandler();
        $result = $formHandler->handle($form);

        if (null !== $result->getIdentifiableObjectId()) {
            $this->addFlash(
                'success',
                $this->trans('Successful creation.', 'Admin.Notifications.Success')
            );

            return $this->redirectToRoute('activity_type_list');
        }

        return $this->render(
            '@Modules/b2bwholesale/views/templates/admin/activity_type.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    public function editAction($activityTypeId, Request $request)
    {
        $form_builder = $this->getFormBuilder();
        $form = $form_builder->getFormFor((int) $activityTypeId);
        $form->handleRequest($request);

        $formHandler = $this->getFormHandler();
        $result = $formHandler->handleFor((int) $activityTypeId, $form);

        if ($result->isSubmitted() && $result->isValid()) {
            $this->addFlash('success', $this->trans('Successful update.', 'Admin.Notifications.Success'));

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
            $this->addFlash(
                'success',
                $this->trans('Successful deletion.', 'Admin.Notifications.Success')
            );
        }

        return $this->redirectToRoute('activity_type_list');
    }
}
