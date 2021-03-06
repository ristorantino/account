<?php

App::uses('AccountAppController', 'Account.Controller');


class ProveedoresController extends AccountAppController {

	public $name = 'Proveedores';

    public $uses = array('Account.Proveedor');
       
	public function index () {
		$this->Proveedor->recursive = 0;                
        if ( !empty($this->request->data['Proveedor']['buscar_proveedor'])) {
            $this->Paginator->settings['conditions']['or']['UPPER(Proveedor.name) LIKE'] = "%".strtoupper($this->request->data['Proveedor']['buscar_proveedor'])."%";
            $this->Paginator->settings['conditions']['or']['Proveedor.cuit LIKE'] = "%".$this->request->data['Proveedor']['buscar_proveedor']."%";
        }

        $this->Paginator->settings['contain'] = array('Rubro');

        if ($this->request->is('ajax')) {
            $this->Paginator->settings['limit'] = 999;
        }
		$this->set('proveedores', $this->paginate());
	}

	public function view($id = null) {
		$this->uses[] = 'Compras.PedidoMercaderia';
		if (!$id) {
			$this->Session->setFlash(__('Invalid Proveedor'));
			$this->redirect($this->referer());
		}
		$proveedor = $this->Proveedor->buscarProveedorPorId($id);

        $conds = array(
            'Pedido.Proveedor_id' => $id
            );

        $this->Paginator->settings['PedidoMercaderia'] = array(
            'order'  => array(
                'PedidoMercaderia.created' => 'DESC',
                ),
            'contain' => array(
                'Pedido'=>array(
                	'User', 
                	),
                'Mercaderia' => array(
                	'Rubro',

                	),
                'UnidadDeMedida'
                ),
            'conditions' => $conds,
        );

        $pedidos = $this->Paginator->paginate('PedidoMercaderia');

		$this->set(compact('proveedor', 'pedidos', 'mercaderia'));
	}

	public function add() {
		if ($this->request->is(array('post', 'put')) && !empty($this->request->data)) {
			$this->Proveedor->create();
			if ($this->Proveedor->save($this->request->data)) {
				$this->Session->setFlash(__('The Proveedor has been saved'));
                unset($this->request->data);
			} else {
				$this->Session->setFlash(__('The Proveedor could not be saved. Please, try again.'));
			}
			$this->redirect($this->referer());
		}
		$rubros = $this->Proveedor->Rubro->find('list');
		$tipoImpuestos = $this->Proveedor->TipoImpuesto->find('list');
		$this->set(compact('rubros', 'tipoImpuestos'));
		$this->render('form');
	}

	public function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Proveedor'), 'Risto.flash_error');
			$this->redirect(array('action' => 'index'));
		}
		if ( $this->request->is('put') || $this->request->is('post') ) {
			if ($this->Proveedor->save($this->request->data)) {
				$this->Session->setFlash(__('The Proveedor has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Proveedor could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Proveedor->read(null, $id);
		}

		$tipoImpuestos = $this->Proveedor->TipoImpuesto->find('list');
		$rubros = $this->Proveedor->Rubro->find('list');
		$this->set(compact('rubros', 'tipoImpuestos'));
		$this->render('form');
	}

	public function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Proveedor'));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->Proveedor->delete($id)) {
			$this->Session->setFlash(__('Proveedor deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('The Proveedor could not be deleted. Please, try again.'));
		$this->redirect(array('action' => 'index'));
	}

}
