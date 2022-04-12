<?php

namespace EfTech\SportClub\Controller;

use Doctrine\ORM\EntityManagerInterface;
use EfTech\SportClub\Exception\RuntimeException;
use EfTech\SportClub\Form\CreateProgramForm;
use EfTech\SportClub\Service\ArrivalNewProgramService;
use EfTech\SportClub\Service\ArrivalNewProgramService\NewProgramDto;
use EfTech\SportClub\Service\SearchProgrammeService;
use EfTech\SportClub\Service\SearchProgrammeService\SearchProgrammeCriteria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

/**
 * Контроллер, реализующий логику обработки запроса на отображение программ
 */
class ProgramAdministrationController extends AbstractController
{
    /**
     * Сервис поиска текстовых документов
     *
     * @var SearchProgrammeService
     */
    private SearchProgrammeService $searchProgrammeService;

    /**
     * Сервис регистрации программ
     *
     * @var ArrivalNewProgramService
     */
    private ArrivalNewProgramService $arrivalNewProgramService;

    /**
     * Соединение с БД
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @param SearchProgrammeService   $searchProgrammeService   - сервис поиска текстовых документов
     * @param ArrivalNewProgramService $arrivalNewProgramService - сервис регистрации программ
     * @param EntityManagerInterface   $em                       - соединение с БД
     */
    public function __construct(
        SearchProgrammeService   $searchProgrammeService,
        ArrivalNewProgramService $arrivalNewProgramService,
        EntityManagerInterface   $em
    ) {
        $this->searchProgrammeService   = $searchProgrammeService;
        $this->arrivalNewProgramService = $arrivalNewProgramService;
        $this->em                       = $em;
    }

    /**
     * @param Request $serverRequest
     * @return Response
     */
    public function __invoke(Request $serverRequest): Response
    {
        $formProgram = $this->createForm(CreateProgramForm::class);
        $formProgram->handleRequest($serverRequest);
        if ($formProgram->isSubmitted() && $formProgram->isValid()) {
            $this->create($formProgram->getData());
            $formProgram = $this->createForm(CreateProgramForm::class);
        }
        $template = 'program.administration.twig';
        $context = [
            'form_program' => $formProgram,
            'programmes' => $this->searchProgrammeService->search(
                new SearchProgrammeCriteria()
            )
        ];
            return $this->renderForm($template, $context);
    }

    /**
     * Логика валидации данных программы
     *
     * @param  array $dataToCreate
     * @return array
     */
    private function validateProgram(array $dataToCreate): array
    {
        $errs = [];
        $errName = $this->validateName($dataToCreate);
        if (0 < count($errName)) {
            $errs = array_merge($errs, $errName);
        }
        $errDuration = $this->validateDuration($dataToCreate);
        if (0 < count($errDuration)) {
            $errs = array_merge($errs, $errDuration);
        }
        $errDiscount = $this->validateDiscount($dataToCreate);
        if (0 < count($errDiscount)) {
            $errs = array_merge($errs, $errDiscount);
        }
        return $errs;
    }

    /**
     * Валидация названия программы
     *
     * @param  array $dataToCreate
     * @return array
     */
    private function validateName(array $dataToCreate): array
    {
        $errs = [];
        if (false === array_key_exists('name', $dataToCreate)) {
            throw new RuntimeException('Нет данных о названии');
        }
        if (false === is_string($dataToCreate['name'])) {
            throw new RuntimeException('Данные о названии должны быть строкой');
        }
        $nameLength = strlen(trim($dataToCreate['name']));
        $errName    = [];
        if (250 < $nameLength) {
            $errName[] = 'Название программы не может быть длиннее 250 символов';
        } elseif (0 === $nameLength) {
            $errName[] = 'Название не может быть пустым';
        }
        if (0 !== count($errName)) {
            $errs['name'] = $errName;
        }
        return $errs;
    }

    /**
     * Валидация времени программы
     *
     * @param  array $dataToCreate
     * @return array
     */
    private function validateDuration(array $dataToCreate): array
    {
        $errs = [];
        if (false === array_key_exists('duration', $dataToCreate)) {
            throw new RuntimeException('Нет данных о времени');
        }
        if (false === is_string($dataToCreate['duration'])) {
            throw new RuntimeException('Данные о времени должны быть строкой');
        }
        $durationLength = strlen(trim($dataToCreate['duration']));
        $errDuration    = [];
        if (50 < $durationLength) {
            $errDuration[] = 'Время программы не может быть длиннее 50 символов';
        } elseif (0 === $durationLength) {
            $errDuration[] = 'Время не может быть пустым';
        }
        if (0 !== count($errDuration)) {
            $errs['duration'] = $errDuration;
        }
        return $errs;
    }

    /**
     * Валидация уровня подготовки программы
     *
     * @param  array $dataToCreate
     * @return array
     */
    private function validateDiscount(array $dataToCreate): array
    {
        $errs = [];
        if (false === array_key_exists('discount', $dataToCreate)) {
            throw new RuntimeException('Нет данных об уровне подготовки');
        }
        if (false === is_string($dataToCreate['discount'])) {
            throw new RuntimeException('Данные об уровне подготовки должны быть строкой');
        }
        $discountLength = strlen(trim($dataToCreate['discount']));
        $errDiscount    = [];
        if (500 < $discountLength) {
            $errDiscount[] = 'Уровень подготовки программы не может быть длиннее 500 символов';
        } elseif (0 === $discountLength) {
            $errDiscount[] = 'Уровень подготовки не может быть пустым';
        }
        if (0 !== count($errDiscount)) {
            $errs['discount'] = $errDiscount;
        }
        return $errs;
    }

    /**
     * Создание программы
     *
     * @param array $dataToCreate
     */
    private function create(array $dataToCreate): void
    {
        try {
            $this->em->beginTransaction();
            $this->arrivalNewProgramService->registerProgram(
                new NewProgramDto(
                    $dataToCreate['name'],
                    $dataToCreate['duration'],
                    $dataToCreate['discount'],
                )
            );
            $this->em->flush();
            $this->em->commit();
        } catch (Throwable $e) {
            $this->em->rollBack();
            throw new RuntimeException(
                'Ошибка при создании программы: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }
}
