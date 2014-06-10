<?php
namespace Usuario\Model;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;

class UsuarioTable
{

    protected $tableGateway;

    const ATIVO = 1;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $select = new Select();
		$select->from('tb_usuario')
		->columns(array('*'))
		->where( array( 'ativo' => UsuarioTable::ATIVO ) );

		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet;
    }

    public function getUsuario($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array(
            'id' => $id
        ));
        $row = $rowset->current();
        if (! $row) {
            throw new \Exception("Não existe linha no banco para este id $id");
        }
        return $row;
    }
    
    public function getUsuarioIdentidade($login)
    {
        $select = new Select();
        $select->from('tb_usuario')
        ->columns(array( 'id', 'nome', 'id_perfil' ))
        ->where( array('ativo' => UsuarioTable::ATIVO) )
        ->where( array( 'login' => $login ) );
        
        $rowset = $this->tableGateway->selectWith($select);
        $row    = $rowset->current();
        return $row;
    }

    public function salvarUsuario(Usuario $usuario)
    {
        $data = array(
            'nome' => $usuario->nome,
            'email' => $usuario->email,
            'login' => $usuario->login,
            'id_perfil' => $usuario->perfil->id,
            'ativo' => UsuarioTable::ATIVO
        );
        
        $id = (int) $usuario->id;
        
        if ($id == 0) {
            $data = $data + array('senha' => md5($usuario->senha));
            $this->tableGateway->insert($data);
        } else {
            if ($this->getUsuario($id)) {
                $this->tableGateway->update($data, array(
                    'id' => $id
                ));
            } else {
                throw new \Exception('Não existe registro com esse ID' . $id);
            }
        }
    }

    public function deletarUsuario($id)
    {
        $data = array( "ativo" => 0 );
        
        $this->tableGateway->update($data, array(
            'id' => $id
        ));
    }
}