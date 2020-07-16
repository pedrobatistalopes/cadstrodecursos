<?php

namespace Alura\Cursos\Controller;

use Alura\Cursos\Entity\Curso;
use Alura\Cursos\Helper\FlashMessageTraits;
use Alura\Cursos\Infra\EntityManagerCreator;

class Persistencia implements InterfaceControladorRequisicao
{
    use FlashMessageTraits;
    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private $entityManager;

    public function __construct()
    {
        $this->entityManager = (new EntityManagerCreator())->getEntityManager();
    }

    public function processaRequisicao(): void
    {
       $descricacao = filter_input(INPUT_POST,'descricao',FILTER_SANITIZE_STRING);
        $curso = new Curso();
        $curso->setDescricao($descricacao);

        $id = filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);

        if(!is_null($id) && $id !== false) {
            $curso->setId($id);
            $this->entityManager->merge($curso);
            $this->defineMensagem('success','Curso Atualizado com sucesso');
            
        }else {
            $this->entityManager->persist($curso);
            $this->defineMensagem('success','Curso inserido com sucesso');
            
        }

        $this->entityManager->flush();


        
        header('Location: /listar-cursos',true,302);
    }
}