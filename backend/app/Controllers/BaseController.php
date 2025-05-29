<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\Task;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = service('session');
    }

    public function index()
    {
        $model = new Task();
        $data['tasks'] = $model->findAll();
        return view('tasks/index', $data);
    }

    public function create()
    {
        return view('tasks/create');
    }

    public function store()
    {
        $model = new Task();
        $model->save([
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
        ]);
        return redirect()->to('/task');
    }

    public function edit($id)
    {
        $model = new Task();
        $data['task'] = $model->find($id);
        return view('tasks/edit', $data);
    }

    public function update($id)
    {
        $model = new Task();
        $model->update($id, [
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
        ]);
        return redirect()->to('/task');
    }

    public function delete($id)
    {
        $model = new Task();
        $model->delete($id);
        return redirect()->to('/task');
    }
}
