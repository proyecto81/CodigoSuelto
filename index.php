        $distribuidor = $this->Distribuidores->newEntity();
        if ($this->request->is('post')) {
            $post_data = $this->request->data();
            $distribuidor = $this->Distribuidores->patchEntity($distribuidor, $post_data, [
                'associated' => ['Cuentas', 'Cuentas.Users']]);
            
            // Datos de Distribuidor
            $distribuidor->estado = 1;

            // Datos de Cuenta
            $distribuidor->cuenta = $this->Cuentas->newEntity();
            $distribuidor->cuenta->email = $post_data['email'];
            $distribuidor->cuenta->tipo_cuenta_id = 1;
            $distribuidor->cuenta->estado = 1;
            
            // Datos de User
            $user = $this->Users->newEntity();
            $user->tipo_user_id = $post_data['tipo_user'];
            $user->username = $post_data['email'];
            $user->email = $post_data['email'];
            $user->password = $post_data['clave_cuenta'];
            $distribuidor->cuenta->user = $user;
            
            $distribuidor->dirty('cuenta', true);
            //$distribuidor->cuenta->dirty('user', true);
            
            if ($this->Distribuidores->save($distribuidor)) {
                $this->Flash->success(__('El distribuidor fue creado con exito.'));
            } else {
                $this->Flash->error(__('El distribuidor no pudo ser creado. Por favor, inténtelo nuevamente.'));
            }
        }
