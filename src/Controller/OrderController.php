<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Repository\ProductRepository;
use App\Service\OrderService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/orders')]
class OrderController extends AbstractController
{
    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    #[Route('/new', name: 'app_order_new', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ProductRepository $productRepository): JsonResponse
    {
        $payload = json_decode($request->getContent(), true);

        $order = new Order();
        $order->setNumber($this->orderService->generateOrderNumber());
        $order->setStatus('PENDING');
        $order->setDatetime((new \DateTimeImmutable()));
        $entityManager->persist($order);

        $errors = [];
        $products = $payload['products'];
        foreach ($products as $productId => $count) {
            $product = $productRepository->findOneBy(['id' => $productId]);

            if ($product === null) {
                $errors[] = 'Product with ID ' . $productId . ' not exists.';
                continue;
            }

            $orderProduct = new OrderProduct();
            $orderProduct->setOrder($order);
            $orderProduct->setProduct($product);
            $orderProduct->setCount($count);
            $entityManager->persist($orderProduct);
        }

        if (!empty($errors)) {
            return new JsonResponse([
                'message' => 'Order creating failed',
                'errors' => $errors,
            ]);
        }

        $entityManager->flush();

        return new JsonResponse([
            'message' => 'Order created',
        ]);
    }

    #[Route('/{id}', name: 'app_order_show', methods: ['GET'])]
    public function show(Order $order): JsonResponse
    {
        return new JsonResponse($this->orderService->getClientOrderData($order));
    }
}
