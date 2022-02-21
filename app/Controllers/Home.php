<?php

namespace App\Controllers;
use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Files\File;
use Firebase\JWT\JWT;

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
        }else{
            $data['validation'] = $this->validator;
            log_message('info','signup_fail'); 
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
            log_message('info', "PWD:".$data['PWD']);

            $authenticatePassword = password_verify($password, $pass);
            
            if($authenticatePassword){
                //세션
                // $ses_data = [
                //     'user_id' => $data['USER_ID'],
                //     'user_name' => $data['USER_NM'],
                //     'van_id' => $data['COMP_ID'],
                //     'isLoggedIn' => 'true'
                // ];
                // $res = ["user_id" => $data['USER_ID'], "van_id" => $data['COMP_ID']];

                
                // log_message('debug', json_encode($res)); 
                // log_message('debug', json_encode($ses_data)); 
                // $session->set($ses_data);


                $issuedAt = time();
                $expirationTime = $issuedAt + 6000;  // jwt valid for 60 seconds from the issued time
                $payload = array(
                    'userid' => "test",
                    'iat' => $issuedAt,
                    'exp' => $expirationTime
                );
                $key = "cskhfuwt48wbfjn3i4utnjf38754hf3yfbjc93758thrjsnf83hcwn8437";
                $alg = 'HS256';
                $token = JWT::encode($payload, $key, $alg);
             
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'loginAuth successfully',
                        'token' => $token
                    ]
                  ];
                return $this->respondCreated($response);            
            }else{
                $session->setFlashdata('msg', 'Password is incorrect.');
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

    public function logout()
    {
        $session = session();
        $ses_data = [
            'isLoggedIn' => 'false'
        ];
        $session->set($ses_data);
        log_message('info', "logout");
        // $session->remove('id');
        // $session->remove('name');
        // $session->remove('name');

        $val = $session->get('isLoggedIn');
        log_message('info', "logout.session:".$val); 

        $response = [
            'status'   => 405,
            'error'    => null,
            'messages' => [
                'success' => 'logout'
            ]
          ];
        return $this->respondCreated($response);
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
