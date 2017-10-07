<?php

namespace CityFinderBundle\Controller;


use CityFinderBundle\Entity\User;
use CityFinderBundle\Form\UserType;
use CityFinderBundle\Security\Authorization\Voter\OwnerVoter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Cache\Adapter\TraceableAdapter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class UserController
 *
 * Ce controller est destiné à la gestion de l'utilisateur (Création, Mise à jour etc.)
 *
 * @package CityFinderBundle\Controller
 */
class UserController extends Controller
{
    /**
     * @var TraceableAdapter
     */
    private  $memCachedManager;


    public function __construct(TraceableAdapter $products)
    {
        $this->memCachedManager = $products;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"user"})
     * @Rest\Post("/user")
     * @return mixed
     */
    public function postUserAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $user = new User();
        $user->setRoles(serialize([User::ROLE_USER]));

        $form = $this->createForm(UserType::class, $user);

        $form->submit($request->request->all());

        if ($form->isValid()) {
            if (!empty($user->getPlainPassword())) {
                $this->encodePassword($user);
            }

            $em->persist($user);
            $em->flush();

            return $user;
        } else {
            return $form;
        }
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_OK, serializerGroups={"user"})
     * @Rest\Patch("/user/{user_id}")
     * @return mixed
     */
    public function patchUserAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(User::class);

        $user = $repository->find($request->get("user_id"));

        $form = $this->createForm(UserType::class, $user);

        if (empty($user)) {
            return $this->userNotFound();
        }

        $this->denyAccessUnlessGranted(OwnerVoter::OWNER, $user);

        $form->submit($request->request->all(), false);

        if ($form->isValid()) {
            if (!empty($user->getPlainPassword())) {
                $this->encodePassword($user);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            //mise à jour de l'utilisateur memCached (s'il y en a un)
            $memCachedUser      = $this->memCachedManager->getItem("user_".$user->getId());

            //on enregistre notre utilisateur
            $memCachedUser->set($user);
            $this->memCachedManager->save($memCachedUser);

            return $user;
        } else {
            return $form;
        }
        return $user;
    }


    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/user/{user_id}")
     * @param Request $request
     * @return JsonResponse
     */
    public function removeUserAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository(User::class)->find($request->get('user_id'));

        if (empty($user)) {
            return $this->userNotFound();
        }

        $this->denyAccessUnlessGranted(OwnerVoter::OWNER, $user);

        $this->memCachedManager->deleteItem("user_".$user->getId());

        $em->remove($user);
        $em->flush();
    }


    private function encodePassword(User $user)
    {
        $encoder = $this->get('security.password_encoder');
        $encoded = $encoder->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($encoded);
        $user->eraseCredentials();

    }

    private function userNotFound() {
        throw new NotFoundHttpException('User not found');
    }

}
