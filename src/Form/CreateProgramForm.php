<?php

namespace EfTech\SportClub\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type as FormElement;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Реализация настройки формы, описывающая создание программы
 */
class CreateProgramForm extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'name',
                FormElement\TextType::class,
                [
                    'required' => true, // обязательность-необязательность поля
                    'label' => 'Название',
                    'priority' => 400,
                    'constraints' => [
                        new Assert\Type([
                            'type' => 'string',
                            'message' => 'Данные о названии программы должны быть строкой'
                        ]),
                        new Assert\NotBlank([
                            'normalizer' => 'trim',
                            'message' => 'Название программы не может быть пустым'
                        ]),
                        new Assert\Length([
                            'min' => 1,
                            'max' => 100,
                            'minMessage' => 'Минимальная длина названия должна быть не менее {{ limit }} символов',
                            'maxMessage' => 'Максимальная длина названия должна быть не более {{ limit }} символов',
                        ])
                    ]
                ])
            ->add(
                'duration',
                FormElement\TextType::class,
                [
                    'required' => true,
                    'label' => 'Время',
                    'priority' => 300,
                    'constraints' => [
                        new Assert\Type([
                            'type' => 'string',
                            'message' => 'Данные о времени программы должны быть строкой'
                        ]),
                        new Assert\NotBlank([
                            'normalizer' => 'trim',
                            'message' => 'Время программы не может быть пустым'
                        ]),
                        new Assert\Length([
                            'min' => 1,
                            'max' => 25,
                            'minMessage' => 'Минимальная длина строки должна быть не менее {{ limit }} символов',
                            'maxMessage' => 'Максимальная длина строки должна быть не более {{ limit }} символов',
                        ])
                    ]
                ])
            ->add(
                'discount',
                FormElement\TextType::class,
                [
                    'required' => true,
                    'label' => 'Уровень подготовки',
                    'priority' => 300,
                    'constraints' => [
                        new Assert\Type([
                            'type' => 'string',
                            'message' => 'Данные о уровне подготовки программы должны быть строкой'
                        ]),
                        new Assert\NotBlank([
                            'normalizer' => 'trim',
                            'message' => 'Уровень подготовки программы не может быть пустым'
                        ]),
                        new Assert\Length([
                            'min' => 1,
                            'max' => 50,
                            'minMessage' => 'Минимальная длина строки должна быть не менее {{ limit }} символов',
                            'maxMessage' => 'Максимальная длина строки должна быть не более {{ limit }} символов',
                        ])
                    ]
                ])
            ->add(
                'submit',
                FormElement\SubmitType::class,
                [
                    'label' => 'Добавить',
                    'priority' => 100
                ])
            ->setMethod('POST');
        parent::buildForm($builder, $options);
    }

}