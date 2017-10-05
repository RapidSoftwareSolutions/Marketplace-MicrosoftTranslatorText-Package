[![](https://scdn.rapidapi.com/RapidAPI_banner.png)](https://rapidapi.com/package/MicrosoftTranslatorText/functions?utm_source=RapidAPIGitHub_MicrosoftTranslatorTextFunctions&utm_medium=button&utm_content=RapidAPI_GitHub)

# MicrosoftTranslatorText Package
Microsoft Translator APIs can be seamlessly integrated into your applications, websites, tools, or other solutions to provide multi-language user experiences. Leveraging industry standards, it can be used on any hardware platform and with any operating system to perform language translation and other language-related operations such as text language detection or text to speech.
* Domain: [microsofttranslator.com](http:\/\/microsofttranslator.com)
* Credentials: apiKey

## How to get credentials: 
0. Sign up for a Microsoft Azure account at [azure.com](http:\/\/azure.com)
1. After you have an account go to [portal.azure.com](http:\/\/portal.azure.com)
2. Select the + New option.
3. Select AI + Cognitive Services from the list of services
4. Select Translator Text API. You may need to click `See all` or search to see it
5. Fill out the rest of the form, and select the Create button
6. You are now subscribed to Microsoft Translator Text API
7. Go to All Resources and select the Microsoft Translator API you subscribed to
8. Go to the Keys option and copy your subscription key to access the service
 
  ## Custom datatypes: 
   |Datatype|Description|Example
   |--------|-----------|----------
   |Datepicker|String which includes date and time|```2016-05-28 00:00:00```
   |Map|String which includes latitude and longitude coma separated|```50.37, 26.56```
   |List|Simple array|```["123", "sample"]``` 
   |Select|String with predefined values|```sample```
   |Array|Array of objects|```[{"Second name":"123","Age":"12","Photo":"sdf","Draft":"sdfsdf"},{"name":"adi","Second name":"bla","Age":"4","Photo":"asfserwe","Draft":"sdfsdf"}] ``` 
 
## MicrosoftTranslatorText.getTranslate
Translates a text string from one language to another.If you previously used AddTranslation or AddTranslationArray to enter a translation with a rating of 5 or higher for the same source sentence, Translate returns only the top choice that is available to your system. The `same source sentence` means the exact same (100% matching), except for capitalization, white space, tag values, and punctuation at the end of a sentence. If no rating is stored with a rating of 5 or above then the returned result will be the automatic translation by Microsoft Translator.

| Field      | Type       | Description
|------------|------------|----------
| apiKey     | credentials| Your API Key.
| text       | String     | A string representing the text to translate. The size of the text must not exceed 10000 characters.
| to         | String     | A string representing the language code to translate the text into.
| from       | String     | A string representing the language code of the translation text. For example, `en` for English.
| category   | String     | A string containing the category (domain) of the translation. Defaults to `general`.

## MicrosoftTranslatorText.getLanguagesForTranslate
Obtain a list of language codes representing languages that are supported by the Translation Service.  Translate and TranslateArray can translate between any two of these languages.

| Field | Type       | Description
|-------|------------|----------
| apiKey| credentials| Your API Key.

## MicrosoftTranslatorText.getLanguagesForSpeak
Retrieves the languages available for speech synthesis.

| Field | Type       | Description
|-------|------------|----------
| apiKey| credentials| Your API Key.

## MicrosoftTranslatorText.getSpeak
Returns a wave or mp3 stream of the passed-in text being spoken in the desired language.

| Field      | Type       | Description
|------------|------------|----------
| apiKey     | credentials| Your API Key.
| text       | String     | A string containing a sentence or sentences of the specified language to be spoken for the wave stream. The size of the text to speak must not exceed 2000 characters.
| language   | String     | A string representing the supported language code to speak the text in. The code must be present in the list of codes returned from the method  GetLanguagesForSpeak.
| format     | Select     | A string specifying the content-type ID. Currently,  audio/wav and audio/mp3 are available. The default value is audio/wav.
| quality    | Select     | MaxQuality and MinSize are available to specify the quality of the audio signals. With MaxQuality, you can get voices with the highest quality, and with MinSize, you can get the voices with the smallest size. Default is  MinSize.
| voice      | Select     | female and male are available to specify the desired gender of the voice. Default is female.

## MicrosoftTranslatorText.detectLanguage
Use the Detect method to identify the language of a selected piece of text.

| Field | Type       | Description
|-------|------------|----------
| apiKey| credentials| Your API Key.
| text  | String     | A string containing some text whose language is to be identified. The size of the text must not exceed 10000 characters.

## MicrosoftTranslatorText.addTranslation
Adds a translation to the translation memory.

| Field         | Type       | Description
|---------------|------------|----------
| apiKey        | credentials| Your API Key.
| originalText  | String     | A string containing the text to translate from. The string has a maximum length of 1000 characters.
| translatedText| String     | A string containing translated text in the target language. The string has a maximum length of 2000 characters.
| from          | String     | A string representing the language code of the translation text. en = english, de = german etc.
| to            | String     | A string representing the language code to translate the text into.
| rating        | Number     | An integer representing the quality rating for this string. Value between -10 and 10. Defaults to 1.
| category      | String     | A string containing the category (domain) of the translation. Defaults to `general`.
| user          | String     | A string used to track the originator of the submission.
| uri           | String     | A string containing the content location of this translation.

## MicrosoftTranslatorText.getBreakSentences
Breaks a piece of text into sentences and returns an array containing the lengths in each sentence

| Field   | Type       | Description
|---------|------------|----------
| apiKey  | credentials| Your API Key.
| text    | String     | A string representing the text to split into sentences. The size of the text must not exceed 10000 characters.
| language| String     | A string representing the language code of input text.

## MicrosoftTranslatorText.addTranslateArray
Use this method to retrieve translations for multiple source texts.

| Field          | Type       | Description
|----------------|------------|----------
| apiKey         | credentials| Your API Key.
| from           | String     | A string representing the language code to translate the text from. If left empty the response will include the result of language auto-detection.
| category       | String     | A string containing the category (domain) of the translation. Defaults to general.
| profanityAction| Select     | Specifies how profanities are handled as explained above. Accepted values of ProfanityAction are NoAction (default), Marked and Deleted.
| state          | String     | User state to help correlate request and response. The same contents will be returned in the response.
| uri            | String     | Filter results by this URI. Default: all.
| user           | String     | Filter results by this user. Default: all.
| texts          | List       | An array containing the texts for translation. All strings must be of the same language. The total of all texts to be translated must not exceed 10000 characters. The maximum number of array elements is 2000.
| to             | String     | A string representing the language code to translate the text into.

## MicrosoftTranslatorText.getLanguageNames
Retrieves friendly names for the languages passed in as the parameter languageCodes, and localized using the passed locale language.

| Field        | Type       | Description
|--------------|------------|----------
| apiKey       | credentials| Your API Key.
| locale       | String     | A string representing a combination of an ISO 639 two-letter lowercase culture code associated with a language and an ISO 3166 two-letter uppercase subculture code to localize the language names or a ISO 639 lowercase culture code by itself.
| languageCodes| List       | This field includes a list representing the ISO 639-1 language codes to retrieve the friendly names for.

## MicrosoftTranslatorText.detectLanguageList
Use this method to identify the language of an list of string at once. Performs independent detection of each individual array element and returns a result for each row of the array.

| Field   | Type       | Description
|---------|------------|----------
| apiKey  | credentials| Your API Key.
| textList| List       | The size of the text must not exceed 10000 characters.

## MicrosoftTranslatorText.addTranslationArray
Adds an array of translations to add translation memory. This is an array version of AddTranslation.

| Field       | Type       | Description
|-------------|------------|----------
| apiKey      | credentials| Your API Key.
| from        | String     | A string containing the language code of the source language. Must be one of the languages returned by theGetLanguagesForTranslate method.
| category    | String     | A string containing the category (domain) of the translation. Defaults to `general`.
| user        | String     | A string used to track the originator of the submission.
| uri         | String     | A string containing the content location of this translation.
| to          | String     |  A string containing the language code of the target language. Must be one of the languages returned by the GetLanguagesForTranslate method.
| translations| Array      | An array of translations to add to translation memory.The size of each originalText and translatedText is limited to 1000 chars. The total of all the originalText(s) and translatedText(s) must not exceed 10000 characters. The maximum number of array elements is 100.
| translations.OriginalText| String      | A string containing the text to translate from. The string has a maximum length of 1000 characters.
| translations.Rating| Number    | An integer representing the quality rating for this string. Value between -10 and 10. Defaults to 1.
| translations.TranslatedText| String     | The translated text.

## MicrosoftTranslatorText.getTranslations
Retrieves an array of translations for a given language pair from the store and the MT engine. GetTranslations differs from Translate as it returns all available translations.

| Field                        | Type       | Description
|------------------------------|------------|----------
| apiKey                       | credentials| Your API Key.
| text                         | String     | A string representing the text to translate. The size of the text must not exceed 10000 characters.
| to                           | String     | A string representing the language code to translate the text into.
| from                         | String     | A string representing the language code of the translation text. For example, `en` for English.
| category                     | String     | A string containing the category (domain) of the translation. Defaults to `general`.
| maxTranslations              | Number     | An integer representing the maximum number of translations to return.
| state                        | String     | User state to help correlate request and response. The same contents will be returned in the response.
| user                         | String     | A string used to track the originator of the submission.
| uri                          | String     | A string containing the content location of this translation.
| includeMultipleMTAlternatives| Select     | Boolean flag to determine whether more than one alternatives should be returned from the MT engine. Valid values are true and false (case-sensitive). Default is false and includes only 1 alternative. Setting the flag to true allows for generating artificial alternatives in translation, fully integrated with the collaborative translations framework (CTF). The feature allows for returning alternatives for sentences that have no alternatives in CTF, by adding artificial alternatives from the n-best list of the decoder.`Ratings` The ratings are applied as follows: 1) The best automatic translation has a rating of 5. 2) The alternatives from CTF reflect the authority of the reviewer, from -10 to +10. 3) The automatically generated (n-best) translation alternatives have a rating of 0, and have a match degree of 100.`Number` of Alternatives The number of returned alternatives is up to maxTranslations, but may be less.`Language` pairs This functionality is not available for translations between Simplified and Traditional Chinese, both directions. It is available for all other Microsoft Translator supported language pairs.

## MicrosoftTranslatorText.getTranslationsArray
Use the GetTranslationsArray method to retrieve multiple translation candidates for multiple source texts.

| Field                        | Type       | Description
|------------------------------|------------|----------
| apiKey                       | credentials| Your API Key.
| from                         | String     | A string representing the language code to translate the text from. If left empty the response will include the result of language auto-detection.
| category                     | String     | A string containing the category (domain) of the translation. Defaults to general.
| profanityAction              | Select     | Specifies how profanities are handled as explained above. Accepted values of ProfanityAction are NoAction (default), Marked and Deleted.
| state                        | String     | User state to help correlate request and response. The same contents will be returned in the response.
| uri                          | String     | Filter results by this URI. Default: all.
| user                         | String     | Filter results by this user. Default: all.
| includeMultipleMTAlternatives| Select     | Boolean flag to determine whether more than one alternatives should be returned from the MT engine. Valid values are true and false (case-sensitive). Default is false and includes only 1 alternative. Setting the flag to true allows for generating artificial alternatives in translation, fully integrated with the collaborative translations framework (CTF). The feature allows for returning alternatives for sentences that have no alternatives in CTF, by adding artificial alternatives from the n-best list of the decoder.`Ratings` The ratings are applied as follows: 1) The best automatic translation has a rating of 5. 2) The alternatives from CTF reflect the authority of the reviewer, from -10 to +10. 3) The automatically generated (n-best) translation alternatives have a rating of 0, and have a match degree of 100.`Number` of Alternatives The number of returned alternatives is up to maxTranslations, but may be less.`Language` pairs This functionality is not available for translations between Simplified and Traditional Chinese, both directions. It is available for all other Microsoft Translator supported language pairs.
| maxTranslations              | Number     | An integer representing the maximum number of translations to return.
| texts                        | List       | An array containing the texts for translation. All strings must be of the same language. The total of all texts to be translated must not exceed 10000 characters. The maximum number of array elements is 2000.
| to                           | String     | A string representing the language code to translate the text into.

