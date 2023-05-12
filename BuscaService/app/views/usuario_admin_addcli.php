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
        header("Location: index.php?error=Usuário não tem permissão para acessar esse recurso");
        exit;
    }

    # verifica se os dados do formulario foram enviados via POST 
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        # cria variaveis (nome, email, password, cpf, telefone, cep, estado, cidade, bairro, perfil, status, dataregcli) para armazenar os dados passados via método POST.
        $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : 'USU';
        $password = md5('123');

        $cpf = isset($_POST['cpf']) ? $_POST['cpf'] : '';
        $telefone = isset($_POST['telefone']) ? $_POST['telefone'] : '';
        $cep = isset($_POST['cep']) ? $_POST['cep'] : '';
        $estado = isset($_POST['estado']) ? $_POST['estado'] : '';
        $cidade = isset($_POST['cidade']) ? $_POST['cidade'] : '';
        $bairro = isset($_POST['bairro']) ? $_POST['bairro'] : '';
        $perfil = isset($_POST['perfil']) ? $_POST['perfil'] : '';
        $status = isset($_POST['status']) ? $_POST['status'] : 0;

        
        # cria a variavel $dbh que vai receber a conexão com o SGBD e banco de dados.
        $dbh = Conexao::getInstance();

        # cria uma consulta banco de dados verificando se o usuario existe 
        # usando como parametros os campos nome e password.
        $query = "INSERT INTO `busca_service`.`cliente` (`nome`,`email`, `password`, `status`, `password`)
                    VALUES (:nome, :nome, :password, :status, :password)";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':cep', $cep);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':cidade', $cidade);
        $stmt->bindParam(':bairro', $bairro);
        $stmt->bindParam(':perfil', $perfil);
        $stmt->bindParam(':status', $status);

        # executa a consulta banco de dados para inserir o resultado.
        $stmt->execute();

        # verifica se a quantiade de registros inseridos é maior que zero.
        # se sim, redireciona para a pagina de admin com mensagem de sucesso.
        # se não, redireciona para a pagina de cadastro com mensagem de erro.
        if($stmt->rowCount()) {
            header('location: usuario_admin.php?success=Usuário inserido com sucesso!');
        } else {
            header('location: usuario_admin_add.php?error=Erro ao inserir usuário!');
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
                        title: 'Usuários',
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
                        <input type="email" name="email" id="email" class="inputUser" required>
                        <label for="email" class="labelInput">E-mail</label>
                    </div><br><br>
                    <div class="inputBox">
                        <input type="text" name="nome" id="nome" class="inputUser" required>
                        <label for="nome" class="labelInput">Nome</label>
                    </div>
                    
                    <br><br>
                    <br>
                    <label for="perfil">Perfil</label><br>
                    <select name="perfil"><br><br>
                        <option value="USU">Usuário</option>
                        <option value="EDI">Editor</option>
                        <option value="GER">Gerente</option>
                        <option value="ADM">Administrador</option>
                    </select><br><br>
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