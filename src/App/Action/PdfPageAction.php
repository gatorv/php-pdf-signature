<?php

namespace App\Action;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use TCPDF;

/**
 * Creates Pdf Action
 */
class PdfPageAction implements MiddlewareInterface
{
    /**
     * {@inheritDoc}
     * @see \Interop\Http\ServerMiddleware\MiddlewareInterface::process()
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Christopher Valderrama');
        $pdf->SetTitle('PDF Firmado Digitalmente');
        $pdf->SetSubject('PDF Firmado');
        $pdf->SetKeywords('PDF, openssl, certificate, sign');

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        
        // set certificate file
        $certificate = 'file://' . realpath(APPLICATION_PATH . '/../data/certificate.crt');

        // set additional information
        $info = array(
            'Name' => 'Christopher Valderrama',
            'Location' => 'Guadalajara',
            'Reason' => 'Firmando',
        );

        // set document signature
        $pdf->setSignature($certificate, $certificate, '', '', 2, $info);

        // set font
        $pdf->SetFont('helvetica', '', 12);

        // add a page
        $pdf->AddPage();

        // print a line of text
        $text = 'Este es <b color="#FF0000">un documento firmado digitalmente</b>';
        $pdf->writeHTML($text, true, 0, true, 0);

        // create content for signature
        $pdf->Image(APPLICATION_PATH . '/../data/certificate.jpg', 10, 60, 40, 40, 'JPG');

        // define active area for signature appearance
        $pdf->setSignatureAppearance(10, 60, 40, 40);

        // *** set an empty signature appearance ***
        $pdf->addEmptySignatureAppearance(10, 60, 40, 40);
        
        //Close and output PDF document
        return $pdf->Output('signed.pdf', 'D');
    }
}

