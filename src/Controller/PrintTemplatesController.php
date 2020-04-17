<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * PrintTemplates Controller
 *
 * @property \App\Model\Table\PrintTemplatesTable $PrintTemplates
 *
 * @method \App\Model\Entity\PrintTemplate[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PrintTemplatesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ParentPrintTemplates'],
            'order' => ['lft' => 'ASC'],
        ];
        $printTemplates = $this->paginate($this->PrintTemplates);

        $this->set(compact('printTemplates'));
    }

    /**
     * View method
     *
     * @param  string|null                                        $id Print Template id.
     * @return \Cake\Http\Response|null|void                      Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $printTemplate = $this->PrintTemplates->get($id, [
            'contain' => ['ParentPrintTemplates', 'Items', 'ChildPrintTemplates'],
        ]);

        $this->set('printTemplate', $printTemplate);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $printTemplate = $this->PrintTemplates->newEmptyEntity();
        if ($this->request->is('post')) {
            $printTemplate = $this->PrintTemplates->patchEntity($printTemplate, $this->request->getData());

            if (!$printTemplate->getErrors()) {
                $targetPath = WWW_ROOT . DS . $this->PrintTemplates->getSetting('GLABELS_ROOT');

                $image = $this->request->getData('upload_example_image');

                if ($image) {
                    $example_image_name = $image->getClientFilename();
                    $example_image_type = $image->getClientMediaType();
                    $example_image_size = $image->getSize();
                    $image->moveTo($targetPath . DS . $example_image_name);
                    $printTemplate->example_image = $example_image_name;
                    $printTemplate->example_image_type = $example_image_type;
                    $printTemplate->example_image_size = $example_image_size;
                }

                $file_template = $this->request->getData('upload_file_template');
                if ($file_template) {
                    $file_template_name = $file_template->getClientFilename();
                    $file_template_type = $file_template->getClientMediaType();
                    $file_template_size = $file_template->getSize();
                    $file_template->moveTo($targetPath . DS . $file_template_name);
                    $printTemplate->file_template = $file_template_name;
                    $printTemplate->file_template_type = $file_template_type;
                    $printTemplate->file_template_size = $file_template_size;
                }
            }
            if ($this->PrintTemplates->save($printTemplate)) {
                $this->Flash->success(__('The print template has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The print template could not be saved. Please, try again.'));
        }
        $parentPrintTemplates = $this->PrintTemplates->ParentPrintTemplates->find('list', ['limit' => 200]);

        $controllerActions = $this->Ctrl->getPrintActions();
        $this->set(compact('printTemplate', 'parentPrintTemplates', 'controllerActions'));
    }

    /**
     * Edit method
     *
     * @param  string|null                                        $id Print Template id.
     * @return \Cake\Http\Response|null|void                      Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $printTemplate = $this->PrintTemplates->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $printTemplate = $this->PrintTemplates->patchEntity($printTemplate, $this->request->getData());

            if (!$printTemplate->getErrors()) {
                $targetPath = WWW_ROOT . DS . $this->PrintTemplates->getSetting('GLABELS_ROOT');

                $image = $this->request->getData('upload_example_image');

                if ($image->getError() === UPLOAD_ERR_OK) {
                    $example_image_name = $image->getClientFilename();
                    $example_image_type = $image->getClientMediaType();
                    $example_image_size = $image->getSize();
                    $image->moveTo($targetPath . DS . $example_image_name);
                    $printTemplate->example_image = $example_image_name;
                    $printTemplate->example_image_type = $example_image_type;
                    $printTemplate->example_image_size = $example_image_size;
                }

                $file_template = $this->request->getData('upload_file_template');

                if ($file_template->getError() === UPLOAD_ERR_OK) {
                    $file_template_name = $file_template->getClientFilename();
                    $file_template_type = $file_template->getClientMediaType();
                    $file_template_size = $file_template->getSize();
                    $file_template->moveTo($targetPath . DS . $file_template_name);
                    $printTemplate->file_template = $file_template_name;
                    $printTemplate->file_template_type = $file_template_type;
                    $printTemplate->file_template_size = $file_template_size;
                }
            }

            if ($this->PrintTemplates->save($printTemplate)) {
                $this->Flash->success(__('The print template has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The print template could not be saved. Please, try again.'));
        }

        $controllerActions = $this->Ctrl->getPrintActions();
        $templateRoot = DS . $this->PrintTemplates->getSetting('GLABELS_ROOT') . DS;
        $parentPrintTemplates = $this->PrintTemplates->ParentPrintTemplates->find('list', ['limit' => 200]);
        $this->set(compact('printTemplate', 'parentPrintTemplates', 'controllerActions', 'templateRoot'));
    }

    /**
     * Delete method
     *
     * @param  string|null                                        $id Print Template id.
     * @return \Cake\Http\Response|null|void                      Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $printTemplate = $this->PrintTemplates->get($id);
        if ($this->PrintTemplates->delete($printTemplate)) {
            $this->Flash->success(__('The print template has been deleted.'));
        } else {
            $this->Flash->error(__('The print template could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * @param  int   $id    ID of menu
     * @param  int   $delta how much to move up or down
     * @return mixed
     */
    public function move($id = null, $delta = 1)
    {
        $this->request->allowMethod(['post', 'put']);

        $data = $this->request->getData();

        $menu = $this->PrintTemplates->get($id);

        if (is_numeric($data['amount'])) {
            $delta = $data['amount'];
        }

        $action = isset($data['moveUp']) ? 'moveUp' : 'moveDown';

        if ($this->PrintTemplates->$action($menu, abs($delta))) {
            $this->Flash->success($action . ' success!');
        } else {
            $this->Flash->error('The category could not be moved up. Please, try again.');
        }

        return $this->redirect($this->referer());
    }
}