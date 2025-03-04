<style>
    .badgebox {
        opacity: 0;
    }

    .badgebox+.badge {
        text-indent: -999999px;
        width: 27px;
    }

    .badgebox:focus+.badge {

        box-shadow: inset 0px 0px 5px;
    }

    .badgebox:checked+.badge {
        text-indent: 0;
    }
</style>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.validate.js"></script>
<div class="row-fluid" style="margin-top:0">

    <div id="blCabeca" title="sitename">
        <?php
        //include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
        // protegePagina(); // Chama a função que protege a página
        //				var_dump($_POST);

        $conta = $usuario->conta_Usuario;
        $nivel = $usuario->permissoes_id;
        $contaA = $usuario->celular;
        //$contaA = $_SESSION['conta_acesso'];
        //$nivel = $_SESSION['nivel_acesso'];			
        if (session_status() !== PHP_SESSION_ACTIVE) { //Verificar se a sessão não já está aberta.
            session_start();
        }
        foreach ($result_caixas as $rcx) {
            if ($usuario->conta_Usuario == 99) {
                $contaNome = "Todas contas";
            } else {
                $contaNome = $rcx->nome_caixa;
            }
        }

        ?>
    </div>
</div>

<?php

$aLancSemAnexo = $this->permission->checkPermission($this->session->userdata('permissao'), 'aLancSemAnexo') ? 1 : 0;

if (isset($_SESSION['conta'])) {

    $conta = ($_SESSION['conta']);
    if (null !== ($_SESSION['tipoCont']))    $tipCont        = ($_SESSION['tipoCont']);
    if (null !== ($_SESSION['cod_Ass']))     $cod_assoc      = ($_SESSION['cod_Ass']);
    if (null !== ($_SESSION['cod_Comp']))    $cod_compassion = ($_SESSION['cod_Comp']);
    if (null !== ($_SESSION['numeroDoc']))   $num_Doc        = ($_SESSION['numeroDoc']);
    if (null !== ($_SESSION['numDocFiscal'])) $numDocFiscal   = ($_SESSION['numDocFiscal']);
    if (null !== ($_SESSION['razaoSoc']))    $razaoSoc       = ($_SESSION['razaoSoc']);
    if (null !== ($_SESSION['descri']))      $descri         = ($_SESSION['descri']);
    if (null !== ($_SESSION['valorFin']))    $valorFin       = ($_SESSION['valorFin']);
    if (null !== ($_SESSION['tipoPag']))     $tipo_Pag       = ($_SESSION['tipoPag']);
    if (null !== ($_SESSION['tipoES']))      $tipoES         = ($_SESSION['tipoES']);
    if (null !== ($_SESSION['cadastrante'])) $cadastrante    = ($_SESSION['cadastrante']);
    if (null !== ($_SESSION['presentes'])) {
        $presentes      = ($_SESSION['presentes']);
        if (isset($_SESSION['qtd_presentes'])) if (null !== ($_SESSION['qtd_presentes'])) $qtd_presentes = ($_SESSION['qtd_presentes']);
    }
    if (isset($_SESSION['id_presentes'])) $id_presentes  = ($_SESSION['id_presentes']);
    if (isset($_SESSION['senhaAdm']))     $senhaAdm      = ($_SESSION['senhaAdm']);
    if (null !== ($_SESSION['dataVenda']))     $dataVenda    = $_SESSION['dataVenda'];

    if ($conta == 5 && $tipoES == 1) $conta = 4;
} else { //Se a pagina foi chamada pela página cadatrarLançamento ou seja tentar denovo

    unset($_SESSION['conta']);
    unset($_SESSION['tipoCont']);
    unset($_SESSION['cod_Ass']);
    unset($_SESSION['cod_Comp']);
    unset($_SESSION['numeroDoc']);
    unset($_SESSION['numDocFiscal']);
    unset($_SESSION['razaoSoc']);
    unset($_SESSION['descri']);
    unset($_SESSION['valorFin']);
    unset($_SESSION['tipoPag']); //Id do registro com o ultimo saldo pa ser desmarcado quando cadastrar
    unset($_SESSION['tipoES']);
    unset($_SESSION['conta_Destino']);
    unset($_SESSION['cadastrante']);
    unset($_SESSION['qtd_presentes']);
    unset($_SESSION['id_presentes']);
    unset($_SESSION['senhaAdm']);

    // var_dump($_POST);
    $contaA = isset($_POST["tab"]) && null !== ($_POST["tab"])  ?   $_POST["tab"]  : '';
    $contaA = isset($_POST["tipop"]) && null !== ($_POST["tipop"])  ?   $_POST["tipop"]  : '';
    // **SE FOR ENTRADA E 518 A CONTA SERÁ 214
    $contt = isset($_POST["conta"]) && null !== ($_POST["conta"])  ?   $_POST["conta"]  : '';
    if ($contt != '') {
        if ($_POST['conta'] == 5 && $_POST['tipoES'] == 1 && $_POST['tipCont'] != 'Suporte') $conta = 4;
        else $conta = $_POST['conta'];
        $tipCont = $_POST["tipCont"];
        $tipoES = $_POST["tipoES"];
        $presentes = $_POST["presentes"];
        $multiLance = '0';

        if (($tipCont == "Suporte" && $presentes == "true")) {
            echo "<center><font color = red >O tipo de conta selecionado foi Suporte (pequeno caixa).</font>";
            echo "<font color = red >Verifique se a opção esta correta. </font></br></center>";
            //echo "<center><font color = red >Para presentes especiais você deve retornar e </font>";
            //	echo "<font color = red >selecionar tipo de conta Corrente!</font></center>";
            //	$presentes = "false";
            // exit;
        }
        //$conta = $_SESSION['Cont'];
        //$tipCont = $_SESSION['t_Cont'];
    } else {
        $tipCont = '';
        $tipoES = '';
        $presentes = '';
        $multiLance = '0';
    }
}

if ($tipoES == 0) $tipoEnt_Sai = "Despesa";
else if ($tipoES == 1) $tipoEnt_Sai = "Receita";

$contaNome = $conta != 0 ? $this->session->userdata('conta' . $conta . '_nome') : "Retorne a pagina anterior o selecione uma conta para lançamento";

$ano = date("Y");
$mes = date("m");
$ano0 = $ano;
$ano2 = $ano;
switch ($mes) {
    case "01":
        $mes0 = "12";
        $mes = "01";
        $mes2 = "02";
        $ano0 = $ano - 1;
        break;
    case "02":
        $mes0 = "01";
        $mes = "02";
        $mes2 = "03";
        break;
    case "03":
        $mes0 = "02";
        $mes = "03";
        $mes2 = "04";
        break;
    case "04":
        $mes0 = "03";
        $mes = "04";
        $mes2 = "05";
        break;
    case "05":
        $mes0 = "04";
        $mes = "05";
        $mes2 = "06";
        break;
    case "06":
        $mes0 = "05";
        $mes = "06";
        $mes2 = "07";
        break;
    case "07":
        $mes0 = "06";
        $mes = "07";
        $mes2 = "08";
        break;
    case "08":
        $mes0 = "07";
        $mes = "08";
        $mes2 = "09";
        break;
    case "09":
        $mes0 = "08";
        $mes = "09";
        $mes2 = "10";
        break;
    case "10":
        $mes0 = "09";
        $mes = "10";
        $mes2 = "11";
        break;
    case "11":
        $mes0 = "10";
        $mes = "11";
        $mes2 = "12";
        break;
    case "12":
        $mes0 = "11";
        $mes = "12";
        $mes2 = "01";
        $ano2 = $ano + 1;
        break;
}
$data1 = date($ano . '-' . $mes . '-01'); //Cria a variavel data inicial com o mês e o ano atual sendo dia 01
$data2 = date($ano2 . '-' . $mes2 . '-01'); //Cria a variavel data final com o mês seguinte sendo dia 01
$data_mes_Anterior = date($ano0 . '-' . $mes0 . '-01'); //Cria a variavel data do dia 01 de 1 mes atráz

if (!$resultUltimo || $resultUltimo == null) {
    $id_fin = 0;
    $saldo_Atual = 0.00;
    $dataUlt_saldo = 0.00;
    $dataUlt_saldoExib = implode('/', array_reverse(explode('-', $dataUlt_saldo)));
    $saldo_AtualExib = number_format((float)str_replace(",", ".", $saldo_Atual), 2, ',', '.');
} else {

    foreach ($resultUltimo as $rU) {

        $id_fin = $resultUltimo->id_fin;
        $saldo_Atual = $resultUltimo->saldo;
        $dataUlt_saldo = $resultUltimo->dataFin;
        $dataUlt_saldoExib = implode('/', array_reverse(explode('-', $dataUlt_saldo)));
        $saldo_AtualExib = number_format((float)str_replace(",", ".", $saldo_Atual), 2, ',', '.');
    }
}           //echo '  - mês atual '.$mes.' data prox mês '.$data2.' data mês anterior'.$data_mes_Anterior;
//echo '</br>  Saldo em '.$dataUlt_saldo.' R$ '. $saldo_Atual.'</br>';

echo  "<strong>CISCOF - Lançamento para conta - " . $contaNome . " | " . $usuario->idUsuarios . " " . $usuario->nome . " - Nivel de acesso " . $nivel . " </strong> ";

?>
<div class="span12">
    <div class="widget-box">
        <div class="widget-title">
            <h5> <span class="icon">
                    <i class="icon-folder-open"></i>
                </span>Lançamento
                <?php echo " da conta -  " . $conta . ' - ' . $contaNome . " | C." . $tipCont . " Saldo atual R$ ";
                if (isset($saldo_AtualExib)) echo $saldo_AtualExib;
                if (isset($dataUlt_saldoExib)) echo " | em " . $dataUlt_saldoExib; ?></h5>
            <H4><?php echo $tipoEnt_Sai; ?></H4>
        </div>

        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-folder-open"></i>
                </span>
                <ul class="nav nav-tabs">
                    <li class="active" id="tabDetalhes"><a href="#tab1" data-toggle="tab">Detalhes do lançamento</a></li>
                    <li class="active" id="obs"><a href="#tab1" data-toggle="tab"><font color=red>Você poderá anexar arquivos nesta página ao preencher todos campos</font></a></li>
                </ul>
            </div>

            <div class="widget-content nopadding">


                <div class="tab-content">
                    <div class="tab-pane active" id="tab1">

                        <div class="span12" id="divCadastrarOs">
                            <?php //if($custom_error == true)
                            { ?>
                                <!--
                                    <div class="span12 alert alert-danger" id="divInfo" style="padding: 1%;">Dados incompletos, verifique os campos com asterisco ou se selecionou corretamente cliente e responsável.</div>
                                    -->
                            <?php } ?>
                            <form action="<?php echo current_url(); ?>" method="post" id="formVendas">


                                <input name="cadastrante" type="hidden" value="<?php echo $usuario->idUsuarios ?>" />
                                <input name="tab" type="hidden" value="<?php echo $contaA ?>" />
                                <input name="tipop" type="hidden" value="<?php echo $nivel ?>" />
                                <input name="conta" type="hidden" value="<?php echo $conta ?>" />
                                <input name="tipCont" type="hidden" value="<?php echo $tipCont ?>" />
                                <input name=" tipoES" type="hidden" value="<?php echo  $tipoES ?>" />
                                <input name="presentes" type="hidden" value="<?php echo $presentes ?>" />

                                <input name="tab" type="hidden" value="aenpFin" />
                                <input name="caixa" type="hidden" value="<?php echo $conta ?>" />
                                <input name="tipoCont" type="hidden" value="<?php echo $tipCont ?>" />
                                <input name="tipContNome" type="hidden" value="<?php echo $tipCont ?>" />
                                <input name="saldo_Atual" type="hidden" value="<?php echo $saldo_Atual ?>" />
                                <input name="id_fin" type="hidden" value="<?php echo $id_fin ?>" />
                                <input name="diaUm_mêsAtual" type="hidden" value="<?php echo $data1 ?>" />
                                <input name="dataUlt_saldo" type="hidden" value="<?php echo $dataUlt_saldo ?>" />
                                <input name="op" type="hidden" value="opCad" />
                                <input name="tipoConsulta" type="hidden" value=3 />
                                <?php
                                //******* Se a solicitação de lançamento deu erro e voltou, os campos são Realimentados
                                if (isset($_SESSION['conta'])) { ?>

                                    <div class="span6">

                                        <?php
                                        if ($presentes == "true") {
                                            if ($tipoES == 0) {     ?>
                                                <p class="cod_Comp">
                                                    <label for="compassion">Código Compassion *</label>
                                                    <select id="cod_Comp" name="cod_Comp" class="span12">

                                                        <option value="D07 - 0730">
                                                            D07 - 0730 | Presentes - Beneficiário/Família /Projeto | FUNDOS ESPECIAIS COMPASSION</option>

                                                    </select>
                                                </p>
                                                <p class="cod_ass">
                                                    <label for="cod_ass">Código IEADALPE *</label>
                                                    <select id="cod_Ass" name="cod_Ass" class="span12">
                                                        <option value="D06-010">
                                                            D06-010 | PRESENTES ESPECIAIS (Compassion)</option>
                                                    </select>
                                                </p>
                                            <?php
                                            } else if ($tipoES == 1) {  ?>
                                                <p class="cod_Comp">
                                                    <label for="compassion">Código Compassion *</label>
                                                    <select id="cod_Comp" name="cod_Comp" class="span12">
                                                        <option value="R01 - 1030">
                                                            R01 - 1030 | Presentes - Beneficiário/Família /Projeto | FUNDOS ESPECIAIS COMPASSION</option>
                                                    </select>
                                                </p>
                                                <p class="cod_ass">
                                                    <label for="cod_ass">Código IEADALPE *</label>
                                                    <select id="cod_Ass" name="cod_Ass" class="span12">
                                                        <option value="R01">
                                                            R01 | DOAÇÕES COMPASSION </option>
                                                    </select>
                                                </p>
                                            <?php

                                            }
                                        } else {
                                            if ($conta <  4 || $conta >  8) {
                                                echo '<input id="cod_Comp" name="cod_Comp"  type=hidden value=III-III />';
                                            } else {
                                                //  $query = mysqli_query($conex, "SELECT * FROM cod_compassion WHere  ent_Sai = 0 ");
                                            ?>
                                                <p class="cod_Comp">
                                                    <label for="compassion">Código Compassion *</label>
                                                    <select id="cod_Comp" name="cod_Comp">
                                                        <option value="">Opção financeira Compassion</option>
                                                        <?php
                                                        if ($tipoES == 0) {
                                                            foreach ($result_codComp as $rcodComp) {
                                                                if ($rcodComp->ent_SaiComp == 0 && $rcodComp->codigoNovo == 1) { ?>
                                                                    <option value="<?php echo $rcodComp->cod_Comp ?>">
                                                                        <?php echo ' ' . $rcodComp->cod_Comp . " | " . $rcodComp->descricao . " | " . $rcodComp->area_Cod . ' ' ?></option>
                                                                <?php } else {
                                                                }
                                                            }
                                                        } else 
                                                        if ($tipoES == 1) {
                                                            foreach ($result_codComp as $rcodComp) {
                                                                if ($rcodComp->ent_SaiComp == 1 && $rcodComp->codigoNovo == 1) {
                                                                ?>
                                                                    <option value="<?php echo $rcodComp->cod_Comp ?>">
                                                                        <?php echo ' ' . $rcodComp->cod_Comp . " | " . $rcodComp->descricao . " | " . $rcodComp->area_Cod . ' ' ?></option>
                                                        <?php } else {
                                                                }
                                                            }
                                                        } ?>
                                                    </select>
                                                </p>
                                            <?php }    ?>
                                            <p class="cod_ass">
                                                <?php

                                                foreach ($result_codIead as $rcodIead) {
                                                    if ($rcodIead->cod_Ass == $cod_assoc) {
                                                        $cod_A =   $rcodIead->cod_Ass;
                                                        $descricao_A = $rcodIead->descricao_Ass;
                                                    }
                                                } ?>

                                                <label for="cod_ass">Código IEADALPE *</label>
                                                <select id="cod_Ass" name="cod_Ass">
                                                    <option value="">Oopção Financeira IEADALPE</option>
                                                    <option value="<?php echo $cod_A ?>">
                                                        <?php echo $cod_A . " | " . $descricao_A ?></option>
                                                    <?php
                                                    if ($tipoES == 0) {
                                                        foreach ($result_codIead as $rcodIead) {
                                                            if ($rcodIead->ent_SaiAss == 0) { ?>
                                                                <option value="<?php echo $rcodIead->cod_Ass ?>">
                                                                    <?php echo $rcodIead->cod_Ass . " | " . $rcodIead->descricao_Ass ?></option>
                                                            <?php } else {
                                                            }
                                                        }
                                                    } else 
                                                    if ($tipoES == 1) {
                                                        foreach ($result_codIead as $rcodIead) {
                                                            if ($rcodIead->ent_SaiAss == 1) {
                                                            ?>
                                                                <option value="<?php echo $rcodIead->cod_Ass ?>">
                                                                    <?php echo '  ' . $rcodIead->cod_Ass . " |
                                                                " . $rcodIead->descricao_Ass ?></option>
                                                    <?php } else {
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </p>

                                        <?php }
                                        ?>
                                        <p class="numeroDocBancario">
                                            <?php
                                            if ($conta <> 3) { ?>
                                                <label for="numeroDocBanco">Número do Documento Bancário</label>
                                                <input id="numeroDoc" name="numeroDoc" value="<?php echo $num_Doc ?>" />
                                            <?php }
                                            ?>
                                            <span class="style1">*</span>
                                        </p>
                                        <p class="docFiscal">
                                            <label for="numeroDocFiscal">Número do Documento Fiscal</label>
                                            <td>
                                                <input id="numDocFiscal" name="numDocFiscal" value="<?php echo $numDocFiscal ?>" />
                                                <font color=red> *</font>
                                            </td>
                                        </p>
                                        <p class="docFiscal">
                                            <label for="dataInicial">Data do evento financeiro<span class="required">*</span></label>
                                            <input id="dataVenda" class="span6 datepicker" type="Text" name="dataVenda" value="<?php echo $dataVenda; ?>" />
                                        </p>

                                        <p class="conta">
                                            <label for="conta">à beneficio da conta</label>
                                            <select id="conta_Destino" name="conta_Destino">
                                                <option value="<?php echo $conta ?>"><?php echo $conta . ' | ' . $contaNome; ?></option>
                                                <?php
                                                foreach ($result_caixas as $rcx) {
                                                    if ($usuario->conta_Usuario == 99)
                                                        if (($conta < 4) || ($conta > 8)) {
                                                            if ($rcx->id_caixa != 5) {
                                                ?>
                                                            <option value="<?php echo $rcx->id_caixa ?>"><?php echo $rcx->id_caixa . " | " . $rcx->nome_caixa ?></option>
                                                <?php
                                                            }
                                                        }
                                                }
                                                ?>
                                            </select>
                                            <font color=red><span class="style1"> * </span></font>
                                        </p>


                                    </div>

                                    <div class="span5">
                                        <?php
                                        if ($tipCont == "Corrente") { ?>
                                            <script type="text/javascript">
                                                function id(el) {
                                                    return document.getElementById(el);
                                                }

                                                function mostra(el) {
                                                    id(el).style.display = 'block';
                                                }

                                                function esconde_todos(el, tagName) {
                                                    var tags = el.getElementsByTagName(tagName);
                                                    for (var i = 0; i < tags.length; i++) {
                                                        tags[i].style.display = 'none';
                                                    }
                                                }
                                                window.onload = function() {
                                                    id('cheq').style.display = 'none';
                                                    id('rd-time').onchange = function() {
                                                        esconde_todos(id('palco'), 'div');
                                                        mostra(this.value);
                                                    }
                                                    var radios = document.getElementsByTagName('input');
                                                    for (var i = 0; i < radios.length; i++) {
                                                        if (radios[i].type == 'radio') {
                                                            radios[i].onclick = function() {
                                                                esconde_todos(id('palco'), 'div');
                                                                mostra(this.value);
                                                            }
                                                        }
                                                    }
                                                }
                                            </script>



                                            <label for="tiposaida">Forma de saida</label>
                                            <input name="tipoPag" type="radio" value="trans" CHECKED>Transferência
                                            <input name="tipoPag" id="rd-time" type="radio" value="cheq" style="margin-top:15px;">Cheque

                                            <div id="palco">
                                                <div id="cheq">

                                                    <label for="tiposaida"><input name="chequeCompen" type="checkbox" value="0">Cheque já compensado</label>

                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>

                                        <div id="blAux6">
                                            <p class="VALOR">
                                                <label for="valor">Valor do lançamento 502</label>
                                                <span class="style1">* R$ </span><input text-align="right" name="valorFin" class="money" value="<?php echo $valorFin ?>" required>
                                                <font color=red> **</font>
                                            </p>
                                            <p class="Historico">
                                                <label for="razao">
                                                    <font color=red>Histórico</font>
                                                </label>
                                                <input class="span11" name="razaoSoc" type="text" value="<?php echo $razaoSoc ?>" maxlength=45>
                                                <font color=red> *</font>

                                            </p>
                                            <p class="descri">
                                                <label for="descri">Descrição</label>
                                                <textarea name="descri" type="text" maxlength=100><?php echo $descri ?></textarea>
                                                <font color=red> *</font>
                                            </p>
                                        </div>
                                        <p class="Senha">
                                            <label for="senhaAdm">
                                                <font color=red>Senha Admnistrador</font>
                                            </label>
                                            <input name="senhaAdm" type="text" value="">
                                            <font color=red> *</font>
                                        </p>
                                    </div>
                                    <div class="span12">
                                        <div id="outro">
                                            <?php
                                            if ($presentes == "true") {
                                                //****** ENTRADA DE presentes especiais
                                                if ($tipoES == (1)) {
                                                    //   var_dump($_SESSION['textoSomatorioItens']);
                                                    //  $qtd_presentes = $_POST["qtd_presentes"];
                                            ?>
                                                    <input name="qtd_presentes" type="hidden" value="<?php echo $qtd_presentes ?>" />


                                                    <input type="radio" name="v_Valores" id="v_Valores" value="1" checked="checked" />
                                                    <font color=#458B74>- Verificar</font>
                                                    <input type="radio" name="v_Valores" id="v_Valores" value="0" />
                                                    <font color=#458B74>- verificar e Cadastrar</font>
                                        </div>
                                        <br>
                                        <?php
                                                    if ($conta == 4) {
                                        ?>
                                            <p>
                                                <label>
                                                    <font color=red>A lista contém Beneficiários do BR214 e Anexo</font>
                                                </label>
                                            </p>
                                        <?php } ?>
                                        <table>
                                            <th font color="#458B74">Beneficiário | Código BR</th>
                                            <th font color=red>Protocólo</th>
                                            <th font color=red>Valor R$</th>
                                            <th font color=red>E / S</th>

                                            <?php
                                                    if ($_SESSION['Codigo1'] == null) {
                                                        for ($contar = 1; $contar <= $qtd_presentes; $contar++) {
                                            ?>
                                                    <tr>
                                                        <td width="50%">
                                                            <?php $Codigo = 'Codigo' . $contar ?>
                                                            <select class="span12" id="<?php echo $Codigo ?>" name="<?php echo $Codigo ?>">
                                                                <option value="0"> Selecione...</option>
                                                                <?php
                                                                foreach ($resultss_Benefic as $rBnf) {
                                                                    if ($conta != 4) {
                                                                        if ($rBnf->telefone  == $conta) { ?>
                                                                            <option value="<?php echo $rBnf->idClientes ?>"><?php echo $rBnf->nomeCliente . " | " . $rBnf->documento ?></option>
                                                                        <?php
                                                                        }
                                                                    } else {
                                                                        if ($rBnf->telefone  == 4 || $rBnf->telefone  == 5) { ?>
                                                                            <option value="<?php echo $rBnf->idClientes ?>"><?php echo $rBnf->nomeCliente . " | " . $rBnf->documento ?></option>
                                                                <?php
                                                                        }
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <?php $Protocolo = 'Protocolo' . $contar ?>
                                                            <input iid="Protocolo" name="<?php echo $Protocolo ?>" placeholder="<?php echo $Protocolo ?>" />
                                                        </td>
                                                        <td>
                                                            <?php $valorPre = 'valorPre' . $contar ?>
                                                            <input name="<?php echo $valorPre ?>" class="money" placeholder="<?php echo $valorPre ?>" />
                                                        </td>
                                                        <td>
                                                            <?php $entraSai = 'entraSai' . $contar ?>
                                                            <select class="span12" id="<?php echo $entraSai ?>" name="<?php echo $entraSai ?>">
                                                                <option value="1"> Entrada</option>
                                                                <option value="0"> Saída</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                <?php
                                                            if ($contar == 100) exit;
                                                        }
                                                    } else {
                                                        for ($contar = 1; $contar <= $qtd_presentes; $contar++) {

                                                            $Codigo = 'Codigo' . $contar;
                                                            foreach ($resultss_Benefic as $rBnf) {
                                                                if ($rBnf->idClientes  == $_SESSION[$Codigo])
                                                                    $nomeBR = $rBnf->nomeCliente . " | " . $rBnf->documento;
                                                            }
                                                ?>
                                                    <tr>
                                                        <td width="50%">
                                                            <select class="span12" id="<?php echo $Codigo ?>" name="<?php echo $Codigo ?>">
                                                                <option value="<?php echo $_SESSION[$Codigo] ?>"><?php echo $nomeBR ?></option>
                                                                <?php
                                                                foreach ($resultss_Benefic as $rBnf) {
                                                                    if ($conta != 4) {
                                                                        if ($rBnf->telefone  == $conta) { ?>
                                                                            <option value="<?php echo $rBnf->idClientes ?>"><?php echo $rBnf->nomeCliente . " | " . $rBnf->documento ?></option>
                                                                        <?php
                                                                        }
                                                                    } else {
                                                                        if ($rBnf->telefone  == 4 || $rBnf->telefone  == 5) { ?>
                                                                            <option value="<?php echo $rBnf->idClientes ?>"><?php echo $rBnf->nomeCliente . " | " . $rBnf->documento ?></option>
                                                                <?php
                                                                        }
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <?php $Protocolo = 'Protocolo' . $contar ?>
                                                            <input id="Protocolo" name="<?php echo $Protocolo ?>" value="<?php echo $_SESSION[$Protocolo] ?>" />
                                                        </td>
                                                        <td>
                                                            <?php $valorPre = 'valorPre' . $contar ?>
                                                            * R$ <input id="<?php echo $valorPre ?>"  name="<?php echo $valorPre ?>" class="money" value="<?php echo $_SESSION[$valorPre] ?>" />
                                                        </td>
                                                        <td>
                                                            <?php $entraSai = 'entraSai' . $contar ?>
                                                            <select class="span12" id="<?php echo $entraSai ?>" name="<?php echo $entraSai ?>">
                                                                <?php if (isset($_SESSION[$entraSai])) {
                                                                    $entraS = $_SESSION[$entraSai];
                                                                    $n_ES = "Entrada";
                                                                    if ($entraS == "0") $n_ES = "Saída"; ?>
                                                                    <option value="<?php echo $entraS ?>"> <?php echo $n_ES; ?></option>
                                                                <?php  } ?>
                                                                <option value="1"> Entrada</option>
                                                                <option value="0"> Saída</option>
                                                            </select>
                                                        </td>
                                                    </tr>


                                            <?php
                                                            if ($contar == 100) exit;
                                                        }
                                                    }
                                            ?>

                                            <tr>
                                                <td></td>
                                                <td>VALOR TOTAL S</td>
                                                <td>
                                                    <span class="style1">* R$ </span>
                                                    <input id="valtotal"  name="valtotal" readonly><br>
                                                </td>
                                            </tr>
                                        </table>
                                        <?php
                                                    $textoSomatorioItens = isset($_SESSION['textoSomatorioItens']) ? $_SESSION['textoSomatorioItens'] : 'NADA';
                                                    $textoSomatorio =  NULL !== ($_SESSION['textoSomatorio']) ? $_SESSION['textoSomatorio'] : 'NADA';
                                                    if ($textoSomatorio != '') {
                                        ?>

                                            <div class="span3"><?php echo $textoSomatorioItens; ?> </div>
                                            <div class="span7"><?php echo $textoSomatorio; ?></div>

                                <?php
                                                    }
                                                } else
                                                    //****** sAÍDA DE presentes especiais
                                                    if ($tipoES == (0)) {
                                                        // if($nivel < 4)
                                                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vProduto')) {

                                                            if (empty($pre)) {
                                                                echo "<center><font color = red >Nao existem registros de presentes especiais!</font>";
                                                            }

                                                            echo '<table border=1 bgcolor="LightGray" width="70%">';
                                                            echo '<thead bgcolor="#BDBDBD"><tr><th colspan="8" bgcolor="white" align="center" >Presentes especiais em aberto conta ' . $contaNome . ' </th>  </tr>';

                                                            // echo '<th> </th>';	
                                                            echo '<th>Nº</th>';
                                                            echo '<th>Conta</th>';
                                                            echo '<th>BR</th>';
                                                            echo '<th>Nome Beneficiário</th>';
                                                            echo '<th>Protocolo</th>';
                                                            echo '<th>Data</th>';
                                                            echo '<th>Total R$</th>';
                                                            echo '<th>Valor pendente R$</th>';
                                                            echo '</tr></thead>';
                                                            echo '<tbody style="font-size:80%">';
                                                            $total = 0;
                                                            $inicio = 1;
                                                            //	while ($rows_presentes = mysqli_fetch_assoc($presentes_abertos)) 
                                                            $contaY = "a";
                                                            $data_3Mes = date('Y-m-d', strtotime("-90 day", strtotime(date('Y-m-d'))));
                                                            $data_6Mes = date('Y-m-d', strtotime("-180 day", strtotime(date('Y-m-d'))));
                                                            $data_anoAtual = date('Y-m-d', strtotime(date('Y-01-01')));

                                                            foreach ($pre as $rpres) {
                                                                if ((($rpres->dataFin > $data_6Mes) || ($rpres->dataFin > $data_anoAtual)) && (($rpres->valor_pendente > 3 && $rpres->dataFin >= $data_3Mes)) && $rpres->projeto == $contaPres) {

                                                                    $contaN = $conta != 99 ? $this->session->userdata('conta' . $conta . '_nome') . ' XX' : "Todas contas";

                                                                    $data_Ch = implode('/', array_reverse(explode('-', $rpres->dataFin)));
                                                                    $val_Ch = number_format($rpres->valor_entrada, 2, ',', '.');
                                                                    $valor_pendente = number_format($rpres->valor_pendente, 2, ',', '.');

                                                                    if ($contaY == $contaN) { //id_presente, id_entrada, id_saida, data_presente, n_beneficiario, nome_beneficiario, n_protocolo
                                                                        if ($val_Ch <> $valor_pendente) {
                                                                            echo '<tr bgcolor="Yellow">';
                                                                            $presente_pendente = "true";
                                                                        } else     echo '<tr bgcolor="#CEF6D8">';

                                                                        echo '<td><label  class="btn btn-default" submit>' . $rpres->id_presente . '<input  name="id_presentes" type="radio" value= "' . $rpres->id_presente . '"  class="badgebox" style="margin-top:15px;" ><span class="badge" >&check;</span></label></td> ';

                                                                        echo '<td>' . $contaN . '</td>';
                                                                        echo '<td>' . $rpres->n_beneficiario . ' </td> <td>XXXA  ' . $rpres->nome_beneficiario . '</td>';
                                                                        echo '<td>' . $rpres->n_protocolo . '</td> <td align="right" valign=bottom >' . $data_Ch . '</td> ';
                                                                        echo '<td align="right" valign=bottom >' . $val_Ch . '</td>';
                                                                        echo '<td align="right" valign=bottom >' . $valor_pendente . '</td></tr>';
                                                                        $total = $total + $rpres->valor_pendente;
                                                                    } else {
                                                                        if ($inicio == 0) {
                                                                            $val_ChT = number_format($total, 2, ',', '.');
                                                                            echo '<tr  bgcolor="#CEF6D8">';

                                                                            echo '<td></td> <td></td> <td></td> <td></td> <td></td> <td colspan="2">Total a compensar R$ </td>';
                                                                            echo '<td bgcolor="green"  ><h4 align="right" valign=bottom >', $val_ChT . '</h4></td></tr>';

                                                                            if ($val_Ch <> $valor_pendente) {
                                                                                echo '<tr bgcolor="Yellow">';
                                                                                $presente_pendente = "true";
                                                                            } else     echo '<tr bgcolor="#CEF6D8">';


                                                                            echo '<td><label  class="btn btn-default" submit>' . $rpres->id_presente . '<input  name="id_presentes" type="radio" value= "' . $rpres->id_presente . '"  class="badgebox" style="margin-top:15px;" ><span class="badge" >&check;</span></label></td> ';

                                                                            echo '<td>' . $contaN . '</td>';
                                                                            echo '<td>' . $rpres->n_beneficiario . '</td> <td>XXXA  ' . $rpres->nome_beneficiario . '</td>';
                                                                            echo '<td>' . $rpres->n_protocolo . '</td> <td align="right" valign=bottom >' . $data_Ch . '</td> ';
                                                                            echo '<td align="right" valign=bottom >' . $val_Ch . '</td>';
                                                                            echo '<td align="right" valign=bottom >' . $valor_pendente . '</td></tr>';
                                                                            $total = $total + $rpres->valor_pendente;
                                                                        } else {
                                                                            echo '<tr  bgcolor="#CEF6D8">';

                                                                            echo '<td><label  class="btn btn-default" submit>' . $rpres->id_presente . '<input  name="id_presentes" type="radio" value= "' . $rpres->id_presente . '"  class="badgebox" style="margin-top:15px;" ><span class="badge" >&check;</span></label></td> ';

                                                                            echo '<td>' . $contaN . '</td>';
                                                                            echo '<td>' . $rpres->n_beneficiario . '</td> <td>XXXA  ' . $rpres->nome_beneficiario . '</td>';
                                                                            echo '<td>' . $rpres->n_protocolo . '</td> <td align="right" valign=bottom >' . $data_Ch . '</td> ';
                                                                            echo '<td align="right" valign=bottom >' . $val_Ch . '</td>';
                                                                            echo '<td align="right" valign=bottom >' . $valor_pendente . '</td></tr>';
                                                                            $total = $total + $rpres->valor_pendente;
                                                                            $inicio = 0;
                                                                        }
                                                                    }
                                                                    $inicio = 0;
                                                                    $contaY = $contaN;
                                                                }
                                                            }
                                                            $val_Ch = number_format($total, 2, ',', '.');
                                                            echo '<td></td> <td></td> <td></td>  <td></td> <td></td> <td colspan="2">Total a compensar R$ </td>';
                                                            echo '<td bgcolor="Yellow"  ><h4 align="right" valign=bottom >', $val_Ch . '</h4></td></tr>';
                                                            echo '</tbody></table>'; //caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
                                                        }
                                                    }
                                            }

                                            if (isset($presente_pendente))
                                                if ($presente_pendente == "true")
                                                    echo '* As linhas em amarelo são referentes a presentes com parte do valor ja lançado!';
                                ?>
                                    </div>

                                    <?php
                                } else {

                                    //******* Se o lançamento esta iniciando                  

                                    if ($multiLance == '1') {

                                        $qtd_Mult = $_POST['qtd_Multi'];
                                    ?>
                                        <div class="widget-content nopadding">


                                            <table class="table table-bordered ">
                                                <thead>
                                                    <tr style="backgroud-color: #2D335B">
                                                        <th>Códigos</th>
                                                        <th>Documentos</th>
                                                        <th>Data/Valor</th>
                                                        <th>Descrições</th>
                                                        <th>Forma</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    for ($cont = 0; $cont <= $qtd_Mult; $cont++) { ?>
                                                        <tr>
                                                            <td>
                                                                <select id="cod_Comp" name="cod_Comp">
                                                                    <option value="">Opção financeira Compassion</option>
                                                                    <?php
                                                                    if ($tipoES == 0) {
                                                                        foreach ($result_codComp as $rcodComp) {
                                                                            if ($rcodComp->ent_SaiComp == 0 && $rcodComp->codigoNovo == 1) { ?>
                                                                                <option value="<?php echo $rcodComp->cod_Comp ?>">
                                                                                    <?php echo ' ' . $rcodComp->cod_Comp . " | " . $rcodComp->descricao . " | " . $rcodComp->area_Cod . ' ' ?></option>
                                                                            <?php } else {
                                                                            }
                                                                        }
                                                                    } else 
                                                                    if ($tipoES == 1) {
                                                                        foreach ($result_codComp as $rcodComp) {
                                                                            if ($rcodComp->ent_SaiComp == 1 && $rcodComp->codigoNovo == 1) {
                                                                            ?>
                                                                                <option value="<?php echo $rcodComp->cod_Comp ?>">
                                                                                    <?php echo ' ' . $rcodComp->cod_Comp . " | " . $rcodComp->descricao . " | " . $rcodComp->area_Cod . ' ' ?></option>
                                                                    <?php
                                                                            } else {
                                                                            }
                                                                        }
                                                                    } ?>
                                                                </select>
                                                                <select id="cod_Ass" name="cod_Ass">
                                                                    <option value="">Oopção financeira IEADALPE</option>
                                                                    <?php

                                                                    if ($tipoES == 0) {
                                                                        foreach ($result_codIead as $rcodIead) {
                                                                            if ($rcodIead->ent_SaiAss == 0) { ?>
                                                                                <option value="<?php echo $rcodIead->cod_Ass ?>">
                                                                                    <?php echo $rcodIead->cod_Ass . " | " . $rcodIead->descricao_Ass ?></option>
                                                                            <?php } else {
                                                                            }
                                                                        }
                                                                    } else 
                                                                    if ($tipoES == 1) {
                                                                        foreach ($result_codIead as $rcodIead) {
                                                                            if ($rcodIead->ent_SaiAss == 1) {
                                                                            ?>
                                                                                <option value="<?php echo $rcodIead->cod_Ass ?>">
                                                                                    <?php echo '  ' . $rcodIead->cod_Ass . " | " . $rcodIead->descricao_Ass ?></option>
                                                                    <?php } else {
                                                                            }
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input id="numeroDoc" name="numeroDoc" placeholder="Nº Bancário" />
                                                                <input id="numDocFiscal" name="numDocFiscal" placeholder="(NF ou CF)- Nº Fiscal" />
                                                            </td>
                                                            <td>
                                                                <input id="dataVenda" class="span12 datepicker" type="Text" name="dataVenda" value="<?php echo date('d/m/Y'); ?>" /><br />
                                                                <input text-align="right" name="valorFin" class="money">
                                                            </td>
                                                            <td><input name="razaoSoc" type="text" placeholder="Nome da Razão Social." required maxlength=45 onChange="javascript:this.value=this.value.toUpperCase();">
                                                                <textarea name="descri" id="descri" type="text" placeholder="- descrição." maxlength=100></textarea>
                                                            </td>
                                                            <td><input name="tipoPag" type="radio" value="trans" CHECKED>Transferência
                                                                <input name="tipoPag" id="rd-time" type="radio" value="cheq" style="margin-top:15px;">Cheque
                                                            </td>


                                                        </tr>
                                                        <tr>
                                                            <td colspan="9"></td>

                                                        </tr>
                                                    <?php
                                                    } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php } else { ?>
                                        <div class="span6">

                                            <?php
                                            if ($presentes == "true") {
                                                if ($tipoES == 0) { ?>
                                                    <p class="cod_Comp" class="span12">
                                                        <label for="compassion">Código Compassion *</label>
                                                        <select id="cod_Comp" name="cod_Comp" class="span12">

                                                            <option value="D07 - 0730">
                                                                D07 - 0730 | Presentes - Beneficiário/Família /Projeto | FUNDOS ESPECIAIS COMPASSION</option>

                                                        </select>
                                                    </p>
                                                    <p class="cod_ass">
                                                        <label for="cod_ass">Código IEADALPE *</label>
                                                        <select id="cod_Ass" name="cod_Ass" class="span12">
                                                            <option value="D06-010">
                                                                D06-010 | PRESENTES ESPECIAIS (Compassion)</option>
                                                        </select>
                                                    </p>
                                                <?php
                                                } else if ($tipoES == 1) {  ?>
                                                    <p class="cod_Comp">
                                                        <label for="compassion">Código Compassion *</label>
                                                        <select id="cod_Comp" name="cod_Comp" class="span12">
                                                            <option value="R01 - 1030">
                                                                R01 - 1030 | Presentes - Beneficiário/Família /Projeto | FUNDOS ESPECIAIS COMPASSION</option>
                                                        </select>
                                                    </p>
                                                    <p class="cod_ass">
                                                        <label for="cod_ass">Código IEADALPE *</label>
                                                        <select id="cod_Ass" name="cod_Ass" class="span12">
                                                            <option value="R01">
                                                                R01 | DOAÇÕES COMPASSION </option>
                                                        </select>
                                                    </p>
                                                <?php

                                                }
                                            } else {
                                                if ($conta <  4 || $conta >  8) {
                                                    echo '<input id="cod_Comp" name="cod_Comp"  type=hidden value=III-III />';
                                                } else {
                                                    //  $query = mysqli_query($conex, "SELECT * FROM cod_compassion WHere  ent_Sai = 0 ");
                                                ?>
                                                    <p class="cod_Comp">
                                                        <label for="compassion">Código Compassion *</label>
                                                        <select id="cod_Comp" name="cod_Comp">
                                                            <option value="">Opção financeira Compassion</option>
                                                            <?php
                                                            if ($tipoES == 0) {
                                                                foreach ($result_codComp as $rcodComp) {
                                                                    if ($rcodComp->ent_SaiComp == 0 && $rcodComp->codigoNovo == 1) { ?>
                                                                        <option value="<?php echo $rcodComp->cod_Comp ?>">
                                                                            <?php echo ' ' . $rcodComp->cod_Comp . " |
                                                " . $rcodComp->descricao . " | " . $rcodComp->area_Cod . ' ' ?></option>
                                                                    <?php } else {
                                                                    }
                                                                }
                                                            } else 
                                          if ($tipoES == 1) {
                                                                foreach ($result_codComp as $rcodComp) {
                                                                    if ($rcodComp->ent_SaiComp == 1 && $rcodComp->codigoNovo == 1) {
                                                                    ?>
                                                                        <option value="<?php echo $rcodComp->cod_Comp ?>">
                                                                            <?php echo ' ' . $rcodComp->cod_Comp . " |
                                                    " . $rcodComp->descricao . " | " . $rcodComp->area_Cod . ' ' ?></option>
                                                            <?php } else {
                                                                    }
                                                                }
                                                            } ?>
                                                        </select>
                                                    </p>
                                                <?php }    ?>
                                                <p class="cod_ass">

                                                    <label for="cod_ass">Código IEADALPE *</label>
                                                    <select id="cod_Ass" name="cod_Ass">
                                                        <option value="">Oopção financeira IEADALPE</option>
                                                        <?php

                                                        if ($tipoES == 0) {
                                                            foreach ($result_codIead as $rcodIead) {
                                                                if ($rcodIead->ent_SaiAss == 0) { ?>
                                                                    <option value="<?php echo $rcodIead->cod_Ass ?>">
                                                                        <?php echo $rcodIead->cod_Ass . " | " . $rcodIead->descricao_Ass ?></option>
                                                                <?php } else {
                                                                }
                                                            }
                                                        } else 
                                                        if ($tipoES == 1) {
                                                            foreach ($result_codIead as $rcodIead) {
                                                                if ($rcodIead->ent_SaiAss == 1) {
                                                                ?>
                                                                    <option value="<?php echo $rcodIead->cod_Ass ?>">
                                                                        <?php echo '  ' . $rcodIead->cod_Ass . " | " . $rcodIead->descricao_Ass ?></option>
                                                        <?php } else {
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </p>

                                            <?php }
                                            ?>
                                            <p class="numeroDocBancario">
                                                <?php
                                                if ($conta <> 3) { ?>
                                                    <label for="numeroDocBanco">Número do Documento Bancário</label>
                                                    <input id="numeroDoc" name="numeroDoc" placeholder="Nº Bancário" />
                                                <?php }
                                                ?>
                                                <span class="style1">*</span>
                                            </p>
                                            <p class="docFiscal">
                                                <label for="numeroDocFiscal">Número do Documento Fiscal</label>
                                                <td>
                                                    <input id="numDocFiscal" name="numDocFiscal" placeholder="(NF ou CF)- Nº Fiscal" />
                                                    <font color=red> *</font>
                                                </td>
                                            </p>

                                            <p class="conta" class="span6">
                                                <label for="dataInicial">Data do evento financeiro<span class="required">*</span></label>
                                                <input id="dataVenda" class="span6 datepicker" type="Text" name="dataVenda" value="<?php echo date('d/m/Y'); ?>" />
                                            </p>
                                            <p class="conta">
                                                <label for="conta">à beneficio da conta</label>
                                                <select id="conta_Destino" name="conta_Destino">
                                                    <option value="<?php echo $conta ?>"><?php echo $conta . ' | ' . $contaNome; ?></option>
                                                    <?php
                                                    foreach ($result_caixas as $rcx) {
                                                        if ($usuario->conta_Usuario == 99)
                                                            if (($conta < 4) || ($conta > 8)) {
                                                                if ($rcx->id_caixa != 5) { ?>
                                                                <option value="<?php echo $rcx->id_caixa ?>"><?php echo $rcx->id_caixa . " | " . $rcx->nome_caixa ?></option>
                                                    <?php
                                                                }
                                                            }
                                                    }
                                                    ?>
                                                </select>
                                                <font color=red><span class="style1"> * </span></font>
                                            </p>



                                        </div>

                                        <div class="span5">
                                            <?php
                                            if ($tipCont == "Corrente") { ?>
                                                <script type="text/javascript">
                                                    function id(el) {
                                                        return document.getElementById(el);
                                                    }

                                                    function mostra(el) {
                                                        id(el).style.display = 'block';
                                                    }

                                                    function esconde_todos(el, tagName) {
                                                        var tags = el.getElementsByTagName(tagName);
                                                        for (var i = 0; i < tags.length; i++) {
                                                            tags[i].style.display = 'none';
                                                        }
                                                    }
                                                    window.onload = function() {
                                                        id('cheq').style.display = 'none';
                                                        id('rd-time').onchange = function() {
                                                            esconde_todos(id('palco'), 'div');
                                                            mostra(this.value);
                                                        }
                                                        var radios = document.getElementsByTagName('input');
                                                        for (var i = 0; i < radios.length; i++) {
                                                            if (radios[i].type == 'radio') {
                                                                radios[i].onclick = function() {
                                                                    esconde_todos(id('palco'), 'div');
                                                                    mostra(this.value);
                                                                }
                                                            }
                                                        }
                                                    }
                                                </script>



                                                <label for="tiposaida">Forma de saida</label>
                                                <input name="tipoPag" type="radio" value="trans" CHECKED>Transferência
                                                <input name="tipoPag" id="rd-time" type="radio" value="cheq" style="margin-top:15px;">Cheque

                                                <div id="palco">
                                                    <div id="cheq">

                                                        <label for="tiposaida"><input name="chequeCompen" type="checkbox" value="0">Cheque já compensado</label>

                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            ?>

                                            <div id="blAux6">
                                                <p class="VALOR">
                                                    <label for="valor">Valor do lançamento 1106</label>
                                                    <span class="style1">* R$ </span><input text-align="right" id="valorFin" name="valorFin" class="money" required>
                                                    <font color=red> **</font>
                                                </p>
                                                <p class="Historico">
                                                    <label for="raz">
                                                        <font color=red>Histórico</font>
                                                    </label>
                                                    <input class="span11" name="razaoSoc" type="text" placeholder="Nome da Razão Social." maxlength=60>
                                                    <font color=red> *</font>

                                                </p>
                                                <p class="descri">
                                                    <label for="descri">Descrição</label>
                                                    <textarea name="descri" id="descri" type="text" placeholder="- descrição." maxlength=100></textarea>
                                                    <font color=red> *</font>
                                                </p>
                                            </div>

                                            <p class="senhaAdm">
                                                <input style="background: transparent; border: none;" name="raz" type="hidden">
                                                <label for="senhaAd">
                                                    <font color=red>senha Administrador</font>
                                                </label>
                                                <input name="senhaAdm" type="text" value="" maxlength=50>
                                                <font color=red> *</font>
                                            </p>
                                        </div>
                                        <input type="text" id="id_form" name="fin_id" value="" />

                                    <?php } ?>


                                    <div class="span12">
                                        <div id="outro">
                                            <?php
                                            if ($presentes == "true") { //var_dump($_POST["tipCont"]);
                                                //****** ENTRADA DE presentes especiais
                                                if ($tipoES == 1 && $_POST["tipCont"] == 'Corrente') {
                                                    $qtd_presentes = $_POST["qtd_presentes"];
                                            ?>
                                                    <input name="qtd_presentes" type="hidden" value="<?php echo $qtd_presentes ?>" />


                                                    <input type="radio" name="v_Valores" id="v_Valores" value="1" checked="checked" />
                                                    <font color=#458B74>- Verificar</font>
                                                    <input type="radio" name="v_Valores" id="v_Valores" value="0" />
                                                    <font color=#458B74>- verificar e Cadastrar</font>
                                        </div>
                                        <br>
                                        <?php
                                                    if ($conta == 4) {
                                        ?>
                                            <p>
                                                <label>
                                                    <font color=red>A lista contém Beneficiários do BR214 e Anexo</font>
                                                </label>
                                            </p>
                                        <?php } ?>
                                        <table>
                                            <tr>
                                                <th font color="#458B74">Beneficiário | Código BR</th>
                                                <th font color=red>Protocólo</th>
                                                <th font color=red>Valor R$</th>
                                                <th font color=red>E / S</th>
                                            </tr>
                                            <?php
                                                    //                               var_dump($qtd_presentes);

                                                    for ($contar = 1; $contar <= $qtd_presentes; $contar++) {
                                            ?>
                                                <tr>
                                                    <td width="50%">

                                                        <?php $Codigo = 'Codigo' . $contar ?>
                                                        <select class="span12" id="<?php echo $Codigo ?>" name="<?php echo $Codigo ?>">
                                                            <option value="0"> Selecione...</option>
                                                            <?php
                                                            foreach ($resultss_Benefic as $rBnf) {
                                                                if ($conta != 4) {
                                                                    if ($rBnf->telefone  == $conta) { ?>
                                                                        <option value="<?php echo $rBnf->idClientes ?>"><?php echo $rBnf->nomeCliente . " | " . $rBnf->documento ?></option>
                                                                    <?php
                                                                    }
                                                                } else {
                                                                    if ($rBnf->telefone  == 4 || $rBnf->telefone  == 5) { ?>
                                                                        <option value="<?php echo $rBnf->idClientes ?>"><?php echo $rBnf->nomeCliente . " | " . $rBnf->documento ?></option>
                                                            <?php
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <?php $Protocolo = 'Protocolo' . $contar ?>
                                                        <input id="Protocolo" name="<?php echo $Protocolo ?>" placeholder="<?php echo $Protocolo ?>" />
                                                    </td>
                                                    <td>
                                                        <?php $valorPre = 'valorPre' . $contar ?>
                                                        <input id="<?php echo $valorPre ?>" name="<?php echo $valorPre ?>" class="money" placeholder="<?php echo $valorPre ?>" />
                                                    </td>
                                                    <td>
                                                        <?php $entraSai = 'entraSai' . $contar ?>
                                                        <select class="span12" id="<?php echo $entraSai ?>" name="<?php echo $entraSai; ?>">
                                                            <option value="1"> Entrada</option>
                                                            <option value="0"> Saída</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            <?php
                                                        if ($contar == 100) exit;
                                                    }

                                            ?>

                                            <tr>
                                                <td></td>
                                                <td>VALOR TOTAL C</td>
                                                <td>
                                                    <span class="style1">* R$ </span>
                                                    <input id="valtotal"  name="valtotal" readonly=""><br>
                                                </td>
                                            </tr>
                                        </table>
                                <?php
                                                } else
                                                    //****** sAÍDA DE presentes especiais
                                                    if ($tipoES == (0)) {
                                                        // if($nivel < 4)
                                                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vProduto')) {

                                                            // require_once 'conexao.class.php';		
                                                            // $con = new Conexao();		 
                                                            // $con->connect(); $conex = $_SESSION['conex']; 
                                                            // //id_presente, id_entrada, id_saida, data_presente, n_beneficiario, nome_beneficiario, n_protocolo
                                                            // $sql = 'SELECT * FROM presentes_especiais, aenpfin
                                                            // WHERE id_fin = id_entrada and  id_saida like 0 and  conta like '.$conta.' ORDER BY dataFin';
                                                            // $presentes_abertos = mysqli_query($conex, $sql);

                                                            if (empty($pre)) {
                                                                echo "<center><font color = red >Nao existem registros de presentes especiais!</font>";
                                                            }
                                                            echo '<table border=1 bgcolor="LightGray" width="70%">';
                                                            echo '<thead bgcolor="#BDBDBD"><tr><th colspan="8" bgcolor="white" align="center" >Presentes especiais em aberto conta ' . $contaNome . ' </th>  </tr>';

                                                            // echo '<th> </th>';	
                                                            echo '<th>Nº</th>';
                                                            echo '<th>Conta</th>';
                                                            echo '<th>BR</th>';
                                                            echo '<th>Nome Beneficiário</th>';
                                                            echo '<th>Protocolo</th>';
                                                            echo '<th>Data</th>';
                                                            echo '<th>Total R$</th>';
                                                            echo '<th>Valor pendente R$</th>';
                                                            echo '</tr></thead>';
                                                            echo '<tbody style="font-size:80%">';
                                                            $total = 0;
                                                            $inicio = 1;
                                                            $contaY = "a";
                                                            $data_3Mes = date('Y-m-d', strtotime("-90 day", strtotime(date('Y-m-d'))));
                                                            $data_6Mes = date('Y-m-d', strtotime("-180 day", strtotime(date('Y-m-d'))));
                                                            $data_anoAtual = date('Y-m-d', strtotime(date('Y-01-01')));
                                                            foreach ($pre as $rpres) {
                                                                $contaPres = $rpres->conta == 4 && $conta == 5 ? 5 : $rpres->conta;

                                                                $contaBen = $contaN = $conta != 99 ? $this->session->userdata('conta' . $conta . '_nome') : "Todas contas";
                                                                //  switch ($contaPres) 
                                                                //     {
                                                                //         case 1:	$contaN = "IEADALPE - 1444-3";  $contaBen = "IEADALPE - 1444-3"; break;    
                                                                //         case 2:	$contaN = "22360-3";            $contaBen = "22360-3"; break;  
                                                                //         case 3:	$contaN = "ILPI";               $contaBen = "ILPI"; break;  
                                                                //         case 4:	$contaN = "BR214";              $contaBen = "BR0214"; break;  
                                                                //         case 5:	$contaN = "BR518";              $contaBen = "BR0518"; break;  
                                                                //         case 6:	$contaN = "BR542";              $contaBen = "BR0542"; break;  
                                                                //         case 7:	$contaN = "BR549";              $contaBen = "BR0549"; break;  
                                                                //         case 8:	$contaN = "BR579";              $contaBen = "BR0579"; break;  
                                                                //         case 9:	$contaN = "BB 28965-5"; 	    $contaBen = "BB 28965-5"; break;  
                                                                //         case 10:$contaN = "CEF 1948-4";         $contaBen = "CEF 1948-4"; break;
                                                                //         case 99:$contaN = "Todas contas";       $contaBen = "Todas contas"; break;  				
                                                                //     }		

                                                                if ((($rpres->dataFin > $data_6Mes) || ($rpres->dataFin > $data_anoAtual)) && (($rpres->valor_pendente > 3 && $rpres->dataFin >= $data_3Mes)) && $rpres->projeto == $contaPres) {
                                                                    $data_Ch = implode('/', array_reverse(explode('-', $rpres->dataFin)));
                                                                    $val_Ch = number_format($rpres->valor_entrada, 2, ',', '.');
                                                                    $valor_pendente = number_format($rpres->valor_pendente, 2, ',', '.');

                                                                    if ($contaY == $contaN) { //id_presente, id_entrada, id_saida, data_presente, n_beneficiario, nome_beneficiario, n_protocolo
                                                                        if ($val_Ch <> $valor_pendente) {
                                                                            echo '<tr bgcolor="Yellow">';
                                                                            $presente_pendente = "true";
                                                                        } else     echo '<tr bgcolor="#CEF6D8">';

                                                                        echo '<td><label  class="btn btn-default" submit>' . $rpres->id_presente . '<input  name="id_presentes" type="radio" value= "' . $rpres->id_presente . '"  class="badgebox" style="margin-top:15px;" ><span class="badge" >&check;</span></label></td> ';

                                                                        echo '<td>' . $contaN . '</td>';
                                                                        echo '<td>' . $rpres->n_beneficiario . '</td> <td>' . $rpres->nome_beneficiario . '</td>';
                                                                        echo '<td>' . $rpres->n_protocolo . '</td> <td align="right" valign=bottom >' . $data_Ch . '</td> ';
                                                                        echo '<td align="right" valign=bottom >' . $val_Ch . '</td>';
                                                                        echo '<td align="right" valign=bottom >' . $valor_pendente . '</td></tr>';
                                                                        $total = $total + $rpres->valor_pendente;
                                                                    } else {
                                                                        if ($inicio == 0) {
                                                                            $val_ChT = number_format($total, 2, ',', '.');
                                                                            echo '<tr  bgcolor="#CEF6D8">';

                                                                            echo '<td></td> <td></td> <td></td> <td></td> <td></td> <td colspan="2">Total a compensar R$ </td>';
                                                                            echo '<td bgcolor="green"  ><h4 align="right" valign=bottom >', $val_ChT . '</h4></td></tr>';

                                                                            if ($val_Ch <> $valor_pendente) {
                                                                                echo '<tr bgcolor="Yellow">';
                                                                                $presente_pendente = "true";
                                                                            } else     echo '<tr bgcolor="#CEF6D8">';


                                                                            echo '<td><label  class="btn btn-default" submit>' . $rpres->id_presente . '<input  name="id_presentes" type="radio" value= "' . $rpres->id_presente . '"  class="badgebox" style="margin-top:15px;" ><span class="badge" >&check;</span></label></td> ';

                                                                            echo '<td>' . $contaN . '</td>';
                                                                            echo '<td>' . $rpres->n_beneficiario . '</td> <td>' . $rpres->nome_beneficiario . '</td>';
                                                                            echo '<td>' . $rpres->n_protocolo . '</td> <td align="right" valign=bottom >' . $data_Ch . '</td> ';
                                                                            echo '<td align="right" valign=bottom >' . $val_Ch . '</td>';
                                                                            echo '<td align="right" valign=bottom >' . $valor_pendente . '</td></tr>';
                                                                            $total = $total + $rpres->valor_pendente;
                                                                        } else {
                                                                            echo '<tr  bgcolor="#CEF6D8">';

                                                                            echo '<td><label  class="btn btn-default" submit>' . $rpres->id_presente . '<input  name="id_presentes" type="radio" value= "' . $rpres->id_presente . '"  class="badgebox" style="margin-top:15px;" ><span class="badge" >&check;</span></label></td> ';

                                                                            echo '<td>' . $contaN . '</td>';
                                                                            echo '<td>' . $rpres->n_beneficiario . '</td> <td>' . $rpres->nome_beneficiario . '</td>';
                                                                            echo '<td>' . $rpres->n_protocolo . '</td> <td align="right" valign=bottom >' . $data_Ch . '</td> ';
                                                                            echo '<td align="right" valign=bottom >' . $val_Ch . '</td>';
                                                                            echo '<td align="right" valign=bottom >' . $valor_pendente . '</td></tr>';
                                                                            $total = $total + $rpres->valor_pendente;
                                                                            $inicio = 0;
                                                                        }
                                                                    }
                                                                    $inicio = 0;
                                                                    $contaY = $contaN;
                                                                }
                                                            }
                                                            $val_Ch = number_format($total, 2, ',', '.');
                                                            echo '<td></td> <td></td> <td></td>  <td></td> <td></td> <td colspan="2">Total a compensar R$ </td>';
                                                            echo '<td bgcolor="Yellow"  ><h4 align="right" valign=bottom >', $val_Ch . '</h4></td></tr>';
                                                            echo '</tbody></table>'; //caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
                                                        }
                                                    }
                                            }

                                            if (isset($presente_pendente))
                                                if ($presente_pendente == "true")
                                                    echo '* As linhas em amarelo são referentes a presentes com parte do valor ja lançado!';
                                ?>
                                    </div>
                                    <?php
                                    if ($conta == 3) {
                                        echo '<label><input  checked="checked"  name="numeroDoc" type="radio" value= "70_porcento" />
                                    Pertence aos 70% </label>';
                                        echo '<label><input name="numeroDoc" type="radio" value= "30_porcento" />Pertence aos 30%</label></br></br>';
                                    } ?>

                                <?php
                                }
                                ?>

                                <div class="span12" style="padding: 1%; margin-left: 0">
                                    <div class="span6 offset3" style="text-align: center">
                                        <button class="btn btn-success" id="btnContinuar"><i class="icon-share-alt icon-white"></i> Continuar</button>

                                        <!-- <button class="btn" id="btnContinuar" disabled>
                                            <i class="icon-share-alt icon-white"></i> Continuar
                                        </button> -->
                                        <a href="<?php echo base_url() ?>index.php/vendas" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                                    </div>
                                    <!-- <input name="habilitaEnvio" type="checkbox" value="0"> -->
                                </div>
                            </form>
                        </div>
                    </div>

                    <!--Anexos-->
                    <div class="tab-pane" id="tab2">
                        <div class="span12 well" style="padding: 1%; margin-left: 0" id="form-anexos">
                        <font color=#458B74 size=2>- Ao anexar ou excluir um arquivo já anexado CLICK em -Atualizar Anexos- para exibir os arquivos anexados.</font>
                            <div class="span12" style="padding: 1%; margin-left: 0">

                                <button id="btnBuscarAnexos" class="span12 btn btn-primary" style="align: center">
                                    Atualizar Anexos
                                </button>
                                <form id="formAnexos" enctype="multipart/form-data" action="javascript:;" accept-charset="utf-8" s method="post">

                                    <div class="span10">

                                        <label for="">Anexo</label>
                                        <input type="file" class="span12" name="userfile[]" multiple="multiple" size="20" />
                                    </div>
                                    <div class="span2">
                                        <label for="">.</label>

                                        <button class="btn btn-success span12" id="anexar_arquivo"><i class="icon-white icon-plus"></i> Anexar</button>


                                    </div>
                                    <input type="text" id="fin_id_form" name="fin_id" value="" />
                                    <input type="text" id="servico" name="servico" value="anexoTemp" />


                                </form>
                            </div>

                            <div class="span12" id="divAnexos" style="margin-left: 0">

                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>

        <div class="span12">
            <div id="blRodape">
                <h5 text-align=center>Utilidade pública federal</h5>

            </div><br />
            <h5 text-align=center>Observações de preenchimento</h5>
            <font color=#458B74 size=2>Padrão para preenchimento de valores
                99.999,99 ou 99999,99 ou 99999.99 ou 99999
            </font><br />
            <font color=red>( * )</font>
            <font color=red>Obs: </font>
            <font color=#458B74 size=2>- No campo <b>DOCUMENTO FISCAL </b> inserir NF ou CF antes do número e separando com traço. <br />- No campo <b>Historico </b>prencher <b>apenas</b> com o a razão social do estabelecimento. <br />- E no campo <b>DESCRIÇÃO</b> fica livre para descrever os detalhes que julgar nescessário.</font>




        </div>
    </div>
</div>
</div>

</div>

<!-- Modal visualizar anexo -->
<div id="modal-anexo" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Visualizar Anexo</h3>
    </div>
    <div class="modal-body">
        <div class="span12" id="div-visualizar-anexo" style="text-align: center">
            <div class='progress progress-info progress-striped active'>
                <div class='bar' style='width: 100%'>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
        <a href="" id-imagem="" class="btn btn-inverse" id="download">Download</a>
        <?php if ($usuario->conta_Usuario == 99) { ?>
            <a href="" link="" class="btn btn-danger" id="excluir-anexo">Excluir Anexo</a>
        <?php } ?>
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url(); ?>assets/js/maskmoney.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        let conta = <?= $conta ?>;
        let tipoES = <?= $tipoES ?>;

        $(".money").maskMoney();
        $("#cliente").autocomplete({
            source: "<?php echo base_url(); ?>index.php/vendas/autoCompleteCliente",
            minLength: 1,
            select: function(event, ui) {
                $("#clientes_id").val(ui.item.id);
            }
        });
        $("#tecnico").autocomplete({
            source: "<?php echo base_url(); ?>index.php/vendas/autoCompleteUsuario",
            minLength: 1,
            select: function(event, ui) {
                $("#usuarios_id").val(ui.item.id);
            }
        });
        $("#formVendas").validate({
            rules: {},
            messages: {
                cliente: {
                    required: 'Campo Requerido.'
                },
                valorFin: {
                    required: 'Campo Requerido.'
                },
                dataVenda: {
                    required: 'Campo Requerido.'
                }
            },
            errorClass: "help-inline",
            errorElement: "span",
            highlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').addClass('error');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').removeClass('error');
                $(element).parents('.control-group').addClass('success');
            }
        });

        $(".datepicker").datepicker({
            dateFormat: 'dd/mm/yy'
        });

        // Obtém o valor do elemento com o ID `fin_id_form`
        let fin_id_form = $("#fin_id_form");

        $("#btnBuscarAnexos").on("click", function() {
            // Obtém o valor do elemento com o ID `fin_id_form`
            fin_id_form = $("#fin_id_form").val();

            // Verifica se o valor é válido antes de chamar a função
            if (fin_id_form) {
                buscarAnexos(fin_id_form);
            } else {
                alert("Por favor, preencha todos os campos e adicione anexos antes de buscar os anexos.");
            }
        });

        // Variável de permissão, que pode ser controlada com base na lógica do seu sistema
        // var permissaoAnexos = false;  // Inicialmente o botão começa como bloqueado

        // Verifica o estado do botão logo ao carregar a página
        // verificarPermissao();

        function gerarIdForm() {

            // Obtém o ID do usuário do PHP
            let idUsuario = <?php echo $usuario->idUsuarios; ?>;

            // Obtém a data e hora atuais
            let now = new Date();
            let datatime =
                now.getDate().toString().padStart(2, '0') +
                now.getHours().toString().padStart(2, '0') +
                now.getMinutes().toString().padStart(2, '0') +
                now.getSeconds().toString().padStart(2, '0');

            // Concatena o ID do usuário com a data e hora
            let id_form = idUsuario + datatime;
            return id_form;
        }
        // Variável de controle de permissão
        let permissaoAnexos = <?= $aLancSemAnexo ?>; // Define se é necessário verificar anexos

        if (permissaoAnexos) {
            desabilitarBotaoContinuarSemAnexo();
        }
        // Função principal para verificar o estado do botão "Continuar"
        function verificarEstadoBotaoContinuar() {
            let codComp = $("#cod_Comp").val();
            let codAss = $("#cod_Ass").val();
            let numeroDoc = $("#numeroDoc").val();
            let numDocFiscal = $("#numDocFiscal").val();
            let dataVenda = $("#dataVenda").val();
            let razaoSoc = $("input[name='razaoSoc']").val();
            let descri = $("textarea[name='descri']").val();

            // Verifica se todos os campos têm mais de 3 caracteres e valorFin > 0
            let camposPreenchidos =
                codComp &&
                codAss &&
                numeroDoc && numeroDoc.length > 3 &&
                numDocFiscal && numDocFiscal.length > 3 &&
                dataVenda && dataVenda.length > 3 &&
                razaoSoc && razaoSoc.length > 3 &&
                descri && descri.length > 3;
            let condicaoContaES = conta > 3 && conta < 9 && tipoES == 0 ? 1 : 0;

            var fin_id_form_v = $("#fin_id_form").val();
            // Verifica se o valor está vazio
            if (!fin_id_form_v && camposPreenchidos && !permissaoAnexos) {
                // Gera um novo ID e atribui ao campo
                fin_id_form.val(gerarIdForm());
                $("#id_form").val(fin_id_form.val());
            }

            if (permissaoAnexos) {
                // console.log('Tem permissaoAnexos');
                console.log('camposPreenchidos: '+camposPreenchidos);
                console.log('camposPreenchidos: codComp '+codComp+' -codAss '+codAss+' -numeroDoc '
                +numeroDoc+' -numDocFiscal '+numDocFiscal+' -dataVenda '+dataVenda+' -razaoSoc '+razaoSoc+' -descri '+descri);
                desabilitarBotaoContinuarSemAnexo();
                $("#form-anexos").hide();
                // Apenas verifica os campos preenchidos
                if (camposPreenchidos) {
                    habilitarBotaoContinuar();
                } else {
                    desabilitarBotaoContinuarSemAnexo();
                }
            } else {
                console.log('Não tem permissaoAnexos');
                console.log('camposPreenchidos'+camposPreenchidos);
                // Verifica campos preenchidos e existência de anexos
                if (camposPreenchidos) {
                    // Verifica se é conta Compassion e saída
                    if (condicaoContaES) {
                        $("#form-anexos").show();
                        verificarAnexos(); // Verifica anexos antes de habilitar
                    } else {
                        $("#form-anexos").hide();
                        habilitarBotaoContinuar();
                    }
                } else {
                    $("#form-anexos").hide();
                    if (condicaoContaES) {
                        desabilitarBotaoContinuar();
                    } else {
                        desabilitarBotaoContinuarSemAnexo();
                    }
                }
            }
        }

        // Função para habilitar o botão "Continuar"
        function habilitarBotaoContinuar() {
            $("#btnContinuar").prop('disabled', false)
                .removeClass('btn-warning')
                .addClass('btn-success')
                .html('<i class="icon-share-alt icon-white"></i> Continuar');
        }

        // Função para desabilitar o botão "Continuar"
        function desabilitarBotaoContinuar() {
            $("#btnContinuar").prop('disabled', true)
                .removeClass('btn-success')
                .addClass('btn-warning')
                .html('<i class="icon-share-alt icon-white"></i> Preencher tudo e Anexar antes de continuar');
        }

        // Função para desabilitar o botão "Continuar"
        function desabilitarBotaoContinuarSemAnexo() {
            $("#btnContinuar").prop('disabled', true)
                .removeClass('btn-success')
                .addClass('btn-warning')
                .html('<i class="icon-share-alt icon-white"></i> Preencher tudo antes de continuar');
        }


        // Função para verificar anexos
        function verificarAnexos() {
            let fin_id_form = $("#fin_id_form").val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/vendas/buscarAnexos",
                data: {
                    fin_id: fin_id_form,
                    tabela: 'auxiliarTab'
                },
                dataType: "json",
                success: function(data) {
                    if (data.result && data.anexos.length > 0) {
                        console.log('Tem Anexos');
                        habilitarBotaoContinuar(); // Habilita o botão se há anexos
                    } else {
                        console.log('Não tem Anexos');
                        desabilitarBotaoContinuar(); // Bloqueia o botão se não há anexos
                    }
                },
                error: function() {
                    console.log("Erro ao verificar anexos.");
                    desabilitarBotaoContinuar();
                }
            });
        }

        // Executa a verificação inicial ao carregar a página
        verificarEstadoBotaoContinuar();

        // Reexecuta a verificação ao alterar campos
        $("#cod_Comp, #cod_Ass, #numeroDoc, #numDocFiscal, #dataVenda, input[name='razaoSoc'], textarea[name='descri']").on("input change", function() {
            verificarEstadoBotaoContinuar();
        });

        // Chama a verificação ao adicionar ou remover anexos
        $(document).on("click", ".excluir-anexo, #adicionar-anexo", function() {
            verificarEstadoBotaoContinuar();
        });

        $("#formAnexos").validate({
            submitHandler: function(form) {
                // Desabilita os botões "Anexar", "Continuar" e "Atualizar Anexos"
                $("#anexar_arquivo").prop('disabled', true);
                $("#btnContinuar").prop('disabled', true);
                $("#btnBuscarAnexos").prop('disabled', true)
                    .removeClass('btn-primary')
                    .addClass('btn-warning') // Adiciona cor laranja
                    .text('ATENÇÃO! AGUARDE O ARQUIVO CARREGAR.');

                var dados = new FormData(form);
                $("#form-anexos").hide('1000');
                $("#divAnexos").html("<div class='progress progress-info progress-striped active'><div class='bar' style='width: 100%'></div></div>");

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/vendas/anexar",
                    data: dados,
                    mimeType: "multipart/form-data",
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'json',
                    success: function(data) {
                        if (data.result == true) {
                            $("#divAnexos").load("<?php echo current_url(); ?> #divAnexos");
                            $("#userfile").val('');
                            // Verifica se o botão "Continuar" pode ser ativado
                            verificarAnexos();
                        } else {
                            $("#divAnexos").html('<div class="alert fade in"><button type="button" class="close" data-dismiss="alert">×</button><strong>Atenção!</strong> ' + data.mensagem + '</div>');
                        }
                    },
                    error: function() {
                        $("#divAnexos").html('<div class="alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert">×</button><strong>Atenção!</strong> Ocorreu um erro. Verifique se você anexou o(s) arquivo(s).</div>');
                    },
                    complete: function() {
                        // Reabilita os botões após a conclusão do processo
                        $("#anexar_arquivo").prop('disabled', false);
                        $("#btnContinuar").prop('disabled', false);
                        $("#btnBuscarAnexos").prop('disabled', false)
                            .removeClass('btn-warning') // Remove a cor laranja
                            .addClass('btn-primary') // Restaura a cor padrão
                            .text('Clique aqui para Atualizar os arquivos carregados.');
                    }
                });

                $("#form-anexos").show('1000');

                return false;
            }
        });
    });


    $(document).on('click', 'a', function(event) {
        var idProduto = $(this).attr('idAcao');
        var quantidade = $(this).attr('quantAcao');
        var produto = $(this).attr('prodAcao');
        if ((idProduto % 1) == 0) {
            $("#divProdutos").html("<div class='progress progress-info progress-striped active'><div class='bar' style='width: 100%'></div></div>");
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/vendas/excluirProduto",
                data: "idProduto=" + idProduto + "&quantidade=" + quantidade + "&produto=" + produto,
                dataType: 'json',
                success: function(data) {
                    if (data.result == true) {
                        $("#divProdutos").load("<?php echo current_url(); ?> #divProdutos");

                    } else {
                        alert('Ocorreu um erro ao tentar excluir produto.');
                    }
                }
            });
            return false;
        }

    });

    $(document).on('click', '.anexo', function(event) {
        event.preventDefault();

        var link = $(this).attr('link'); // URL do anexo
        var id = $(this).attr('imagem'); // ID do anexo
        var fin_id_form = $("#fin_id_form").val(); // ID do formulário financeiro

        // Atualiza a visualização do anexo
        $("#div-visualizar-anexo").html('<img src="' + link + '" alt="Visualizando Anexo">');
        $("#excluir-anexo").data('id', id); // Define o ID do anexo como atributo de dados
        $("#download").attr('href', "<?php echo base_url(); ?>index.php/vendas/downloadanexo/" + fin_id_form);
    });

    // Requisição AJAX ao clicar em #excluir-anexo
    $(document).on('click', '#excluir-anexo', function(event) {
        event.preventDefault();

        var id = $(this).data('id'); // ID do anexo a ser excluído
        var url = '<?php echo base_url(); ?>index.php/vendas/excluirAnexosTemporarios/' + id;

        if (!id) {
            alert("Erro: ID do anexo não encontrado.");
            return;
        }

        if (!confirm("Tem certeza que deseja excluir este anexo?")) {
            return;
        }

        $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            success: function(response) {

                // Após excluir, verifica novamente os anexos
                verificarAnexos();

                if (response.success) {
                    alert(response.message);

                    // Atualize a interface, remova o anexo visualizado, etc.
                    $("#div-visualizar-anexo").html('<p>Anexo excluído com sucesso.</p>');
                } else {
                    alert("Erro ao excluir anexo: " + response.message);
                }
            },
            error: function() {
                alert("Erro na comunicação com o servidor. Tente novamente.");
            }
        });
    });
    
    // Adiciona evento para os campos cujo ID começa com 'valorPre'
    $(document).on('blur', '[id^="valorPre"]', function () {
        console.log('Campo saiu do foco:', $(this).attr('id'), 'Valor:', $(this).val());
        atualizarValorTotal(); // Atualiza o total sempre que um campo perde o foco
    });
    
    // Função para atualizar o valor total
    function atualizarValorTotal() {
        console.log('Atualizando o valor total...');
        let total = 0; // Reinicia o total a cada execução
    
        // Itera por todos os campos cujo ID começa com "valorPre"
        $('[id^="valorPre"]').each(function () {
            const valor = parseFloat($(this).val().replace(',', '.')) || 0; // Converte para número
            total += valor; // Soma o valor atual ao total
        });
    
        // Atualiza o campo de total
        const campoTotal = $('#valtotal');
        if (campoTotal.length > 0) {
            campoTotal.val(total.toFixed(2).replace('.', ',')); // Formata como moeda
            console.log('Total atualizado para:', campoTotal.val());
        }
    }

    function buscarAnexos(fin_id) {
        // Mostra um indicador de carregamento
        $("#divAnexos").html("<div class='progress progress-info progress-striped active'><div class='bar' style='width: 100%'></div></div>");

        // Faz a requisição AJAX para buscar os anexos
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/vendas/buscarAnexos",
            data: {
                fin_id: fin_id,
                tabela: 'auxiliarTab'
            },
            dataType: "json",
            success: function(data) {
                if (data.result) {
                    let anexosHtml = "";

                    data.anexos.forEach(function(anexo, index) {
                        let thumb = anexo.thumb ?
                            "<?php echo base_url(); ?>assets/anexos/thumbs/" + anexo.thumb :
                            "<?php echo base_url(); ?>assets/img/icon-file.png";

                        let link = anexo.thumb ?
                            anexo.url + anexo.anexo :
                            "<?php echo base_url(); ?>assets/img/icon-file.png";

                        anexosHtml += `
                            <div class="span3">
                                <a href="#modal-anexo" imagem="${anexo.idAnexos}" link="${link}" role="button" class="btn anexo" data-toggle="modal">
                                    <img src="${thumb}" alt="">
                                </a>
                            </div>`;
                    });

                    // Atualiza o conteúdo do div com os anexos
                    $("#divAnexos").html(anexosHtml);
                } else {
                    $("#divAnexos").html('<div class="alert alert-warning">Nenhum anexo encontrado.</div>');
                }
            },
            error: function() {
                $("#divAnexos").html('<div class="alert alert-danger">Erro ao buscar os anexos. Tente novamente.</div>');
            }
        });
    }
</script>