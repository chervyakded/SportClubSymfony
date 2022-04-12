<?php

namespace EfTech\SportClub\DoctrineEventSubscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\UnitOfWork;
use EfTech\SportClub\Entity\Program\Status;
use EfTech\SportClub\Entity\Programme;
use Psr\Log\LoggerInterface;

class EntityEventSubscriber implements EventSubscriber
{
    /**
     * Логгер
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     */
    public function getSubscribedEvents(): array
    {
        return [Events::preUpdate, Events::onFlush];
    }

    /**
     * @param OnFlushEventArgs $args
     * @return void
     */
    public function onFlush(OnFlushEventArgs $args): void
    {
        $uof = $args->getEntityManager()->getUnitOfWork();
        $entitiesForInsert = $uof->getScheduledEntityInsertions();
        $em = $args->getEntityManager();
        foreach ($entitiesForInsert as $entityForInsert) {
            $this->dispatchInsertStatus($entityForInsert, $uof);
            $this->dispatchInsertTextDocument($entityForInsert, $uof, $em);
        }
    }

    /**
     * @param $entityForInsert
     * @param UnitOfWork $uof
     * @param EntityManagerInterface $em
     * @return void
     */
    private function dispatchInsertTextDocument($entityForInsert, UnitOfWork $uof, EntityManagerInterface $em): void
    {
        if ($entityForInsert instanceof Programme) {
            $oldStatus = $entityForInsert->getStatus();
            $entityStatus = $em->getRepository(Status::class)
                ->findOneBy(['name' => $oldStatus->getName()]);
            $uof->propertyChanged($entityForInsert, 'status', $oldStatus, $entityStatus);
        }
    }

    /**
     * Обработка сущностей Status, которые добавляются в БД
     * @param $entityForInsert
     * @param UnitOfWork $uof
     * @return void
     */
    private function dispatchInsertStatus($entityForInsert, UnitOfWork $uof): void
    {
        if ($entityForInsert instanceof Status) {
            $uof->scheduleForDelete($entityForInsert);
        }
    }

    /**
     * Обработчик события загрузки сущности
     * @param PreUpdateEventArgs $args
     * @return void
     */
    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $entity = $args->getEntity();
        if ($entity instanceof Programme && $args->hasChangedField('status')) {
            $entityStatus = $args->getEntityManager()
                ->getRepository(Status::class)
                ->findOneBy(['name' => $entity->getStatus()->getName()]);
            $args->setNewValue('status', $entityStatus);
        }
        $this->logger->debug('Event preUpdate:' . get_class($args->getEntity()));
    }
}
