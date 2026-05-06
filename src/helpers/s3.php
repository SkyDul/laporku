<?php

// Uncomment and use if AWS SDK is installed
if (file_exists(__DIR__ . '/../../vendor/autoload.php')) {
    require_once __DIR__ . '/../../vendor/autoload.php';
}
use Aws\S3\S3Client;
use Aws\Exception\AwsException;

function uploadToS3($filePath, $fileName) {
    $bucket = getEnvVar('S3_BUCKET');
    $keyId = getEnvVar('AWS_ACCESS_KEY_ID');
    $secretKey = getEnvVar('AWS_SECRET_ACCESS_KEY');
    $region = getEnvVar('AWS_REGION', 'ap-southeast-1');

    if (!$keyId || $keyId == 'xxxx' || !file_exists($filePath)) {
        // Fallback to local upload
        $targetDir = __DIR__ . '/../../public/uploads/';
        $targetFile = $targetDir . $fileName;
        if (copy($filePath, $targetFile)) {
            $appUrl = getEnvVar('APP_URL', '');
            return [
                'success' => true,
                's3_key' => $fileName,
                'cloudfront_url' => $appUrl . '/uploads/' . $fileName
            ];
        }
        return ['success' => false, 'error' => 'Failed to move uploaded file.'];
    }

    // AWS S3 Implementation
    try {
        $s3Client = new S3Client([
            'version' => 'latest',
            'region'  => $region,
            'credentials' => [
                'key'    => $keyId,
                'secret' => $secretKey,
            ]
        ]);

        $result = $s3Client->putObject([
            'Bucket'     => $bucket,
            'Key'        => 'laporan/' . $fileName,
            'SourceFile' => $filePath,
            #'ACL'        => 'public-read'
        ]);

        $cloudfrontDomain = getEnvVar('CLOUDFRONT_DOMAIN');
        $url = $cloudfrontDomain ? 'https://' . $cloudfrontDomain . '/laporan/' . $fileName : $result['ObjectURL'];

        return [
            'success' => true,
            's3_key' => 'laporan/' . $fileName,
            'cloudfront_url' => $url
        ];
    } catch (\Throwable $e) {
        return [
            'success' => false,
            'error' => 'S3 Error: ' . $e->getMessage()
        ];
    }
    
    return ['success' => false, 'error' => 'AWS SDK not configured'];
}
