<?php

namespace Alura\Cursos\Controller;

use Alura\Cursos\helper\RenderizadorDeHtmlTrait;

class FormularioInsercao implements InterfaceControladorRequisicao
{
    use RenderizadorDeHtmlTrait;
    public function processaRequisicao(): void
    {
        $titulo = 'Novo curso';
       echo $this->renderizaHtml('cursos/formulario.php',[
            'titulo' => $titulo
        ]);

    }
}
