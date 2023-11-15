<?php
require("fpdf186/fpdf.php");

class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Word Break Example', 0, 1, 'C');
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }

    function WordWrap($text, $maxWidth)
    {
        $lines = explode("\n", $text);
        $result = [];

        foreach ($lines as $line) {
            $words = explode(' ', $line);
            $currentLine = '';

            foreach ($words as $word) {
                $width = $this->GetStringWidth($currentLine . $word);

                if ($width <= $maxWidth) {
                    $currentLine .= $word . ' ';
                } else {
                    $result[] = rtrim($currentLine);
                    $currentLine = $word . ' ';
                }
            }

            $result[] = rtrim($currentLine);
        }

        return $result;
    }

    function MultiCellWithWordWrap($width, $height, $text)
    {
        $lines = $this->WordWrap($text, $width);
        foreach ($lines as $line) {
            $this->MultiCell($width, $height, $line);
        }
    }
}

$pdf = new PDF("P", "mm", array(80, 200));
$pdf->AddPage();

$text = "Chicken Sandwitch";

$pdf->SetFont('Arial', '', 8);
$pdf->MultiCellWithWordWrap(20, 5, $text);

$pdf->Output();
