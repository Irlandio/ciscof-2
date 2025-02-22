<?php

class Usuarios extends CI_Controller {
    

    /**
     * author:  Irlândio Oliveira 
     * email: irlandiooliveira@gmail.com
     * 
     */
    
    function __construct() {

        parent::__construct();
        if( (!session_id()) || (!$this->session->userdata('logado'))){
            redirect('mapos/login');
        }
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'cUsuario')){
          $this->session->set_flashdata('error','Você não tem permissão para configurar os usuários.');
          redirect(base_url());
        }

        $this->load->helper(array('form', 'codegen_helper'));
        $this->load->model('usuarios_model', '', TRUE);
        $this->data['menuUsuarios'] = 'Usuários';
        $this->data['menuConfiguracoes'] = 'Configurações';
    }

    function index(){
		$this->gerenciar();
	}

	function gerenciar(){
        
        $this->load->library('pagination');
        

        $config['base_url'] = base_url().'index.php/usuarios/gerenciar/';
        $config['total_rows'] = $this->usuarios_model->count('usuarios');
        $config['per_page'] = 15;
        $config['next_link'] = 'Próxima';
        $config['prev_link'] = 'Anterior';
        $config['full_tag_open'] = '<div class="pagination alternate"><ul>';
        $config['full_tag_close'] = '</ul></div>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li><a style="color: #2D335B"><b>';
        $config['cur_tag_close'] = '</b></a></li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';	
        $config['first_link'] = 'Primeira';
        $config['last_link'] = 'Última';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        
        $this->pagination->initialize($config); 	

		$this->data['results'] = $this->usuarios_model->get($config['per_page'],$this->uri->segment(3));
       
        $this->data['result_caixas'] = $this->usuarios_model->get2('caixas');
	    $this->data['view'] = 'usuarios/usuarios';
       	$this->load->view('tema/topo',$this->data);

       
		
    }
	
    function adicionar(){  
          
        $this->load->library('form_validation');    
		$this->data['custom_error'] = '';
		
        if ($this->form_validation->run('usuarios') == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="alert alert-danger">'.validation_errors().'</div>' : false);

        } else
        {     

            $this->load->library('encryption');
            $this->encryption->initialize(array('driver' => 'mcrypt'));

            $data = array(
                    'nome' => set_value('nome'),
					'rg' => set_value('rg'),
					'cpf' => set_value('cpf'),
					'rua' => set_value('rua'),
					'numero' => set_value('numero'),
					'bairro' => set_value('bairro'),
					'cidade' => set_value('cidade'),
					'estado' => set_value('estado'),
					'email' => set_value('email'),
					'senha' => $this->encryption->encrypt($this->input->post('senha')),
					'conta_Usuario' => $this->input->post('conta_Usuario'),
					'celular' => $this->input->post('tipo_Acesso'),
					'situacao' => set_value('situacao'),
                    'permissoes_id' => $this->input->post('permissoes_id'),
					'dataCadastro' => date('Y-m-d')
            );
           
			if ($this->usuarios_model->add('usuarios',$data) == TRUE)
			{
                                $this->session->set_flashdata('success','Usuário cadastrado com sucesso!');
				redirect(base_url().'index.php/usuarios/adicionar/');
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';

			}
		}
        
        $this->data['result_caixas'] = $this->usuarios_model->get2('caixas');        
        $this->load->model('permissoes_model');
        $this->data['permissoes'] = $this->permissoes_model->getActive('permissoes','permissoes.idPermissao,permissoes.nome');   
		$this->data['view'] = 'usuarios/adicionarUsuario';
        $this->load->view('tema/topo',$this->data);
   
       
    }	
    
    function editar(){  
        
        if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))){
            $this->session->set_flashdata('error','Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('mapos');
        }

        $this->load->library('form_validation');    
		$this->data['custom_error'] = '';
        $this->form_validation->set_rules('nome', 'Nome', 'trim|required');
        $this->form_validation->set_rules('rg', 'RG', 'trim|required');
        $this->form_validation->set_rules('cpf', 'CPF', 'trim|required');
        $this->form_validation->set_rules('rua', 'Rua', 'trim|required');
        $this->form_validation->set_rules('numero', 'Número', 'trim|required');
        $this->form_validation->set_rules('bairro', 'Bairro', 'trim|required');
        $this->form_validation->set_rules('cidade', 'Cidade', 'trim|required');
        $this->form_validation->set_rules('estado', 'Estado', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('telefone', 'Telefone', 'trim|required');
        $this->form_validation->set_rules('situacao', 'Situação', 'trim|required');
        $this->form_validation->set_rules('permissoes_id', 'Permissão', 'trim|required');

        if ($this->form_validation->run() == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);

        } else
        { 

        $tiposPermissoes = $this->usuarios_model->get2('permissoes_tipos');
        $permissao_ID = $this->input->post('permissoes_id'); //ID DA PERMISSÃO INDIVIDUAL

        foreach ($tiposPermissoes as $tp) {
            $permiss["$tp->nomePermissao"] = $this->input->post("$tp->nomePermissao");
        }
        $permiss = serialize($permiss);
        $idUsuario = $this->input->post('idUsuarios');
        $this->load->model('permissoes_model');
        $permissao = $this->usuarios_model->getByIdPermissao($permissao_ID);
        $addperm = $edtperm = '';
        if($permissao->nome != $idUsuario)
        {
            $permissoes_id = $idUsuario;
            $data = array(
                'nome' => $idUsuario,
                'permissoes' => $permiss,
                'data' => date('Y-m-d'),
                'situacao' => 1
            );
            // $permissaoNEW = $this->usuarios_model->getByIdPermissao($idUsuario,'nome');
            // $permissaoNEWid = $permissaoNEW->idPermissao;
            // var_dump($permissaoNEW);
            // die();
            if ($this->usuarios_model->add('permissoes', $data) == TRUE) {
                $addperm = 'Permissão adicionada com sucesso!';
                $permissaoNEW = $this->usuarios_model->getByIdPermissao($idUsuario,'nome');
                $permissaoNEWid = $permissaoNEW->idPermissao;
            }
        }else
        {
            $permissoes_id = $permissao_ID;
            $data = array(
                'permissoes' => $permiss,
                'situacao' => 1
            );
            if ($this->usuarios_model->edit('permissoes', $data, 'idPermissao', $permissao->idPermissao ) == TRUE) {
                $edtperm = 'Permissão editada com sucesso!';
                $permissaoNEWid = $permissao->idPermissao;

            } 
        }
        // NÃO EXCLUIR O AMIN SUPER
            if ($this->input->post('idUsuarios') == 1 && $this->input->post('situacao') == 0)
            {
                $this->session->set_flashdata('error','O usuário super admin não pode ser desativado!');
                redirect(base_url().'index.php/usuarios/editar/'.$this->input->post('idUsuarios'));
            }

            $senha = $this->input->post('senha'); 
            if($senha != null){

                $this->load->library('encryption');
                $this->encryption->initialize(array('driver' => 'mcrypt'));

                $senha = $this->encryption->encrypt($senha);

                $data = array(
                        'nome' => $this->input->post('nome'),
                        'rg' => $this->input->post('rg'),
                        'cpf' => $this->input->post('cpf'),
                        'rua' => $this->input->post('rua'),
                        'numero' => $this->input->post('numero'),
                        'bairro' => $this->input->post('bairro'),
                        'cidade' => $this->input->post('cidade'),
                        'estado' => $this->input->post('estado'),
                        'email' => $this->input->post('email'),
                        'senha' => $senha,
                        'conta_Usuario' => $this->input->post('telefone'),
                        'celular' => $this->input->post('celular'),
                        'situacao' => $this->input->post('situacao'),
                        'permissoes_id' => $permissaoNEWid,
                        'permissoes_Geral' => $this->input->post('permissoes_Geral')
                );
            }  

            else{

                $data = array(
                        'nome' => $this->input->post('nome'),
                        'rg' => $this->input->post('rg'),
                        'cpf' => $this->input->post('cpf'),
                        'rua' => $this->input->post('rua'),
                        'numero' => $this->input->post('numero'),
                        'bairro' => $this->input->post('bairro'),
                        'cidade' => $this->input->post('cidade'),
                        'estado' => $this->input->post('estado'),
                        'email' => $this->input->post('email'),
                        'conta_Usuario' => $this->input->post('telefone'),
                        'celular' => $this->input->post('celular'),
                        'situacao' => $this->input->post('situacao'),
                        'permissoes_id' => $permissaoNEWid,
                        'permissoes_Geral' => $this->input->post('permissoes_Geral')
                );

            }           
			if ($this->usuarios_model->edit('usuarios',$data,'idUsuarios',$this->input->post('idUsuarios')) == TRUE)
			{
                $this->session->set_flashdata('success','Usuário editado com sucesso!'.$addperm.' '.$edtperm);
				redirect(base_url().'index.php/usuarios/editar/'.$this->input->post('idUsuarios'));
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';

			}
		}
		$this->data['result'] = $this->usuarios_model->getById($this->uri->segment(3));

		$idPermissao = $this->data['result']->permissoes_id;
		$permissao_IDGeral = $this->data['result']->permissoes_Geral;                
        
        $this->data['arrpermissoes'] = $this->usuarios_model->getByIdPermissao($idPermissao);
        $this->data['arrpermissao_Geral'] = $this->usuarios_model->getByIdPermissao($permissao_IDGeral);
        $this->data['arrpermissoesUSER'] = $this->usuarios_model->getByIdPermissao($this->session->userdata('permissao')); 
        
        // var_dump($this->data['arrpermissoes']); echo '<br>';
        // var_dump($this->data['permissao_Geral']); echo '<br>';
        // var_dump($this->data['arrpermissoesUSER']); 
        // die();
        // var_dump($this->data['permissao_Geral']); 
        // die();
        $this->load->model('permissoes_model');
        $this->data['permissoesID'] = $this->permissoes_model->getActive('permissoes','permissoes.idPermissao,permissoes.nome'); 
        $this->data['result_caixas'] = $this->usuarios_model->get2('caixas');
        $this->data['tiposPermissoes'] = $this->usuarios_model->get3('permissoes_tipos', 'tipo', 'id');

		$this->data['view'] = 'usuarios/editarUsuario';
        $this->load->view('tema/topo',$this->data);
			
      
    }
	
    public function excluir(){

            $ID =  $this->uri->segment(3);
            $this->usuarios_model->delete('usuarios','idUsuarios',$ID);             
            redirect(base_url().'index.php/usuarios/gerenciar/');
    }
}

