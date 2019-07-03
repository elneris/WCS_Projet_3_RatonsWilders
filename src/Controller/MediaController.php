<?php

namespace App\Controller;

use App\Entity\Media;
use App\Form\ImageType;
use App\Form\LinkMediaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * @Route("/media")
 */
class MediaController extends AbstractController
{
    /**
     * @Route("/newAvatar", name="avatar_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function newAvatar(Request $request, EntityManagerInterface $em): Response
    {
        $media = new Media();
        $form = $this->createForm(ImageType::class, $media);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $file stores the uploaded JPG file

            $file = $form->get('type')->getData();
            $extensionFile = ['jpeg', 'jpg', 'png'];

            if (in_array($file->guessExtension(), $extensionFile)) {
                $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();

                // Move the file to the directory where avatars are stored
                try {
                    $file->move(
                        $this->getParameter('avatars_directory'),
                        $fileName
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'media' property to store the JPG file name
                // instead of its contents
                $media->setName('AvatarUser');
                $media->setUrl($fileName);
                $media->setType('avatar');
                $media->setUser($this->getUser());

                $em->persist($media);
                $em->flush();

                $this->addFlash(
                    'success',
                    'Avatar bien enregistré'
                );

                // ... persist the $media variable or any other work
                return $this->redirect($this->generateUrl('user_index'));
            } else {
                $this->addFlash(
                    'danger',
                    'Erreur lors de l\'upload'
                );
                $this->redirect($this->generateUrl('avatar_new'));
            }
        }
        return $this->render('media/image.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/newImage", name="image_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function newImage(Request $request, EntityManagerInterface $em): Response
    {
        $media = new Media();
        $form = $this->createForm(ImageType::class, $media);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $file stores the uploaded JPG file

            $file = $form->get('type')->getData();
            $extensionFile = ['jpeg', 'jpg', 'png'];

            if (in_array($file->guessExtension(), $extensionFile)) {
                $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();

                // Move the file to the directory where avatars are stored
                try {
                    $file->move(
                        $this->getParameter('images_directory'),
                        $fileName
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'media' property to store the JPG file name
                // instead of its contents
                $media->setName('ImageUser');
                $media->setUrl($fileName);
                $media->setType('Image');
                $media->setUser($this->getUser());

                $em->persist($media);
                $em->flush();

                $this->addFlash(
                    'success',
                    'Image bien enregistré'
                );

                // ... persist the $media variable or any other work
                return $this->redirect($this->generateUrl('user_index'));
            } else {
                $this->addFlash(
                    'danger',
                    'Erreur lors de l\'upload'
                );
                $this->redirect($this->generateUrl('image_new'));
            }
        }
        return $this->render('media/image.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/newVideo", name="video_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function newVideo(Request $request, EntityManagerInterface $em): Response
    {
        $media = new Media();
        $form = $this->createForm(LinkMediaType::class, $media);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $file stores the uploaded JPG file

            if (preg_match('#(https?://)([\w\d.&:\#@%/;$~_?\+-=]*)#', $media->getType())) {
                // updates the 'media' property to store the JPG file name
                // instead of its contents
                $media->setName('VideoUser');
                $media->setUrl(str_replace('watch?v=', 'embed/', $media->getType()));
                $media->setType('lienVideo');
                $media->setUser($this->getUser());

                $em->persist($media);
                $em->flush();

                $this->addFlash(
                    'success',
                    'Lien bien enregistré'
                );

                // ... persist the $media variable or any other work
                return $this->redirect($this->generateUrl('user_index'));
            } else {
                $this->addFlash(
                    'danger',
                    'Erreur lors de l\'upload'
                );
                $this->redirect($this->generateUrl('video_new'));
            }
        }
        return $this->render('media/link.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/newMusique", name="musique_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function newMusique(Request $request, EntityManagerInterface $em): Response
    {
        $media = new Media();
        $form = $this->createForm(LinkMediaType::class, $media);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $file stores the uploaded JPG file

            if (preg_match('#(https?://)([\w\d.&:\#@%/;$~_?\+-=]*)#', $media->getType())) {
                // updates the 'media' property to store the JPG file name
                // instead of its contents
                $media->setName('VideoUser');
                $media->setUrl(str_replace(['watch?v=', '&t'], ['embed/', '?t'], $media->getType()));
                $media->setType('lienMusique');
                $media->setUser($this->getUser());

                $em->persist($media);
                $em->flush();

                $this->addFlash(
                    'success',
                    'Lien bien enregistré'
                );

                // ... persist the $media variable or any other work
                return $this->redirect($this->generateUrl('user_index'));
            } else {
                $this->addFlash(
                    'danger',
                    'Erreur lors de l\'upload'
                );
                $this->redirect($this->generateUrl('musique_new'));
            }
        }
        return $this->render('media/link.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

    /**
     * @Route("/delete/{id}", name="media_delete")
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @param Media $media
     * @return Response
     */
    public function delete(EntityManagerInterface $entityManager, Request $request, Media $media): Response
    {
        if ($this->isCsrfTokenValid('delete'.$media->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($media);
            $entityManager->flush();
            $this->addFlash('success', 'Le fichier a bien été supprimé');
        }

        return $this->redirectToRoute('user_index');
    }
}
