<?php
namespace App\Service;

use App\Entity\Invoice;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class InvoiceService
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function facturer($invoice, User $user, float $total): void
    {

        $invoice->setUserId($user->getId());
        $invoice->setMontant($total);  // Assigner le montant total
        $invoice->setDateTransaction(new \DateTime());


        // Sauvegarder la facture en base de données
        $this->em->persist($invoice);
        $this->em->flush();
    }
}
