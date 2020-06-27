<?php

namespace App\Mailer;

use Cake\Event\EventInterface;
use Cake\Mailer\Mailer;
use Cake\Datasource\EntityInterface;
use ArrayObject;
use Cake\Event\Event;
use App\Lib\PrintLabels\Label;
use Cake\Core\Exception\Exception;
use InvalidArgumentException;
use App\Lib\Utility\SettingsTrait;

class AppMailer extends Mailer
{
    use SettingsTrait;

    public function implementedEvents(): array
    {
        return [
            //'Model.afterSave' => 'onPalletPrint'
            'Label.Glabel.printSuccess' => 'sendLabel'
        ];
    }


    /**
     * 
     * @param Event $subject 
     * @param mixed $data 
     * @param mixed $moredata 
     * @return void 
     * @throws Exception 
     * @throws InvalidArgumentException 
     */
    public function sendLabel(Event $subject)
    {
        //tog("TGNEvent", $subject, "TGNData", $data, "TGNMore", $moredata, $subject->getSubject()->getPdfOutFile());

        $to = $this->addressParse($this->getSetting('EMAIL_PALLET_LABEL_TO'));

        if(empty($to)) {
            return; 
        }

        $labels = $subject->getSubject();

        $itemCode = $labels->getItemCode();
        $batch = $labels->getBatch();
        $reference = $labels->getReference();
        $jobId = $labels->getJobId();
        $pdfFile = $labels->getPdfOutFile();

        $filename = sprintf(
            '%s-%s-%s-%s',
            $itemCode,
            $batch,
            $reference,
            $jobId
        );

        
        $this->setProfile('production')
            ->setTo($to)
            ->setEmailFormat('both')
            ->setAttachments([$filename . '.pdf' => $pdfFile ])
            ->setSubject(sprintf('Pallet label %s printed', $reference, ))
            ->viewBuilder()->setVars(compact('itemCode', 'batch', 'reference', 'jobId'))
            ->setTemplate('send_label'); // By default template with same name as method name is used.

        $this->send();
    }

    public function addressParse(array $addresses)
    {

        $add = [];
        foreach ($addresses as $addressLine) {
            $add = array_merge($add, mailparse_rfc822_parse_addresses($addressLine));
        }

        $formatted = [];

        foreach ($add as $a) {
            $formatted[$a['address']] = $a['display'];
        }

        return $formatted;
    }
}
