<?php
namespace App\Service;

use App\Entity\Invoice;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class InvoiceService
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly Security $security
    ) {
    }

    public function facturer(Invoice $invoice, User $user): void
    {

        // Ajouter la date de publication
        $invoice->setDateTransaction(new \DateTime());
        $invoice->setUserId($user->getId());


        $this->em->persist($invoice);
        $this->em->flush();
    }
}
