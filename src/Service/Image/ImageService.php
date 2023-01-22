<?php

declare(strict_types=1);

namespace Oni4i\QQWorld\Service\Image;

use Oni4i\QQWorld\Service\Client\QQImageClient;
use Oni4i\QQWorld\Service\Dto\Client\AbstractResponseDto;
use Oni4i\QQWorld\Service\Dto\Client\ImageErrorResponseDto;
use Oni4i\QQWorld\Service\Dto\Client\ImageSuccessfulResponseDto;

class ImageService implements ImageServiceInterface
{
    public function __construct(
        private readonly QQImageClient $imageClient
    ) {
    }

    /**
     * Provide image string, e.g. from function file_get_contents()
     * @throws \Exception
     */
    public function generateImageByBuffer(string $buffer): AbstractResponseDto
    {
        $response = $this->imageClient->getAnimeImage($buffer);

        try {
            $jsonResponse = json_decode($response, true, 512, JSON_THROW_ON_ERROR);

            if (!$jsonResponse['code']) {
                return $this->createSuccessfulResponse($jsonResponse);
            }

            return $this->createErrorResponse($jsonResponse);

        } catch (\Exception $exception) {
            throw new \Exception('Something went wrong');
        }
    }

    private function createSuccessfulResponse(array $jsonResponse): ImageSuccessfulResponseDto
    {
        $response = (new ImageSuccessfulResponseDto());

        $extra = json_decode($jsonResponse['extra'], true);
        $response->setImgUrl($extra['img_urls'][0]);

        $this->fillResponseBaseInfo($jsonResponse, $response);

        return $response;
    }

    private function createErrorResponse(array $jsonResponse): ImageErrorResponseDto
    {
        $response = new ImageErrorResponseDto();

        $this->fillResponseBaseInfo($jsonResponse, $response);

        return $response;
    }
    
    private function fillResponseBaseInfo(array $jsonResponse, AbstractResponseDto $responseDto): void
    {
        $responseDto
            ->setMsg($jsonResponse['msg'])
            ->setCode($jsonResponse['code']);
    }
}
