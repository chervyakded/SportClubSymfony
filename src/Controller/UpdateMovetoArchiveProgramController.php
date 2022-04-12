<?php

namespace EfTech\SportClub\Controller;

use Doctrine\ORM\EntityManagerInterface;
use EfTech\SportClub\Exception\RuntimeException;
use EfTech\SportClub\Service\ArchiveProgramService\ArchivingResultDto;
use EfTech\SportClub\Service\ArchiveProgramService\Exception\ProgramNotFoundException;
use EfTech\SportClub\Service\ArchivingProgramService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class UpdateMovetoArchiveProgramController extends AbstractController
{
    /**
     * Сервис архивации программ
     *
     * @var ArchivingProgramService
     */
    private ArchivingProgramService $archivingProgramService;

    /**
     * Менеджер сущностей
     *
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @param ArchivingProgramService $archivingProgramService - сервис архивации программ
     * @param EntityManagerInterface  $em                      - менеджер сущностей
     */
    public function __construct(
        ArchivingProgramService $archivingProgramService,
        EntityManagerInterface  $em
    ) {
        $this->archivingProgramService = $archivingProgramService;
        $this->em                      = $em;
    }

    /**
     * @param Request $serverRequest
     * @return Response
     */
    public function __invoke(Request $serverRequest): Response
    {
        try {
            $this->em->beginTransaction();
            $attributes = $serverRequest->attributes->all();
            if (false === array_key_exists('id_programme', $attributes)) {
                throw new RuntimeException('Нет информации о текстовом документе');
            }
            $resultDto = $this->archivingProgramService->archive((int) $attributes['id_programme']);
            $httpCode = 200;
            $jsonData = $this->buildJsonData($resultDto);
            $this->em->flush();
            $this->em->commit();
        } catch (ProgramNotFoundException $e) {
            $this->em->rollBack();
            $httpCode = 404;
            $jsonData = [
                'status'  => 'fail',
                'message' => $e->getMessage(),
            ];
        } catch (Throwable $e) {
            $this->em->rollBack();
            $httpCode = 500;
            $jsonData = [
                'status'  => 'fail',
                'message' => $e->getMessage(),
            ];
        }
        return $this->json($jsonData, $httpCode);
    }

    /**
     * Подготавливает данные для успешного ответа на основе dto сервиса
     *
     * @param  ArchivingResultDto $resultDto
     * @return array
     */
    private function buildJsonData(ArchivingResultDto $resultDto): array
    {
        return [
            'id'                => $resultDto->getId(),
            'archiving_message' => $resultDto->getArchivingMessage(),
            'status'            => $resultDto->getStatus(),
        ];
    }
}
