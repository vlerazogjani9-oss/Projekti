<?php
/**
 * Privacy overlay: replace real company names and locations with fictitious ones for display.
 * Used on all pages that show job listings so no real company/location is shown.
 */

function getJobDisplay(array $job) {
    static $map = [
        'BrandingX' => ['company' => 'Studio Alpha', 'location' => 'Qendra, Prishtinë'],
        'PBC SH.P.K' => ['company' => 'Biz Solutions SH.P.K', 'location' => 'Lagjja e Re, Prishtinë'],
        'Raiffeisen Tech Kosovo' => ['company' => 'Tech Solutions Kosovo', 'location' => 'Tophane, Prishtinë'],
    ];
    $company = $job['company'] ?? '';
    if (isset($map[$company])) {
        $job['company'] = $map[$company]['company'];
        $job['location'] = $map[$company]['location'];
    }
    return $job;
}
