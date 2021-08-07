<?php

namespace App\Http\Composers;

use Illuminate\View\View;
use App\SaidTech\Repositories\ContactsRepository\ContactRepository;

class FooterComposer
{
    /**
     * The contacts repository implementation.
     *
     * @var ContactRepository
     */
    protected $contacts;

    /**
     * Create a new profile composer.
     *
     * @param  ContactRepository  $contacts
     * @return void
     */
    public function __construct(ContactRepository $contacts)
    {
        // Dependencies automatically resolved by service container...
        $this->contacts = $contacts;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $menu = [
            'social_accounts' => $this->contacts->all()->filter(function ($contact) {
                return in_array($contact->contact_type->name, ['facebook', 'twitter', 'instagram', 'linkedin', 'youtube']);
            })
        ];

        $view->with('menu', $menu);
    }
}
