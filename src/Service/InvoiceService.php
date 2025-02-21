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

    public function facturer($invoiceData, User $user, float $total): void
    {
        // Créer la facture
        $invoice = new Invoice();
        $invoice->setUserId($user->getId());
        $invoice->setMontant($total);  // Assigner le montant total
        $invoice->setDateTransaction(new \DateTime());
        $invoice->setAdresseFacturation($invoiceData->getAdresseFacturation());
        $invoice->setVilleFacturation($invoiceData->getVilleFacturation());
        $invoice->setCodePostalFacturation($invoiceData->getCodePostalFacturation());

        // Sauvegarder la facture en base de données
        $this->em->persist($invoice);
        $this->em->flush();
    }
}
