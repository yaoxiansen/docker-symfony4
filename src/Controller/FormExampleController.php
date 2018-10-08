<?php
namespace App\Controller;
use App\Entity\Product;
use App\Form\Type\ProductType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
class FormExampleController extends Controller
{
	/**
     * @Route("/create" name="form_create_example")
     */
    public function formCreateExampleAction(Request $request)
    {
        $form = $this->createForm(ProductType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $product = $form->getData();
            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute('form_example');
        }
        return $this->render('/form/product.html.twig', [
            'productForm' => $form->createView()
        ]);
    }
	
    /**
     * @Route("/list", name="form_example")
     */
    public function formExampleAction(Request $request)
    {
        $form = $this->createForm(ProductType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $product = $form->getData();
            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute('form_example');
        }
        return $this->render('/form/product.html.twig', [
            'productForm' => $form->createView()
        ]);
    }
    /**
     * @Route("/{product}", name="form_edit_example",requirements={"id"="\d+"})
     */
    public function formEditExampleAction(Request $request, Product $product)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('form_edit_example', ['product'=>$product->getId()]);
        }
        return $this->render('/form/product.html.twig', [
            'productForm' => $form->createView()
        ]);
    }
}