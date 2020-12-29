<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\UserRequest;
use Validator;
use App\User;
use App\employe;
use DB;
class homeController extends Controller
{

    function index(Request $req){
        /*$data = ['id'=> 123, 'name'=> 'alamin'];
        return view('home.index', $data);*/

        /*return view('home.index')
                ->with('id', '1234')
                ->with('name', 'xyz');*/

        /*return view('home.index')
                ->withId('1234')
                ->withName('xyz');*/

/*      $v = view('home.index');
        $v->withId('123');
        $v->withName('alamin');
        return $v;*/

        $id = $req->session()->get('password');
       // print_r($id);
        $name = $req->session()->get('username');
        return view('home.index', compact('id', 'name'));
        
    }

    public function create(){
        return view('home.create');
    }

    public function store(UserRequest $req){
        
       /* $validation = Validator::make($req->all(), [
            'name' => 'required|min:3',
            'email'=> 'required',
            'cgpa' => 'required'
        ]);
        if($validation->fails()){
            return redirect()
                    ->route('home.create')
                    ->with('errors', $validation->errors())
                    ->withInput();
            return back()
                    ->with('errors', $validation->errors())
                    ->withInput();
        }*/


       /* $this->validate($req, [
            'name' => 'required|min:3',
            'email'=> 'required',
            'cgpa' => 'required'
        ])->validate();*/


        /*$req->validate([
            'name' => 'required|min:3',
            'email'=> 'required',
            'cgpa' => 'required'
        ])->validate();*/
  
            //$user=new User();
            $user = new employe();
                $user->emname     = $req->ename;
                $user->comname     = $req->cname;
                $user->contactno         = $req->cno;
                $user->username         = $req->username;
                $user->password         = $req->password;

                if($user->save()){
                    return redirect()->route('home.userlist');
                }
                else{
                    return back();
                }
    }

    public function userlist(){
        $user  = employe::all();
        return view('home.userlist')->with('users', $user);
    }

     public function userlist2(){
        $user  = employe::all();
        return view('home.userlist2')->with('users', $user);
    }

    public function show($id){
        //$user = $id
        //return view('home.show')->with('user', $user);
    }

    public function edit($id){
         $user = employe::find($id);      
        return view('home.edit', $user);
    }

    public function update($id,Request $req){
       $user = employe::find($id);
                $user->emname     = $req->emname;
                $user->comname    = $req->comname;
                $user->contactno  = $req->contactno;
                $user->username   = $req->username;
                $user->password    = $req->password;
                $user->save();

                    return redirect()->route('home.userlist2');
    }

    public function destroy($id){
        employe::destroy($id);
        return redirect()->route('home.userlist2');
    }
    public function notice(){
        $res=Http::get('http://localhost:3000/home/admin');
        //print_r($res->body());
         return view('home.notice')->with('users', $res->body());
    }
    public function search(Request $request){
        if($request->ajax())
     {
      $output = '';
      $query = $request->get('query');
      if($query != '')
      {
       $data = DB::table('employes')
         ->where('userid', 'like', '%'.$query.'%')
         ->orWhere('emname', 'like', '%'.$query.'%')
         ->orWhere('comname', 'like', '%'.$query.'%')
         ->orWhere('contactno', 'like', '%'.$query.'%')
         ->orWhere('username', 'like', '%'.$query.'%')
         ->orWhere('password', 'like', '%'.$query.'%')
         ->orderBy('userid', 'desc')
         ->get();
         
      }
      else
      {
       $data = DB::table('employes')
         ->orderBy('userid', 'desc')
         ->get();
      }
      $total_row = $data->count();
      if($total_row > 0)
      {
       foreach($data as $row)
       {
        $output .= '
        <tr>
         <td>'.$row->userid.'</td>
         <td>'.$row->emname.'</td>
         <td>'.$row->comname.'</td>
         <td>'.$row->contactno.'</td>
         <td>'.$row->username.'</td>
         <td>'.$row->password.'</td>
        </tr>
        ';
       }
      }
      else
      {
       $output = '
       <tr>
        <td align="center" colspan="5">No Data Found</td>
       </tr>
       ';
      }
      $data = array(
       'table_data'  => $output,
       'total_data'  => $total_row
      );

      echo json_encode($data);
     }
    }


    private function getUserlist(){
        return [
            ['id'=> 1, 'name'=>'xyz', 'email'=>'xyz@aiub.edu', 'cgpa'=>4],
            ['id'=> 2, 'name'=>'abc', 'email'=>'abc@aiub.edu', 'cgpa'=>3],
            ['id'=> 3, 'name'=>'asd', 'email'=>'asd@aiub.edu', 'cgpa'=>3.5],
            ['id'=> 4, 'name'=>'pqr', 'email'=>'pqr@aiub.edu', 'cgpa'=>2.4],
            ['id'=> 5, 'name'=>'alamin', 'email'=>'alamin@aiub.edu', 'cgpa'=>1.2]
        ];
    }
}