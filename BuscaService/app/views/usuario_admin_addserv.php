<?php 
    # para trabalhar com sessões sempre iniciamos com session_start.
    session_start();
    
    # inclui o arquivo header e a classe de conexão com o banco de dados.
    require_once 'layouts/site/header.php';
    require_once "../database/conexao.php";

    # verifica se existe sessão de usuario e se ele é administrador.
    # se não existir redireciona o usuario para a pagina principal com uma mensagem de erro.
    # sai da pagina.
    if(!isset($_SESSION['usuario']) || $_SESSION['usuario']['perfil'] != 'ADM') {
        header("Location: index.php?error=Você não tem permissão para acessar esse recurso");
        exit;
    }

    # verifica se os dados do formulario foram enviados via POST 
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        # cria variaveis (nome, categoria, status) para armazenar os dados passados via método POST.
        $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
        $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : '';
        $status = isset($_POST['status']) ? $_POST['status'] : 0;
        
        # cria a variavel $dbh que vai receber a conexão com o SGBD e banco de dados.
        $dbh = Conexao::getInstance();

        # cria uma consulta banco de dados verificando se o usuario existe 
        # usando como parametros os campos nome e password.
        $query = "INSERT INTO `busca_service`.`servico` (`nome`,`categoria`,`status`)
                    VALUES (:nome, :categoria, :status)";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':categoria', $categoria);
        $stmt->bindParam(':status', $status);

        # executa a consulta banco de dados para inserir o resultado.
        $stmt->execute();

        # verifica se a quantiade de registros inseridos é maior que zero.
        # se sim, redireciona para a pagina de admin com mensagem de sucesso.
        # se não, redireciona para a pagina de cadastro com mensagem de erro.
        if($stmt->rowCount()) {
            header('location: usuario_admin.php?success=Servico inserido com sucesso!');
        } else {
            header('location: usuario_admin_addserv.php?error=Erro ao inserir servico!');
        }

        # destroi a conexao com o banco de dados.
        $dbh = null;
    }
?>
<body>
    <?php require_once 'layouts/admin/menu.php';?>
    <main>
        <div class="main_opc">
            <?php
                # verifca se existe uma mensagem de erro enviada via GET.
                # se sim, exibe a mensagem enviada no cabeçalho.
                if(isset($_GET['error'])) { ?>
                    <script>
                        Swal.fire({
                        icon: 'error',
                        title: 'Serviços',
                        text: '<?=$_GET['error'] ?>',
                        })
                    </script>
            <?php } ?>
            <section >
               <form action="" method="post" class="box">
               <fieldset>
                    <legend><b>Cadastrar Serviços</b></legend>
                    
                    <br><br>
                    <div class="inputBox">
                        <input type="text" name="nome" id="nome" class="inputUser" required>
                        <label for="nome" class="labelInput">Nome</label>
                    </div><br><br>
                    <div class="inputBox">
                        <input type="text" name="categoria" id="categoria" class="inputUser" required>
                        <label for="categoria" class="labelInput">Categoria</label>
                    </div><br><br>
                    <label for="status">Status</label><br>
                    <select name="status"><br><br>
                        <option value="1">Ativo</option>
                        <option value="0">Inativo</option>
                    </select><br><br>

                </fieldset>
                <div class="btn_alinhamento">
                        <button type="submit" id="submit" value="Enviar" name="salvar">Enviar</button>
                    </a>
                    <a href="opcao.html">
                        <button type="button" id="cancel" value="Cancelar" name="cancelar">Cancelar</button>
                    </a>
                    
                    
                </div>
               </form>
            </section>
            </div>

    </main>
    
</body>


</html>