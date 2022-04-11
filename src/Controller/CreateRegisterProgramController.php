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
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

class CreateRegisterProgramController extends AbstractController
{
    /**
     * Сервис валидации
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

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
     * @param ValidatorInterface $validator - сервис валидации
     * @param ArrivalNewProgramService $arrivalNewProgramService - сервис для регистрации новых программ
     * @param EntityManagerInterface $em - менеджер сущностей
     */
    public function __construct(
        ValidatorInterface       $validator,
        ArrivalNewProgramService $arrivalNewProgramService,
        EntityManagerInterface   $em
    )
    {
        $this->validator = $validator;
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
     * @throws \Exception
     */
    private function validateData($requestData): array
    {
        $constraint = [
            new Assert\Type([
                'type' => 'array',
                'message' => 'Данные о новой программе не является массивом'
            ]),
            new Assert\Collection([
                'allowExtraFields' => false,
                'allowMissingFields' => false,
                'extraFieldsMessage' => 'Есть лишнее поле: {{ field }}',
                'missingFieldsMessage' => 'Отсутствует обязательное поле: {{ field }}',
                'fields' => [
                    'name' => [
                        new Assert\Type([
                            'type' => 'string',
                            'message' => 'Имя новой программы не является строкой'
                        ]),
                        new Assert\NotBlank([
                            'message' => 'Имя программы не может быть пустой строкой',
                            'normalizer' => 'trim'
                        ]),
                        new Assert\Length([
                            'min' => 1,
                            'max' => 100,
                            'minMessage' => 'Некорректная длина имени программы. Необходимо минимум {{ limit }} символов',
                            'maxMessage' => 'Некорректная длина имени программы. Необходимо максимум {{ limit }} символов'
                        ])
                    ],
                    'duration' => [
                        new Assert\Type([
                            'type' => 'string',
                            'message' => 'Длительность новой программы не является строкой'
                        ]),
                        new Assert\NotBlank([
                            'message' => 'Длительность программы не может быть пустой строкой',
                            'normalizer' => 'trim'
                        ]),
                        new Assert\Length([
                            'min' => 1,
                            'max' => 25,
                            'minMessage' => 'Некорректная длина длительности программы. Необходимо минимум {{ limit }} символов',
                            'maxMessage' => 'Некорректная длина длительности книпрограммыги. Необходимо максимум {{ limit }} символов'
                        ])
                    ],
                    'discount' => [
                        new Assert\Type([
                            'type' => 'string',
                            'message' => 'Уровень подготовки новой программы не является строкой'
                        ]),
                        new Assert\NotBlank([
                            'message' => 'Уровень подготовки программы не может быть пустой строкой',
                            'normalizer' => 'trim'
                        ]),
                        new Assert\Length([
                            'min' => 1,
                            'max' => 50,
                            'minMessage' => 'Некорректная длина уровня подготовки программы. Необходимо минимум {{ limit }} символов',
                            'maxMessage' => 'Некорректная длина уровня подготовки книпрограммыги. Необходимо максимум {{ limit }} символов'
                        ])
                    ],
                ]
            ])
        ];
        $errors = $this->validator->validate($requestData, $constraint);
        return array_map(
            static function($v){return $v->getMessage();},
            $errors->getIterator()->getArrayCopy()
        );
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
