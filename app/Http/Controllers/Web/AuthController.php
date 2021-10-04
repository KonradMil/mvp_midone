<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Handlers\SocialAuthHandler;
use App\Models\User;
use App\Repository\Eloquent\UserRepository;
use App\Services\UserService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AuthController extends Controller
{

    protected array $allowedSocialProviders = ['facebook', 'google'];

    /**
     * @throws Exception
     */
    public function socialCallback(Request $request, UserRepository $userRepository, UserService $userService, string $provider = '')
    : View|Factory|Redirector|Application|\Illuminate\Http\RedirectResponse
    {
        if ($provider !== '' && in_array($provider, $this->allowedSocialProviders)) {

            if (session('social_registration')) {

                session()->remove('social_registration');

                $requestHandler = new SocialAuthHandler($request);
                $parameters = $requestHandler->getParameters();

                if(!$parameters->isValid()) {

                    foreach($parameters->getMessageBag() as $msg) {
                        foreach ($msg as $m) {
                            session()->flash('error', $m);
                        }
                    }

                    return redirect('https://facebook.com');

                }

                /** @var User $user */
                $user = $userService->addUser($parameters);

                Auth::login($user);
                return redirect('/login');

            } else {

                try {
                    $socialUser = Socialite::driver($provider)->user();
                } catch (Exception $e) {
                    return redirect('/login');
                }

                /** @var User|null $user */
                $user = $userRepository->findByEmail($socialUser->getEmail());

                if (!$user) {
                    session()->flash('info', __('messages.login.socialite.nonexistent_account'));
                    return redirect('/login');
                }

                if (!$user->hasVerifiedEmail()) {
                    session()->flash('info', __('messages.login.account_inactive'));
                    return redirect('/login');
                }

                if ($provider === 'google') {

                    if (!$user->google_id) {
                        $user->google_id = $socialUser->getId();
                        $user->save();
                    }

                    Auth::login($user);
                    return redirect('/login');
                }

                if ($provider === 'facebook') {

                    if (!$user->facebook_id) {
                        $user->facebook_id = $socialUser->getId();
                        $user->save();
                    }

                    Auth::login($user);
                    return redirect('/login');
                }

            }

        }

        return redirect('/login');
    }

    /**
     * @param string $provider
     * @return RedirectResponse
     */
    public function socialSignIn(string $provider): RedirectResponse
    {

        if (!in_array($provider, $this->allowedSocialProviders)) {
            abort(404);
        }

        return Socialite::driver($provider)->redirect();
    }

    public function socialSignUp(Request $request, string $provider)
    {

        if (!in_array($provider, $this->allowedSocialProviders)) {
            abort(404);
        }

        $sessionData = [
            'social_registration' => true,
            'privacyPolicyConsent' => $request->get('privacyPolicyConsent'),
            'serviceRulesConsent' => $request->get('serviceRulesConsent'),
            'pricingConsent' => $request->get('pricingConsent'),
            'accountType' => $request->get('accountType')
        ];

        session($sessionData);

        return Socialite::driver($provider)->redirect();

    }

}
