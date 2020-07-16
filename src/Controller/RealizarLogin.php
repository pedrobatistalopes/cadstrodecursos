<?php 

namespace Alura\Cursos\Controller;

use Alura\Cursos\Entity\Usuario;
use Alura\Cursos\Helper\FlashMessageTraits;
use Alura\Cursos\Infra\EntityManagerCreator;
use Doctrine\ORM\EntityManagerInterface;

class RealizarLogin implements InterfaceControladorRequisicao 
{
    use FlashMessageTraits;
    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */

     private $repositorioDeUsuarios;

    public function __construct()
    {
        $entityManager = (new EntityManagerCreator())->getEntityManager();
        $this->repositorioUsuarios = $entityManager->getRepository(Usuario::class);
    }
    public function processaRequisicao(): void
    {
        $email = filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL);
        
        if(is_null($email) || $email == false) {
            $this->defineMensagem('danger','O email digitado não é o e-mail válido');
            header('Location: /login');
            return;
        }


        $senha = filter_input(INPUT_POST,'senha',FILTER_SANITIZE_STRING);
        
         /** @var  $usuario */
        $usuario = $this->repositorioUsuarios->findOneBy(['email' => $email]);
        
        if (is_null($usuario) || !$usuario->senhaEstaCorreta($senha)) {
            $this->defineMensagem('danger','E-mail ou senha inválidos');
            header('Location: /login');
            return;
        }
        $_SESSION['logado'] = true;
        header('Location: /listar-cursos');

        
    }
} 