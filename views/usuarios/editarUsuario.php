<?php
// var_dump('$arrpermissoes ',$arrpermissoes->nome);echo '<br>';
// var_dump('$arrpermissao_Geral ',$arrpermissao_Geral->nome);echo '<br>';
// var_dump('$arrpermissoesUSER ',$arrpermissoesUSER->nome);echo '<br>';

if (NULL == $arrpermissoes) {
    // $arrpermissoes = $permissao_Geral;
}
$apermissoes = unserialize($arrpermissoes->permissoes);
$camposPermissoes = array_keys($apermissoes, 1); //  PERMISSÕES INDIVIDUAIS DO USUÁRIO em EDIÇÃO

$apermissao_Geral = unserialize($arrpermissao_Geral->permissoes);
$camposPermiss_Geral = array_keys($apermissao_Geral, 1);

$apermissoesUSER = unserialize($arrpermissoesUSER->permissoes); // PERMISSÕES DO USUÁRIO logado
$camposPermissoesUSER = array_keys($apermissoesUSER, 1);
?>
<style type="text/css">
    #blAuxRolagem {
        overflow: auto;
        float: left;
        /*sua largura*/
        width: 680px;
        /*sua altura*/
        height: 600px;
        clear: both;
        text-align: lefht;
        text-align: lefht;
        background: #FFFFF0;
    }
</style>
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-user"></i>
                </span>
                <h5>Editar Usuário</h5>
            </div>
            <div class="widget-content nopadding">
                <?php if ($custom_error != '') {
                    echo '<div class="alert alert-danger">' . $custom_error . '</div>';
                } ?>
                <form action="<?php echo current_url(); ?>" id="formUsuario" method="post" class="form-horizontal">
                    <div class="span5">
                        <div class="control-group">
                            <?php echo form_hidden('idUsuarios', $result->idUsuarios) ?>
                            <label for="nome" class="control-label">Nome<span class="required">*</span></label>
                            <div class="controls">
                                <input id="nome" type="text" name="nome" value="<?php echo $result->nome; ?>" />
                            </div>
                        </div>

                        <div class="control-group">
                            <label for="rg" class="control-label">RG<span class="required">*</span></label>
                            <div class="controls">
                                <input id="rg" type="text" name="rg" value="<?php echo $result->rg; ?>" />
                            </div>
                        </div>

                        <div class="control-group">
                            <label for="cpf" class="control-label">CPF<span class="required">*</span></label>
                            <div class="controls">
                                <input id="cpf" type="text" name="cpf" value="<?php echo $result->cpf; ?>" />
                            </div>
                        </div>

                        <div class="control-group">
                            <label for="rua" class="control-label">Rua<span class="required">*</span></label>
                            <div class="controls">
                                <input id="rua" type="text" name="rua" value="<?php echo $result->rua; ?>" />
                            </div>
                        </div>

                        <div class="control-group">
                            <label for="numero" class="control-label">Numero<span class="required">*</span></label>
                            <div class="controls">
                                <input id="numero" type="text" name="numero" value="<?php echo $result->numero; ?>" />
                            </div>
                        </div>

                        <div class="control-group">
                            <label for="bairro" class="control-label">Bairro<span class="required">*</span></label>
                            <div class="controls">
                                <input id="bairro" type="text" name="bairro" value="<?php echo $result->bairro; ?>" />
                            </div>
                        </div>

                        <div class="control-group">
                            <label for="cidade" class="control-label">Cidade<span class="required">*</span></label>
                            <div class="controls">
                                <input id="cidade" type="text" name="cidade" value="<?php echo $result->cidade; ?>" />
                            </div>
                        </div>

                        <div class="control-group">
                            <label for="estado" class="control-label">Estado<span class="required">*</span></label>
                            <div class="controls">
                                <input id="estado" type="text" name="estado" value="<?php echo $result->estado; ?>" />
                            </div>
                        </div>

                        <div class="control-group">
                            <label for="email" class="control-label">Email<span class="required">*</span></label>
                            <div class="controls">
                                <input id="email" type="text" name="email" value="<?php echo $result->email; ?>" />
                            </div>
                        </div>

                        <div class="control-group">
                            <label for="senha" class="control-label">Senha</label>
                            <div class="controls">
                                <input id="senha" type="password" name="senha" value="" placeholder="Não preencha se não quiser alterar." />
                                <i class="icon-exclamation-sign tip-top" title="Se não quiser alterar a senha, não preencha esse campo."></i>
                            </div>
                        </div>

                        <div class="control-group">
                            <label for="telefone" class="control-label">Conta<span class="required">*</span></label>
                            <div class="controls">
                                <?php
                                ?>
                                <select id="telefone" name="telefone">
                                    <?php
                                    $selected = ' ';
                                    $selecionado = 'selected';
                                    foreach ($result_caixas as $rcx) {
                                        $selected = $result->conta_Usuario == $rcx->id_caixa ? 'selected' : ' ';
                                    ?>
                                        <option value="<?php echo $rcx->id_caixa ?>" <?= $selected ?>><?php echo $rcx->id_caixa . " | " . $rcx->nome_caixa ?></option>
                                    <?php
                                        if ($selecionado == 'selected')
                                            $selecionado = $selected == 'selected' ? '' : 'selected';
                                    }


                                    ?>
                                    <option value="99" <?= $selecionado ?>>99 | Todas contas</option>
                                </select>

                            </div>
                        </div>

                        <div class="control-group">
                            <label for="celular" class="control-label">Tipo conta Acesso</label>
                            <div class="controls">
                                <select id="celular" name="celular">
                                    <option value="1" <?= $result->celular == 1 ? "selected" : ""; ?>>1 | Muito Limitado</option>
                                    <option value="2" <?= $result->celular == 2 ? "selected" : ""; ?>>2 | Limitado</option>
                                    <option value="3" <?= $result->celular == 3 ? "selected" : ""; ?>>3 | Pouco Limitado</option>
                                    <option value="4" <?= $result->celular == 4 ? "selected" : ""; ?>>4 | Ilimitado</option>
                                </select>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Situação*</label>
                            <div class="controls">
                                <select name="situacao" id="situacao">
                                    <?php if ($result->situacao == 1) {
                                        $ativo = 'selected';
                                        $inativo = '';
                                    } else {
                                        $ativo = '';
                                        $inativo = 'selected';
                                    } ?>
                                    <option value="1" <?php echo $ativo; ?>>Ativo</option>
                                    <option value="0" <?php echo $inativo; ?>>Inativo</option>
                                </select>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Permissões<span class="required">*</span></label>
                            <div class="controls">
                                <select name="permissoes_Geral" id="permissoes_Geral">
                                    <?php foreach ($permissoesID as $p) {
                                        if (!is_numeric($p->nome)) {
                                            if ($p->idPermissao == $result->permissoes_Geral) {
                                                $selected = 'selected';
                                            } else {
                                                $selected = '';
                                            }
                                            echo '<option value="' . $p->idPermissao . '"' . $selected . '>' . $p->nome . '</option>';
                                        }
                                    } ?>
                                </select>
                                <input id="permissoes_id" type="hidden" name="permissoes_id" value="<?php echo $result->permissoes_id; ?>" />
                            </div>
                        </div>

                        <div class="form-actions">
                            <div class="span12">
                                <div class="span6 offset3">
                                    <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Alterar</button>
                                    <a href="<?php echo base_url() ?>index.php/usuarios" id="" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="span9">
                        <?php
                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'cPermissaoID') || $this->session->userdata('id') == 20) {
                            $contas = array();
                            foreach ($result_caixas as $rcx) {
                                $contas[$rcx->id_caixa] = $rcx->nome_caixa;
                            }
                            // var_dump($contas);
                        ?>

                            <div class="span12">

                                <div class="widget-box">
                                    <ul class="nav nav-tabs">
                                        <li class="active" id="tabDetalhes"><a href="#tab1" data-toggle="tab">Permissões individuais</a></li>
                                        <li id="tabAnexos"><a href="#tab2" data-toggle="tab">Permissões Gerais</a></li>

                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab1">
                                            <div id="blAuxRolagem">
                                                <div class="control-group">
                                                    <label for="documento" class="control-label"></label>
                                                    <table class="table table-bordered">
                                                        <tbody>

                                                            <?php

                                                            $cont = 0;
                                                            $pC = 0;
                                                            foreach ($tiposPermissoes as $tp) {
                                                                if ($tp->tipo != 1) {
                                                                    $bloco = '';
                                                                    if ($cont % 4 == 0) {
                                                                        echo '</tr><tr>';
                                                                        if ($tp->id > 78) {
                                                                            $permisaoD = explode('_', $tp->nomePermissao);
                                                                            $permisaocONTA = $permisaoD[0];
                                                                            $permisaocONTA = substr($permisaoD[0], -2, 2);
                                                                            if (isset($contas[intval($permisaocONTA)]))
                                                                                if ($permisaocONTA != $pC) {
                                                                                    echo '<td colspan=4><H5>Permisões EXTRAS da conta ' .
                                                                                        $contas[intval($permisaocONTA)] . '</H5></td></tr><tr>';
                                                                                }
                                                                            $pC = $permisaocONTA;
                                                                        }
                                                                    }
                                                                    if ($tp->tipo == 3) {
                                                                        echo '<td colspan=3></td>';
                                                                        $cont += 3;
                                                                        $bloco = $tp->id == 38 ? "tempoPadrao" : "anexos";
                                                                    }
                                                            ?>
                                                                    <td><label><input <?php
                                                                                        $campo = $tp->nomePermissao;
                                                                                        $pode = 1;
                                                                                        if (in_array($campo, $camposPermissoesUSER)) {
                                                                                            $pode = 1;
                                                                                        }
                                                                                        if ($pode == 1) {
                                                                                            if (isset($apermissoes[$campo])) {
                                                                                                if ($apermissoes[$campo] == 1) {
                                                                                                    echo 'checked';
                                                                                                }
                                                                                            }
                                                                                        ?> name="<?= $tp->nomePermissao ?>" class="marcar" type="checkbox" value="1" title="<?= $tp->obs ?>" />
                                                                            <span class="lbl" title="<?= $tp->obs ?>"> <?= $tp->descricao ?></span>
                                                                        </label>
                                                                    </td>
                                                                <?php
                                                                                            $cont++;
                                                                                        } else {
                                                                                            $val = null;
                                                                                            if (isset($apermissoes[$campo]))
                                                                                                if ($apermissoes[$campo] == 1) {
                                                                                                    $val = 1;
                                                                                                }
                                                                ?> name="<?= $tp->nomePermissao ?>" class="marcar" type="hidden" value="<?= $val ?>" />
                                                                    <font color=Moccasin><span class="lbl"> <?= $tp->descricao ?>
                                                                        </span></font></label></td>
                                                        <?php
                                                                                            $cont++;
                                                                                        }

                                                                                        if ($bloco == "tempoPadrao") {
                                                                                            echo '<TR><td colspan=4><H4>Permisões para adicionar lançamento SEM Anexo</H5></td>';
                                                                                        }
                                                                                        if ($bloco == "anexos") {
                                                                                            echo '<TR><td colspan=4><H4>Permisões padrão de mês corrente</H5></td>';
                                                                                        }
                                                                                    }
                                                                                }
                                                        ?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="tab-pane" id="tab2">
                                            <div id="blAuxRolagem">
                                                <div class="control-group">
                                                    <label for="documento" class="control-label"></label>
                                                    <!-- <div class="controls"> -->

                                                    <table class="table table-bordered">
                                                        <tbody>

                                                            <?php
                                                            $cont = 0;
                                                            foreach ($tiposPermissoes as $tp) {
                                                                if ($tp->tipo == 1) {
                                                                    if ($cont % 4 == 0) echo '</tr><tr>';
                                                                    $tem = 0;
                                                            ?>
                                                                    <td><label><input <?php
                                                                                        $campo = $tp->nomePermissao;
                                                                                        // if(isset($apermissoes[$campo]))
                                                                                        if (in_array($campo, $camposPermiss_Geral)) {
                                                                                            $tem = 1;
                                                                                        }
                                                                                        if ($tem == 1) {
                                                                                        ?> name="<?= $tp->nomePermissao ?>" class="marcar" type="hidden" value="1" title="<?= $tp->obs ?>" />
                                                                            <h5><span class="lbl" title="<?= $tp->obs ?>"> <?= $tp->descricao ?> </span></H5>
                                                                        </label>
                                                                    </td>
                                                                    <?php
                                                                                        } else {
                                                                                            $pode = 0;
                                                                                            if (in_array($campo, $camposPermissoesUSER)) {
                                                                                                $pode = 1;
                                                                                            }
                                                                                            if ($pode == 1) {
                                                                                                if ($apermissoes[$campo] == 1) {
                                                                                                    echo 'checked';
                                                                                                }
                                                                    ?>
                                                                        name="<?= $tp->nomePermissao ?>" class="marcar" type="checkbox" value="1" />
                                                                        <span class="lbl"> <?= $tp->descricao ?>
                                                                        </span></label></td>
                                                                    <?php
                                                                                            } else {
                                                                                                $val = null;
                                                                                                if ($apermissoes[$campo] == 1) {
                                                                                                    $val = 1;
                                                                                                }
                                                                    ?> name="<?= $tp->nomePermissao ?>" class="marcar" type="hidden" value="<?= $val ?>" />
                                                                        <font color=Moccasin><span class="lbl"> <?= $tp->descricao ?>
                                                                            </span></font></label></td>
                                                        <?php
                                                                                            }
                                                                                        }
                                                                                        $cont++;
                                                                                    }
                                                                                }
                                                        ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            <?php }
                            ?>

                            </div>
                </form>
            </div>
        </div>
    </div>
</div>




<script src="<?php echo base_url() ?>assets/js/jquery.validate.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        $('#formUsuario').validate({
            rules: {
                nome: {
                    required: true
                },
                rg: {
                    required: true
                },
                cpf: {
                    required: true
                },
                telefone: {
                    required: true
                },
                email: {
                    required: true
                },
                rua: {
                    required: true
                },
                numero: {
                    required: true
                },
                bairro: {
                    required: true
                },
                cidade: {
                    required: true
                },
                estado: {
                    required: true
                },
                cep: {
                    required: true
                }
            },
            messages: {
                nome: {
                    required: 'Campo Requerido.'
                },
                rg: {
                    required: 'Campo Requerido.'
                },
                cpf: {
                    required: 'Campo Requerido.'
                },
                telefone: {
                    required: 'Campo Requerido.'
                },
                email: {
                    required: 'Campo Requerido.'
                },
                rua: {
                    required: 'Campo Requerido.'
                },
                numero: {
                    required: 'Campo Requerido.'
                },
                bairro: {
                    required: 'Campo Requerido.'
                },
                cidade: {
                    required: 'Campo Requerido.'
                },
                estado: {
                    required: 'Campo Requerido.'
                },
                cep: {
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

    });
</script>