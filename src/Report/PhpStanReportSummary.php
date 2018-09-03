<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis\Report;

use Nette\Utils\Json;

final class PhpStanReportSummary
{
    /**
     * @var int
     */
    private const LIMIT = 20;

    /**
     * @return string[]
     */
    public function processPHPStanJsonFileToErrorList(string $filePath): array
    {
        $reportJson = Json::decode(file_get_contents($filePath), Json::FORCE_ARRAY);

        $errorMessages = [];

        foreach ($reportJson['files'] as $fileReport) {
            foreach ($fileReport['messages'] as $errorMessage) {
                $errorMessages[] = $errorMessage['message'];
            }
        }

        $errorMessagesCounts = array_count_values($errorMessages);

        // sort with most frequent items first
        arsort($errorMessagesCounts);

        // pick top X items
        return array_slice($errorMessagesCounts, 0, min(count($errorMessagesCounts), self::LIMIT), true);
    }
}
