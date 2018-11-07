<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

use App\Extensions\Laravel\View\LayoutView;
use App\Models\EmailPersonalizado;

use Auth;
use Mail;
use Flash;
use App;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, LayoutView;

    protected $request;

    protected $versionAPI = 'v1';

    protected $email = 'info@factucare.com';
    protected $nameEmail = 'Factucare';

    protected $userFacturaAutomatica = 2;

    public function __construct(Request $request) {
        $this->request = $request;

        App::bind('DoctrineValidation', function($app) use ($request) {
            return new \App\Extensions\Doctrine\Validation\DoctrineValidation($request);
        });
    }

    protected function sendEmail($email, $nameEmail, $title, $template, $data = [], $attachs = []) {
        $user = Auth::user();
        if($user !== null){
        if($user->getCorreo_per()){
            Mail::send($template, $data, function($message) use ($email, $nameEmail, $title, $attachs) {  
                $id = Auth::user()->getId();
                $userEmail = EmailPersonalizado::findBy([ 'user' => $id]);
                foreach ($userEmail as $umail) {
                    $emailR = $umail->getEmail();
                    $nombreR = $umail->getNombre();   
                }
                $message->from($emailR , $nombreR);
                $message->subject($title);
                $message->to($email, $nameEmail);
                foreach ($attachs as $nameFile => $attach) {
                    $message->attachData($attach, $nameFile);
                }
            });
        }else{
            Mail::send($template, $data, function($message) use ($email, $nameEmail, $title, $attachs) {
                $message->from('info@factucare.com', 'FACTUCARE');
                $message->subject($title);
                $message->to($email, $nameEmail);
                foreach ($attachs as $nameFile => $attach) {
                   $message->attachData($attach, $nameFile);
                }
            });
        }
        }else{
            Mail::send($template, $data, function($message) use ($email, $nameEmail, $title, $attachs) {
                $message->from('info@factucare.com', 'FACTUCARE');
                $message->subject($title);
                $message->to($email, $nameEmail);
                foreach ($attachs as $nameFile => $attach) {
                   $message->attachData($attach, $nameFile);
                }
            });   
        }
    }


    public function sendEmailApi($email, $nameEmail, $title, $template, $data =[], $attachs = [], $user ){
        if($user->getCorreo_per()){
            Mail::send($template, $data, function($message) use ($email, $nameEmail, $title, $attachs, $user) {  
                $id = $user->getId();
                $userEmail = EmailPersonalizado::findBy([ 'user' => $id]);
                foreach ($userEmail as $umail) {
                    $emailR = $umail->getEmail();
                    $nombreR = $umail->getNombre();   
                }
                $message->from($emailR , $nombreR);
                $message->subject($title);
                $message->to($email, $nameEmail);
                foreach ($attachs as $nameFile => $attach) {
                    $message->attachData($attach, $nameFile);
                }
            });
        }else{
            Mail::send($template, $data, function($message) use ($email, $nameEmail, $title, $attachs) {
                $message->from('info@factucare.com', 'FACTUCARE');
                $message->subject($title);
                $message->to($email, $nameEmail);
                foreach ($attachs as $nameFile => $attach) {
                   $message->attachData($attach, $nameFile);
                }
            });
        }
    }

}
