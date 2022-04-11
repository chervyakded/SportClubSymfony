<?php

namespace EfTech\SportClub\Controller;

use Doctrine\ORM\EntityManagerInterface;
use EfTech\SportClub\Service\ArrivalNewProgramService;
use EfTech\SportClub\Service\ArrivalNewProgramService\ResultRegisteringProgramDto;
use EfTech\SportClub\Service\ArrivalNewProgramService\NewProgramDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Symfony\Component\Routing\Annotation\Route;

class CreateRegisterProgramController extends AbstractController
{
    /**
     * Сервис для регистрации новых программ
     *
     * @var ArrivalNewProgramService
     */
    private ArrivalNewProgramService $arrivalNewProgramService;

    /**
     * Менеджер сущностей
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @param ArrivalNewProgramService $arrivalNewProgramService - сервис для регистрации новых программ
     * @param EntityManagerInterface $em - менеджер сущностей
     */
    public function __construct(
        ArrivalNewProgramService $arrivalNewProgramService,
        EntityManagerInterface   $em
    ) {
        $this->arrivalNewProgramService = $arrivalNewProgramService;
        $this->em = $em;
    }

    /**
     * @Route("/program/register", name="program_register", methods={"POST"})
     *
     * @param Request $serverRequest
     * @return Response
     */
    public function __invoke(Request $serverRequest): Response
    {
        try {
            $this->em->beginTransaction();
            $requestData = json_decode($serverRequest->getContent(), true, 10, JSON_THROW_ON_ERROR);
            $validationResult = $this->validateData($requestData);
            if (0 === count($validationResult)) {
                // Создано dto, содержащее входные данные и запущен сервис
                $responseDto = $this->runService($requestData);
                $httpCode = 201;
                $jsonData = $this->buildJsonData($responseDto);
            } else {
                $httpCode = 400;
                $jsonData = [
                    'status' => 'fail',
                    'message' => 'Переданы неверные параметры: ' . implode(', ', $validationResult),
                ];
            }
            $this->em->flush();
            $this->em->commit();
        } catch (Throwable $e) {
            $this->em->rollBack();
            $httpCode = 500;
            $jsonData = [
                'status' => 'fail',
                'message' => $e->getMessage(),
            ];
        }
        return $this->json($jsonData, $httpCode);
    }

    /**
     * Валидирует входные параметры
     *
     * @param  $requestData
     * @return array
     */
    private function validateData($requestData): array
    {
        $err = [];
        if (false === is_array($requestData)) {
            $err[] = 'Данные о новой программе не являются массивом';
        } else {
            if (false === array_key_exists('name', $requestData)) {
                $err[] = 'Отсутствует информация о названии программы';
            } elseif (false === is_string($requestData['name'])) {
                $err[] = 'Название программы должно быть строкой';
            } elseif ('' === trim($requestData['name'])) {
                $err[] = 'Название программы не может быть пустой строкой';
            }

            if (false === array_key_exists('duration', $requestData)) {
                $err[] = 'Отсутствует информация о длительности программы';
            } elseif (false === is_string($requestData['duration'])) {
                $err[] = 'Длительность программы должна быть строкой';
            } elseif ('' === trim($requestData['duration'])) {
                $err[] = 'Длительность программы не может быть пустой строкой';
            }

            if (false === array_key_exists('discount', $requestData)) {
                $err[] = 'Отсутствует информация об уровне подготовки';
            } elseif (false === is_string($requestData['discount'])) {
                $err[] = 'Уровень подготовки программы должен быть строкой';
            } elseif ('' === trim($requestData['discount'])) {
                $err[] = 'Уровень подготовки программы не может быть пустой строкой';
            }
        }
        return $err;
    }

    /**
     * Запускает сервис
     *
     * @param array $requestData
     * @return ResultRegisteringProgramDto
     */
    private function runService(array $requestData): ResultRegisteringProgramDto
    {
        $requestDto = new NewProgramDto(
            $requestData['name'],
            $requestData['duration'],
            $requestData['discount'],
        );
        return $this->arrivalNewProgramService->registerProgram($requestDto);
    }

    /**
     * Формирует данные для ответа на основе DTO с результатами работы сервиса
     *
     * @param ResultRegisteringProgramDto $responseDto
     * @return array
     */
    private function buildJsonData(ResultRegisteringProgramDto $responseDto): array
    {
        return [
            'id' => $responseDto->getId(),
            'registering_message' => $responseDto->getRegisteringMessage(),
            'status' => $responseDto->getStatus(),
        ];
    }
}
