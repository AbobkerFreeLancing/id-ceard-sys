<?php

namespace Packages\IdCard\Services;

class CardPrintService
{
    /**
     * Convert millimeters to pixels at given DPI (default 300 DPI).
     */
    public static function mmToPixels(float $mm, int $dpi = 300): int
    {
        // 1 inch = 25.4 millimeters
        return (int) round(($mm / 25.4) * $dpi);
    }

    /**
     * Standard CR80 Dimensions in pixels at 300 DPI.
     */
    public static function cr80Dimensions(int $dpi = 300): array
    {
        return [
            'width_px' => self::mmToPixels(85.60, $dpi),   // ~1011px at 300 DPI
            'height_px' => self::mmToPixels(53.98, $dpi),  // ~638px at 300 DPI
            'width_mm' => 85.60,
            'height_mm' => 53.98,
            'dpi' => $dpi,
        ];
    }

    /**
     * A4 Sheet layout calculator for batch printing (8 or 10 cards per sheet).
     */
    public static function calculateA4Layout(int $cardsCount, int $cardsPerPage = 8): array
    {
        $totalPages = (int) ceil($cardsCount / $cardsPerPage);

        return [
            'total_cards' => $cardsCount,
            'cards_per_page' => $cardsPerPage,
            'total_pages' => $totalPages,
            'columns' => 2,
            'rows' => (int)($cardsPerPage / 2),
        ];
    }
}
