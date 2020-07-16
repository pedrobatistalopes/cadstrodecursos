<?php

namespace Alura\Cursos\Controller;

use Alura\Cursos\Entity\Curso;
use Alura\Cursos\helper\RenderizadorDeHtmlTrait;
use Alura\Cursos\Infra\EntityManagerCreator;


class ListarCursos  implements InterfaceControladorRequisicao
{
    use RenderizadorDeHtmlTrait;

    private $repositorioDeCursos;

    public function __construct()
    {
        $entityManager = (new EntityManagerCreator())
            ->getEntityManager();
        $this->repositorioDeCursos = $entityManager
            ->getRepository(Curso::class);
    }

    public function processaRequisicao(): void
    {
        $cursos = $this->repositorioDeCursos->findAll();
        $titulo = 'Lista de cursos';

        echo $this->renderizaHtml('cursos/listar-cursos.php',[
            'cursos' => $cursos,
            'titulo' => $titulo
        ]);

        //require __DIR__ . '/../../view/cursos/listar-cursos.php';
    }
}
