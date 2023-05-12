<?php

require_once 'PHPProjeto/index.php';

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="css/boot.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/fonticon.css" rel="stylesheet">
    <link href="css/lista.css" rel="stylesheet">

    <title>Gerenciamento</title>
</head>

<body>
    <!--DOBRA CABEÇALHO-->

    <header class="main_header">
        <div class="main_header_content">

            <div class="listagem_info">
                <samp class="icon-books">Listagem de dados</samp>
            </div>
        </div>
    </header>
    <!--FIM DOBRA CABEÇALHO-->

    <!--DOBRA PALCO PRINCIPAL-->



    <!--1ª DOBRA-->
    <div class="main_stage">
        <div class="main_stage_content">

            <article>
                <header>
                    <table border="0" width="1300px" class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Categoria</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($servicos as $servico) :?>
                                <tr>
                                  <td><?php echo $servico->getId_serv(); ?></td>
                                  <td><?php echo $servico->nome; ?></td>
                                  <td><?php echo $servico->categoria; ?></td>
                                  <td>
                                    
                                  <a href="/versao_definitiva/PHPProjeto/editar_servico.php?id=<?php echo $servico->getId_serv(); ?>">
                                        <button type="button" class="btn btn-primary">Editar</button>&nbsp;</button>
                                    </a>
                                    <a href="excluir.php?id='.$servico->id_serv.'">
                                        <button type="button" class="btn btn-danger">Apagar</button>&nbsp;</button>
                                    </a>
                                  </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </header>
            </article>

        </div>
    </div>



        <!--FIM DOBRA PALCO PRINCIPAL-->

        <!--INCIIO DOBRA RODAPE-->
        <section class="main_optin_footer">
            <div class="main_optin_footer_content">
                <article>
                    <header>
                        <h2><a href="lista.html" class="btn">Voltar</a></h2>
                    </header>
                </article>
            </div>
        </section>

        <footer class="main_footer_rights">
            <p>ETC - Todos os direitos reservados.</p>
        </footer>
        <!--FIM DOBRA RODAPE-->
    </main>
</body>

</html>