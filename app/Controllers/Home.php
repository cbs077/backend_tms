<?php

namespace App\Controllers;
use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Files\File;

class Home extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        log_message('info', 'Some variable did not contain a value.');
        log_message('error','ok'); 
        #return view('welcome_message');
        return view('frontend/index.html');
    }

    public function signup()
    {
        log_message('info','signup'); 
        helper(['form']);
        $rules = [
            'user_id'          => 'required|min_length[2]|max_length[50]',
            //'email'         => 'required|min_length[4]|max_length[100]|valid_email|is_unique[users.email]',
            'password'      => 'required|min_length[4]|max_length[50]',
            //'confirmpassword'  => 'matches[password]'
        ];
          
        if($this->validate($rules)){
            $userModel = new UserModel();

            $data = [
                'USER_ID'     => $this->request->getVar('user_id'),
                'PWD' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
            ];

            $userModel->save($data);
            log_message('info','signup_success'); 
            //return redirect()->to('/signin');
        }else{
            $data['validation'] = $this->validator;
            log_message('info','signup_fail'); 
            //echo view('signup', $data);
        }        
    }

    public function loginAuth()
    {
        $session = session();

        $userModel = new UserModel();

        $user_id = $this->request->getVar('user_id');

        $password = $this->request->getVar('password');

        log_message('info', $user_id); 
        
        $data = $userModel->where('user_id', $user_id)->first();
        
        if($data){
            $pass = $data['PWD'];
            log_message('info', $password);
            log_message('info', $data['PWD']);
            //$password  = password_hash($password, PASSWORD_DEFAULT);
            //$hash = '$2y$07$BCryptRequires22Chrcte/VlQH0piJtjXl.0t1XkA8pw9dMXTpOq';

            $authenticatePassword = password_verify($password, $pass);
            log_message('info', $authenticatePassword);
            if($authenticatePassword){
                $ses_data = [
                    'id' => $data['USER_ID'],
                    'name' => $data['PWD'],
                    'isLoggedIn' => TRUE
                ];

                $session->set($ses_data);
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'loginAuth successfully'
                    ]
                  ];
                return $this->respondCreated($response);
                //return redirect()->to('/profile');
            
            }else{
                $session->setFlashdata('msg', 'Password is incorrect.');
                //return redirect()->to('/signin');
                $response = [
                    'status'   => 405,
                    'error'    => null,
                    'messages' => [
                        'success' => 'loginAuth fail'
                    ]
                  ];
                return $this->respondCreated($response);
            }

        }else{
            log_message('info', "fail");
            $session->setFlashdata('msg', 'Email does not exist.');
            return redirect()->to('/signin');
        }
    }

    public function upload()
    {
        $validationRule = [
            'swfile' => 'uploaded[swfile]|max_size[swfile,1024]',
            // 'userfile' => [
            //     'label' => 'Image File',
            //     'rules' => 'uploaded[userfile]'
            //         //. '|is_image[userfile]'
            //         //. '|mime_in[userfile,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
            //           . '|max_size[userfile,1024]',
            //         //. '|max_dims[userfile,1024,768]',
            // ],
        ];
        //log_message('info', $validationRule);
        //$validationRule = 1;
        // if (! $this->validate($validationRule)) {
        //     $data = ['errors' => $this->validator->getErrors()];

        //     $response = [
        //     'status'   => 500,
        //     'error'    => null,
        //     'messages' => [
        //         'success' => 'upload fail',
        //         'data' => $data
        //     ]
        //     ];
        //     return $this->respond($response);
        //     //return view('upload_form', $data);
        // }

        $img = $this->request->getFile('swfile');

        if (! $img->hasMoved()) {
            $filepath = WRITEPATH . 'uploads/' . $img->store();
            log_message('info', $filepath);

            $data = ['uploaded_flleinfo' => new File($filepath)];

            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'upload success',
                    'data' => $data
                ]
            ];
            log_message('info', "upload success");
            return $this->respond($response);
        } else {
            $data = ['errors' => 'The file has already been moved.'];

            return view('upload_form', $data);
        }
    }    
}
