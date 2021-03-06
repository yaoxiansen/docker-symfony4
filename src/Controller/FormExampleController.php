<?php
namespace App\Controller;
use App\Entity\Product;
use App\Form\Type\ProductType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
class FormExampleController extends Controller
{
	/**
     * @Route("/product/create", name="form_create_example")
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
            return $this->redirectToRoute('form_read_example');
        }
        return $this->render('/form/product_create.html.twig', [
            'productForm' => $form->createView()
        ]);
    }
	
    /**
     * @Route("/product/list", name="form_read_example")
     */
    public function formReadExampleAction(Request $request)
    {
		$repository = $this->getDoctrine()->getRepository(Product::class);
		$items = $repository->findAll();
		$products = array();
		if(isset($items)){
			foreach($items as $item){
				$products[] = [
					'id' => $item->getId(),
					'title' => $item->getTitle(),
					'description' => $item->getDescription()
				];
			}
		}
		return $this->render('/form/product_read.html.twig', ['products' => $products]);
    }
    /**
     * @Route("/product/{product}", name="form_edit_example",requirements={"id"="\d+"})
     */
    public function formEditExampleAction(Request $request, Product $product)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('form_read_example');
        }
        return $this->render('/form/product_create.html.twig', [
            'productForm' => $form->createView()
        ]);
    }
	
	/**
     * @Route("/product/delete/{product}", name="form_delete_example",requirements={"id"="\d+"})
     */
    public function formDeleteExampleAction(Request $request, Product $product)
    {
        $em = $this->getDoctrine()->getManager();
		$em->remove($product);
		$em->flush();
		return $this->redirectToRoute('form_read_example');
    }
}