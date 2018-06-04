<?php

/*
 * Copyright (C) 2015-2018 Libre Informatique
 *
 * This file is licenced under the GNU LGPL v3.
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace PiaApi\Controller\BackOffice;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Pagerfanta\PagerfantaInterface;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use PiaApi\Entity\OAuth\User;
use PiaApi\Entity\Pia\Structure;

class BackOfficeAbstractController extends Controller
{
    protected function buildPager(
        Request $request,
        string $entityClass,
        ?int $defaultLimit = 20,
        ?string $pageParameter = 'page',
        ?string $limitParameter = 'limit'
    ): PagerfantaInterface {
        $queryBuilder = $this->getDoctrine()->getRepository($entityClass)->createQueryBuilder('e');

        $queryBuilder
            ->orderBy('e.id', 'DESC');

        $adapter = new DoctrineORMAdapter($queryBuilder);

        $page = $request->get($pageParameter, 1);
        $limit = $request->get($limitParameter, $defaultLimit);

        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage($limit);
        $pagerfanta->setCurrentPage($pagerfanta->getNbPages() < $page ? $pagerfanta->getNbPages() : $page);

        return $pagerfanta;
    }

    protected function buildUserPagerByStructure(
          Request $request,
            Structure $structure,
            ?int $defaultLimit = 20,
            ?string $pageParameter = 'page',
            ?string $limitParameter = 'limit'
        ): PagerfantaInterface {
        $queryBuilder = $this->getDoctrine()->getRepository(User::class)->createQueryBuilder('e');

        $queryBuilder
                ->orderBy('e.id', 'DESC')
                ->where('e.structure = :structure')
                ->setParameter('structure', $structure);

        $adapter = new DoctrineORMAdapter($queryBuilder);

        $page = $request->get($pageParameter, 1);
        $limit = $request->get($limitParameter, $defaultLimit);

        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage($limit);
        $pagerfanta->setCurrentPage($pagerfanta->getNbPages() < $page ? $pagerfanta->getNbPages() : $page);

        return $pagerfanta;
    }
}
