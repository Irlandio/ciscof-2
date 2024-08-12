<div class="span7" style="margin-left: 0">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-th-list"></i>
		        </span>
                <h5>Minha Conta</h5>
            </div>
            <div class="widget-content">
                <div class="row-fluid" style="margin-top:0">
                    <ul class="site-stats">
                        <li class="bg_ls span12"><strong>Nome: <?php echo $usuario->nome?></strong></li>
                        <?php 
                        $cnt = $usuario->conta_Usuario;
                        $caixaNome = $cnt != 99 ? $this->session->userdata('conta'.$cnt.'_nome') : "Todas contas";
                            ?>
                        <li class="bg_lb span12" style="margin-left: 0"><strong>Conta de acesso: <?php echo $caixaNome?></strong></li>
                        <li class="bg_lg span12" style="margin-left: 0"><strong>Email: <?php echo $usuario->email?></strong></li>
                        <!-- <li class="bg_lo span12" style="margin-left: 0"><strong>Nível: <?php echo $usuario->permissao; ?></strong></li> -->
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="span5">
        <div class="row-fluid" style="margin-top:0">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
                        <span class="icon">
                            <i class="icon-align-justify"></i>
                        </span>
                        <h5>Minha foto</h5>
                    </div>
                    <div class="widget-content ">
                    <div class="alert alert-info">A IMAGEM e os dados abaixo podem ser alterados pelo usuário. A imagem não pode ter alta definição.</div>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td style="width: 25%" rowspan=2><img src=" <?php echo $usuario->url_foto; ?> "></td>
                                    <td> <span style="font-size: 20px; "> <?php echo $usuario->nome; ?> </span> <br><span><?php echo $usuario->cpf; ?> <br> <?php echo $usuario->rua.', nº:'.$usuario->numero.', '.$usuario->bairro.' - '.$usuario->cidade.' - '.$usuario->estado; ?> </span> <br> <span> E-mail: <?php echo $usuario->email.' - Fone: '.$usuario->permissoes_id; ?></span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#modalFoto" data-toggle="modal" role="button" class="btn btn-inverse">Alterar Foto</a>
                                        <a href="#modalAlterar" data-toggle="modal" role="button" class="btn btn-primary">Alterar Dados</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="span6">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-th-list"></i>
		        </span>
                <h5>Alterar Minha Senha</h5>
            </div>
            <div class="widget-content">
                <div class="row-fluid">
                    <div class="span12" style="min-height: 260px">
                        <form id="formSenha" action="<?php echo base_url();?>index.php/mapos/alterarSenha" method="post">
                        
                        <div class="span12" style="margin-left: 0">
                            <label for="">Senha Atual</label>
                            <input type="password" id="oldSenha" name="oldSenha" class="span12" />
                        </div>
                        <div class="span12" style="margin-left: 0">
                            <label for="">Nova Senha</label>
                            <input type="password" id="novaSenha" name="novaSenha" class="span12" />
                        </div>
                        <div class="span12" style="margin-left: 0">
                            <label for="">Confirmar Senha</label>
                            <input type="password" name="confirmarSenha" class="span12" />
                        </div>
                        <div class="span12" style="margin-left: 0; text-align: center">
                            <button class="btn btn-primary">Alterar Senha</button>
                        </div>
                        </form>
                    </div>

                </div>
            </div>
            

        </div>
    </div>
<div id="modalAlterar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url(); ?>index.php/mapos/editarusuario" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="">CiscoD - Editar Dados do Usuário</h3>
  </div>
  <div class="modal-body">
        
        
                    <div class="control-group">
                        <label for="nome" class="control-label">Nome<span class="required">*</span></label>
                        <div class="controls">
                            <input id="nome" type="text" name="nome" value="<?php echo $usuario->nome; ?>"  />
                            <input id="nome" type="hidden" name="id" value="<?php echo $usuario->idUsuarios; ?>"  />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="cnpj" class="control-label"><span class="required">CNPJ*</span></label>
                        <div class="controls">
                            <input class="" type="text" name="cnpj" value="<?php echo $usuario->cpf; ?>"  />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="descricao" class="control-label"><span class="required">Logradouro*</span></label>
                        <div class="controls">
                            <input type="text" name="logradouro" value="<?php echo $usuario->rua; ?>"  />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="descricao" class="control-label"><span class="required">Número*</span></label>
                        <div class="controls">
                            <input type="text" name="numero" value="<?php echo $usuario->numero; ?>"  />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="descricao" class="control-label"><span class="required">Bairro*</span></label>
                        <div class="controls">
                            <input type="text" name="bairro" value="<?php echo $usuario->bairro; ?>"  />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="descricao" class="control-label"><span class="required">Cidade*</span></label>
                        <div class="controls">
                            <input type="text" name="cidade" value="<?php echo $usuario->cidade; ?>"  />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="descricao" class="control-label"><span class="required">UF*</span></label>
                        <div class="controls">
                            <input type="text" name="uf" value="<?php echo $usuario->estado; ?>"  />
                        </div>
                    </div>

    
               

  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
   <!-- <button class="btn btn-primary">Alterar</button>-->
  </div>
  </form>
</div>


<div id="modalFoto" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url(); ?>index.php/mapos/editarFoto" id="formLogo" enctype="multipart/form-data" method="post" class="form-horizontal" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="">CiscoF - Alterar Logomarca</h3>
  </div>
  <div class="modal-body">
         <div class="span12 alert alert-info">Selecione uma nova imagem da logomarca. Tamanho indicado (130 X 130).</div>          
         <div class="control-group">
            <label for="logo" class="control-label"><span class="required">Logomarca*</span></label>
            <div class="controls">
                <input type="file" name="userfile" value="" />
                <input id="nome" type="hidden" name="id" value="<?php echo $usuario->idUsuarios; ?>"  />
            </div>
        </div>

  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
    <button class="btn btn-primary">Alterar</button> 
  </div>
  </form>
</div>


<script src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>
<script type="text/javascript">
    $(document).ready(function(){

        $('#formSenha').validate({
            rules :{
                  oldSenha: {required: true},  
                  novaSenha: { required: true},
                  confirmarSenha: { equalTo: "#novaSenha"}
            },
            messages:{
                  oldSenha: {required: 'Campo Requerido'},  
                  novaSenha: { required: 'Campo Requerido.'},
                  confirmarSenha: {equalTo: 'As senhas não combinam.'}
            },

            errorClass: "help-inline",
            errorElement: "span",
            highlight:function(element, errorClass, validClass) {
                $(element).parents('.control-group').addClass('error');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').removeClass('error');
                $(element).parents('.control-group').addClass('success');
            }
           });
    });
</script>