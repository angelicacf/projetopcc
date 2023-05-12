<?php 
    # para trabalhar com sessões sempre iniciamos com session_start.
    session_start();

    # inclui os arquivos header, menu e login.
    require_once 'layouts/site/header.php';

?>
    <link rel="stylesheet" href="assets/css/boot.css" type="text/css">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <link rel="stylesheet" href="assets/css/fonticon.css" type="text/css">
    <link rel="stylesheet" href="assets/css/login.css" type="text/css">
    <link rel="stylesheet" href="assets/css/lista.css" type="text/css">
    <link rel="stylesheet" href="assets/css/formulario.css" type="text/css">
    
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
    <main>

        <!--INÍCIO MENU LATERAL-->
        <section class="main_header_lista">
            <div class="sidebar">
            <nav>
                <ul class="sidemenu">
                <li class="item_sidebar"><a href="usuario_admin_listcli.php">Clientes</a></li>
                <li class="item_sidebar"><a href="usuario_admin_listpro.php">Profissionais</a></li>
                <li class="item_sidebar"><a href="usuario_admin_listserv.php">Serviços</a></li>
                <!--<li><a href="#">Avaliações</a></li>-->
                </ul>
            </nav>
            </div>
  
        <!--FIM MENU LATERAL-->

        <div class="main_stage_lista">
            <div class="main_stage_lista_content">
               
                <article>
                    <header>
                            
                            <p>Bem-vindo(a) à página de Gerenciamento do Busca Service! Aqui você terá acesso a todas as ferramentas necessárias para alterar e excluir dados do sistema.
                            </p><br>
                            <p>Usando o menu lateral localizado à esquerda da página, você poderá navegar pelas diferentes seções de gerenciamento, que incluem clientes, profissionais e serviços. Em cada seção, você encontrará as ferramentas para o gerenciamento daquele aspecto do sistema selecionado.</p>
                        
                    </header>
               </article>
               
            </div>
        </div>
        </section>

        <!--FIM DOBRA PALCO PRINCIPAL-->

        <!--INICIO DOBRA RODAPE-->
        <section class="main_optin_footer">
            <div class="main_optin_footer_content">
                <article>
                    <header>
                        <h2><a href="usuario_admin.php" class="btn">Voltar</a></h2>
                    </header>
                </article>
            </div>
        </section>
<br><br><br><br><br>

  <?php require_once 'layouts/site/footer.php'; ?>