<?php

namespace App\Mailer;

use App\Lib\Exception\MissingConfigurationException;
use Cake\Mailer\Mailer;
use Cake\Event\Event;
use Cake\Core\Exception\Exception;
use InvalidArgumentException;
use Cake\Mailer\Exception\MissingActionException;
use BadMethodCallException;
/*
 * The Mailer class already implements EntityInterface
 * but if you class doesn't you need add this use
 * use Cake\Datasource\EntityInterface;
 * 
 * class Custom implements EntityInterface
 */

class AppMailer extends Mailer
{

    public function implementedEvents(): array
    {
        return [
            'Label.Glabel.printSuccess' => 'sendLabel'
        ];
    }

    /**
     * 
     * @param Event $subject 
     * @return void 
     * @throws MissingConfigurationException 
     * @throws Exception 
     * @throws InvalidArgumentException 
     * @throws MissingActionException 
     * @throws BadMethodCallException 
     */
    public function sendLabel(Event $subject, $toAddresses, $emailBody )
    {
       $this->send('sendLabelPdfAttachment', [ $subject->getSubject(), $toAddresses, $emailBody ]);
    }

    public function sendLabelPdfAttachment($label, array $toAddresses, string $emailBody ){
        
        /* 
        $itemCode = $labels->getItemCode();
        $batch = $labels->getBatch();
        $reference = $labels->getReference();
        $jobId = $labels->getJobId(); 
        */

        $pdfFile = $label->getPdfOutFile();
        
        $this->setProfile('production')
            ->setTo($toAddresses)
            ->setEmailFormat('html') // html and text
            ->setAttachments([$label->getJobId() . '.pdf' => $pdfFile ])
            ->setSubject(sprintf('Label - %s', $label->getJobId(), ))
            ->setViewVars(['content' => $emailBody ])
            ->viewBuilder()
            //->setVars(compact('itemCode', 'batch', 'reference', 'jobId')) 
            ->setTemplate('default');
    }

  
}
