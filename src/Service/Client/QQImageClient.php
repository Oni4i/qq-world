<?php

declare(strict_types=1);

namespace Oni4i\QQWorld\Service\Client;

use Ramsey\Uuid\Uuid;

final class QQImageClient extends AbstractQQClient
{
    private const REQUEST_URL = 'https://ai.tu.qq.com/overseas/trpc.shadow_cv.ai_processor_cgi.AIProcessorCgi/Process';

    private const SIGN_URL = 'https://h5.tu.qq.com';
    private const SIGN_KEY = 'HQ31X02e';

    public function getAnimeImage(string $imgBuffer): string
    {
        $imgData = $this->getImageData($imgBuffer);
        $sign = $this->generateSign($imgData);

        $response = $this->client->request(
            'POST',
            self::REQUEST_URL,
            [
                'body' => $imgData,
                'headers' => [
                    'Origin' => self::SIGN_URL,
                    'Referer' => self::SIGN_URL . '/',
                    'x-sign-value' => $sign,
                    'x-sign-version' => 'v1',
                    'Content-Type' => 'application/json'
                ],
                'max_duration' => 30000
            ]
        );

        return $response->getContent();
    }

    private function getImageData(string $imgBuffer): string
    {
        $imgData = [
            'images' => [base64_encode($imgBuffer)],
            'busiId' => 'different_dimension_me_img_entry', //for china ai_painting_anime_entry
            'extra' => json_encode([
                'face_rects' => [],
                'version' => 2,
                'platform' => 'web',
                'data_report' => [
                    'parent_trace_id' => Uuid::uuid4(),
                    'root_channel' => '',
                    'level' => 0,
                ]
            ])
        ];

        $imgData = json_encode($imgData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        return str_replace(["\n", '[ ', ' ]', '  '], ['',  '[', ']', ''], $imgData);
    }

    private function generateSign(string $imgData): string
    {
        return md5(sprintf('%s%d%s',
            self::SIGN_URL,
            strlen($imgData),
            self::SIGN_KEY
        ));
    }
}