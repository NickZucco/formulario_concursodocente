<?php

namespace App;

use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use App\Notifications\ConfirmEmail;

class ActivationService {

    protected $mailer;
    protected $activationRepo;
    protected $resendAfter = 24;

    public function __construct(Mailer $mailer, ActivationRepository $activationRepo) {
        $this->mailer = $mailer;
        $this->activationRepo = $activationRepo;
    }

    public function sendActivationMail($user) {

        if ($user->activated || !$this->shouldSend($user)) {
            return;
        }

        $token = $this->activationRepo->createActivation($user);

        //$link = route('user.activate', $token);                               //Esta forma de armar el enlace de autenticación no sirve (?)
        $link= env("APP_URL")."user/activation/$token";

        $title = 'Activación de cuenta - '.env("APP_NAME");
        $content = sprintf('<p>Estimado aspirante:</p><p>Por favor, de clic en el siguiente enlace para activar su cuenta <a href="%s">Enlace de activación</a></p>', $link, $link);
        
        $this->mailer->send('emails.activation', ['html' => 'view','title' => $title, 'content' => $content], function ($message) use ($user)
        {
            $message->subject('Activación de cuenta - '.env("APP_NAME"));
            $message->from(env("MAIL_USERNAME"),'Activación de cuenta - '.env("APP_NAME"));
            $message->to($user->email);
            

        });
    }

    public function activateUser($token) {
        $activation = $this->activationRepo->getActivationByToken($token);
        
        if ($activation === null) {
            return null;
        }

        $user = User::find($activation->user_id);
        
        $user->activated = true;

        $user->save();

        $this->activationRepo->deleteActivation($token);

        return $user;
    }

    private function shouldSend($user) {
        $activation = $this->activationRepo->getActivation($user);
        return $activation === null || strtotime($activation->created_at) + 60 * 60 * $this->resendAfter < time();
    }

}
