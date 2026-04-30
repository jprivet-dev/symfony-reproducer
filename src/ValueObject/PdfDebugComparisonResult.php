<?php

namespace App\ValueObject;

final class PdfDebugComparisonResult
{
    public function __construct(
        public readonly int $pageNumber,
        public readonly string $actualPath,
        public readonly ?string $referencePath,
        public readonly ?string $diffPath,
        public readonly ?float $distortion,
        public readonly bool $missingReference,
    ) {
    }

    public function hasPassed(float $threshold = 0.001): bool
    {
        if ($this->missingReference || $this->distortion === null) {
            return false;
        }

        return $this->distortion <= $threshold;
    }
}
