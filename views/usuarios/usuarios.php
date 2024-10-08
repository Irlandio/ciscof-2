<a href="<?php echo base_url()?>index.php/usuarios/adicionar" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Usuário</a>
<?php
if(!$results){?>
        <div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-user"></i>
        </span>
        <h5>Usuários</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr style="backgroud-color: #2D335B">
            <th>#</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>Conta Acesso</th>
            <th>Nível</th>
            <th></th>
        </tr>
    </thead>
    <tbody>    
        <tr>
            <td colspan="5">Nenhum Usuário Cadastrado</td>
        </tr>
    </tbody>
</table>
</div>
</div>


<?php } else{?>

<div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-user"></i>
         </span>
        <h5>Usuários</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr style="backgroud-color: #2D335B">
            <th>#</th>
            <th>Nome | e-mail</th>
            <th>CPF</th>
            <th>Conta Acesso</th>
            <th>Nível</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $r) {
           
           if($r->situacao == 1) {$status = "Ativo"; $corStt = 'Blue';}
           if($r->situacao == 0) {$status = "Inativo"; $corStt = '#ada9a1'; }

           if($r->nome_caixa == null) {$conta = "Todas contas";
            }else {$conta = $r->nome_caixa;}
            echo '<tr>';
            echo '<td>'.$r->idUsuarios.'</td>';
                    echo '<td><font  color = '.$corStt.' >
                    <a href="'.base_url().'index.php/usuarios/editar/'.$r->idUsuarios.'"  title="Editar Usuário">'.$r->nome.'</a> | '.$r->email.'</font></td>';
            echo '<td>'.$r->cpf.'</td>';
            echo '<td>'.$conta.'</td>';
            echo '<td></td>';
            echo '<td>'.$r->permissao.'</td>';
            echo '<td>
                      <a href="'.base_url().'index.php/usuarios/editar/'.$r->idUsuarios.'" class="btn btn-info tip-top" title="Editar Usuário"><i class="icon-pencil icon-white"></i></a>
                  </td>';
            echo '</tr>';
        }?>
        <tr>
            
        </tr>
    </tbody>
</table>
</div>
</div>

	
<?php echo $this->pagination->create_links();}?>
