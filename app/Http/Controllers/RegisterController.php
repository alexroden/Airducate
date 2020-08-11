<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Token        $token
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Token $token)
    {
        return View::make('register')
            ->withQuestions(Group::ONBOARD_QUESTION_MAPPING)
            ->withUserToken(Token::validateToken($token->token)[0]);
    }
}
