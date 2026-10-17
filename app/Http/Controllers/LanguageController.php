<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    /**
     * Change the application language
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeLanguage(Request $request)
    {
        $language = $request->input('language');

        // List of supported languages
        $supportedLanguages = [
            'en', 'es', 'fr', 'de', 'it', 'pt', 'ru', 'zh', 'ja', 'ko',
            'ar', 'hi', 'th', 'vi', 'nl', 'sv', 'da', 'no', 'fi', 'pl',
            'cs', 'hu', 'ro', 'bg', 'hr', 'sk', 'sl', 'et', 'lv', 'lt',
            'mt', 'ga', 'cy', 'is'
        ];

        // Validate the language code
        if (in_array($language, $supportedLanguages)) {
            // Store language preference in session
            Session::put('locale', $language);

            // Set application locale
            App::setLocale($language);

            return response()->json([
                'success' => true,
                'message' => 'Language changed successfully',
                'language' => $language
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Unsupported language'
        ], 400);
    }

    /**
     * Switch language via GET request (for direct navigation)
     *
     * @param string $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switchLanguage($locale)
    {
        // List of supported languages
        $supportedLanguages = [
            'en', 'es', 'fr', 'de', 'it', 'pt', 'ru', 'zh', 'ja', 'ko',
            'ar', 'hi', 'th', 'vi', 'nl', 'sv', 'da', 'no', 'fi', 'pl',
            'cs', 'hu', 'ro', 'bg', 'hr', 'sk', 'sl', 'et', 'lv', 'lt',
            'mt', 'ga', 'cy', 'is', 'tr', 'uk', 'he', 'id', 'ms', 'tl'
        ];

        // Validate the language code
        if (in_array($locale, $supportedLanguages)) {
            // Store language preference in session
            Session::put('locale', $locale);

            // Set application locale
            App::setLocale($locale);
        }

        return redirect()->back();
    }

    /**
     * Get current language
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCurrentLanguage()
    {
        $currentLocale = Session::get('locale', config('app.locale'));

        return response()->json([
            'current_language' => $currentLocale
        ]);
    }
}
