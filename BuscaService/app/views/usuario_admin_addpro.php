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
        # cria variaveis (email, nome, perfil, status) para armazenar os dados passados via método POST.
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
        $perfil = isset($_POST['perfil']) ? $_POST['perfil'] : 'USU';
        $status = isset($_POST['status']) ? $_POST['status'] : 0;
        $password = md5('123');
        
        # cria a variavel $dbh que vai receber a conexão com o SGBD e banco de dados.
        $dbh = Conexao::getInstance();

        # cria uma consulta banco de dados verificando se o usuario existe 
        # usando como parametros os campos nome e password.
        $query = "INSERT INTO `pccsampledb`.`usuarios` (`EMAIL`,`nome`, `perfil`, `status`, `password`)
                    VALUES (:email, :nome, :perfil, :status, :password)";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':perfil', $perfil);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':password', $password);

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
            <section>
                <form action="" method="post" class="box">
                    <fieldset class="main_form">
                        <legend><b>Cadastrar Usuário</b></legend>
                        <br>
                        <div class="inputBox">
                            <input type="text" name="nome" id="nome" class="inputUser" required>
                            <label for="nome" class="labelInput">Nome completo:</label>
                        </div>

                        <div class="inputBox">
                            <input type="text" name="titulo" id="titulo" class="inputUser" required>
                            <label for="titulo" class="labelInput">Título (seu nome ou do negócio):</label>
                        </div>

                        <div class="inputBox">
                            <input type="email" name="email" id="email" class="inputUser" required>
                            <label for="email" class="labelInput">E-mail:</label>
                        </div>

                        <div class="inputBox">
                            <input type="password" name="senha" id="senha" class="inputUser" required>
                            <label for="senha" class="labelInput">Senha:</label>
                        </div>

                        <div class="inputBox">
                            <input type="text" name="cpf" id="cpf" class="inputUser" required>
                            <label for="cpf" class="labelInput">CPF:</label>
                        </div>

                        <div class="inputBox">
                            <input type="text" id="cep" name="cep" class="inputUser" maxlength="8" minlength="8" required>
                            <label for="cep" class="labelInput">CEP:</label><br>
                        </div>

                        <div class="inputBox">
                            <input type="text" name="estado" id="estado" class="inputUser" required>
                            <label for="uf" class="labelInput">Estado:</label>
                        </div>

                        <div class="inputBox">
                            <input type="text" name="cidade" id="cidade" class="inputUser" required>
                            <label for="cidade" class="labelInput">Cidade:</label>
                        </div>

                        <div class="inputBox">
                            <input type="text" name="bairro" id="bairro" class="inputUser" required>
                            <label for="bairro" class="labelInput">Bairro:</label>
                        </div>

                        <div class="inputBox">
                            <input type="text" name="endereco" id="endereco" class="inputUser" required>
                            <label for="endereco" class="labelInput">Logradouro:</label>
                        </div>

                        <div class="inputBox">
                            <input type="tel" name="telefone-whatsapp" id="telefone-whatsapp" class="inputUser"
                                minlength="14" maxlength="14" required>
                            <label for="telefone-whatsapp" class="labelInput">Celular (WhatsApp):</label>
                        </div>

                        <div class="inputBox">
                            <input type="tel" name="telefone-geral" id="telefone-geral" class="inputUser" minlength="14"
                                maxlength="14" required>
                            <label for="telefone-geral" class="labelInput">Telefone:</label>
                        </div>



                        <div class="seleciona_servicos">
                            <label for="servicos">Serviços oferecidos:</label>
                            <div class="servicos_lista">

                                <!-- Construção -->
                                <div class="coluna_servicos">
                                    <div class="categoria_servicos">
                                        <h3>Construção</h3>
                                        <input type="checkbox" id="pedreiro" name="servico[]" value="pedreiro">
                                        <label for="pedreiro">Pedreiro</label><br>
                                        <input type="checkbox" id="encanador" name="servico[]" value="encanador">
                                        <label for="encanador">Encanador</label><br>
                                        <input type="checkbox" id="eletricista" name="servico[]" value="eletricista">
                                        <label for="eletricista">Eletricista</label><br>
                                        <input type="checkbox" id="marceneiro" name="servico[]" value="marceneiro">
                                        <label for="marceneiro">Marceneiro</label><br>
                                    </div>
                                </div>

                                <!-- Reforma -->
                                <div class="coluna_servicos">
                                    <div class="categoria">
                                        <h3>Reforma</h3>
                                        <input type="checkbox" id="pintor" name="servico[]" value="pintor">
                                        <label for="pintor">Pintor</label><br>
                                        <!-- Adicionar serviços relacionados à reforma -->
                                    </div>
                                </div>

                                <!-- Decoração -->
                                <div class="coluna_servicos">
                                    <div class="categoria">
                                        <h3>Decoração</h3>
                                        <input type="checkbox" id="jardineiro" name="servico[]" value="jardineiro">
                                        <label for="jardineiro">Jardineiro</label><br>
                                        <!-- Adicionar serviços relacionados à decoração -->
                                    </div>
                                </div>

                                <!-- Saúde -->
                                <div class="coluna_servicos">
                                    <div class="categoria">
                                        <h3>Saúde</h3>
                                        <input type="checkbox" id="dentista" name="servico[]" value="dentista">
                                        <label for="dentista">Dentista</label><br>
                                        <input type="checkbox" id="nutricionista" name="servico[]"
                                            value="nutricionista">
                                        <label for="nutricionista">Nutricionista</label><br>
                                    </div>
                                </div>

                                <!-- Alimentação -->
                                <div class="coluna_servicos">
                                    <div class="categoria">
                                        <h3>Alimentação</h3>
                                        <input type="checkbox" id="cozinheiro" name="servico[]" value="cozinheiro">
                                        <label for="cozinheiro">Cozinheiro</label><br>
                                        <!-- Adicionar serviços relacionados à alimentação -->
                                    </div>
                                </div>

                                <!-- Segurança -->
                                <div class="coluna_servicos">
                                    <div class="categoria">
                                        <h3>Segurança</h3>
                                        <input type="checkbox" id="porteiro" name="servico[]" value="porteiro">
                                        <label for="porteiro">Porteiro</label><br>
                                        <input type="checkbox" id="vigilante" name="servico[]" value="vigilante">
                                        <label for="vigilante">Vigilante</label><br>
                                        <!-- Adicionar serviços relacionados à segurança -->
                                    </div>
                                </div>

                                <!-- Tecnologia -->
                                <div class="coluna_servicos">
                                    <div class="categoria">
                                        <h3>Tecnologia</h3>
                                        <input type="checkbox" id="tec-informatica" name="servico[]"
                                            value="tec-informatica">
                                        <label for="tec-informatica">Técnico em Informática</label><br>
                                        <input type="checkbox" id="conserto-celulares" name="servico[]"
                                            value="conserto-celulares">
                                        <label for="conserto-celulares">Conserto de Celulares</label><br>
                                        <!-- Adicionar mais checkboxes para os outros serviços -->
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="inputBox">
                            <label for="field_image"><span>*</span>Imagem do perfil (370x370):</label>
                            <p class="custom-file">
                                <input type="file" class="custom-file-input" name="image" id="field_image"
                                    data-titulo="Imagem" data-obrigatorio="1" accept="image/*">
                                <label class="custom-file-label" for="field_image"> para a imagem do perfil
                                    ( JPG ou PNG
                                    )</label>
                            </p>
                        </div>

                        <div class="inputBox">
                            <label for="status" class="labelInput">Status:</label><br>
                            <select name="status" id="status" class="inputUser" required>
                                <option value="1">Ativo</option>
                                <option value="0">Inativo</option>
                            </select>
                        </div>


                        <div class="inputBox">
                            <label for="field_conteudo"><span></span>Fale um pouco sobre você ou sobre o
                                seu negócio:
                            </label><br>
                            <textarea class="descricao" id="field_conteudo" name="conteudo" rows="3"
                                data-titulo="Conteúdo" data-obrigatorio="1"></textarea>
                        </div>


                        <div class="row galeria">

                            <div class="col-6 col-sm-3 col-lg-2 ">
                                <div class="blc blc0">

                                    <div class="img">
                                        <input type="file" data-input="0" accept="image/*" />

                                        <p> Selecionar foto </p>
                                    </div>

                                    <a href="javascript:;" onclick="removeImgGalery('0')"> Excluir </a>

                                </div>

                                <div class="blc blc1">

                                    <div class="img">
                                        <input type="file" data-input="1" accept="image/*" />

                                        <p> Selecionar foto </p>
                                    </div>

                                    <a href="javascript:;" onclick="removeImgGalery('1')"> Excluir </a>

                                </div>



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

        <script src="https://code.jquery.com/jquery-3.6.0.min.js">
        //biblioteca do JavaScript(necessário pra rodar códigos .js)
        </script>

        <script>
        var checkboxes = document.querySelectorAll('input[type=checkbox][name="servico[]"]');
        var maxServicos = 6;

        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                var checkedCount = document.querySelectorAll(
                    'input[type=checkbox][name="servico[]"]:checked').length;
                if (checkedCount > maxServicos) {
                    checkbox.checked = false;
                }
            });
        });
        </script>


        <script src="assets/js/cep.js">
        //formata cep e o faz preencher outros campos automaticamente
        </script>
        <script src="assets/js/telefone.js">
        //formata o telefone
        </script>
        <script src="assets/js/cpf.js">
        //formata o cpf
        </script>
        </div>


    </main>

</body>


</html>