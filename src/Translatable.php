<?php

namespace Mmidu\Translatable;

use Illuminate\Support\Facades\Session;


/**
 * Trait Translatable
 * @package App\Traits
 *
 * Returns automatically the attribute in the chosen locale for $translatable attributes.
 * Adds virtual attributes "multilingual_attribute" and "multilingual_attribute_str" which
 * return respectively the full multilingual array, and the full multilingual array with
 * an empty string instead of an empty array in case the array is empty.
 */
trait Translatable
{
    /**
     * Returns a model attribute.
     * @param $key
     * @return mixed
     */
    public function getAttribute($key){
        if(isset($this->translatable)){
            if(in_array($key, $this->translatable)){
                return $this->getTranslatedAttribute($key);
            }

            if(preg_match('/multilingual_/', $key)){
                $keys = explode('_', $key);
                if(in_array($keys[1], $this->translatable)){
                    return $this->getMultilingualAttribute($keys[1], (isset($keys[2]) && $keys[2] == 'str'));
                }
            }
        }
        return parent::getAttribute($key);
    }

    public function getMultilingualAttribute(string $key, bool $stringifyOnEmpty=false){
        if(isset($this->translatable) && in_array($key, $this->translatable)) {
            $attribute = json_decode($this->getAttributes()[$key], true);
            return $stringifyOnEmpty ? (!empty($attribute) ? $attribute : "") : $attribute;
        }
        return parent::getAttribute($key);
    }

    /**
     * Returns a translatable model attribute based on the app's locale settings.
     * @param $key
     * @return string|null
     */
    protected function getTranslatedAttribute($key){
        $values = $this->getAttributeValue($key);
        $locale = App::getLocale();

        if(!$values){
            return null;
        }

        if(isset($locale) && isset($values[$locale])){
            return $values[$locale];
        } else {
            $languages = config('translatable.languages');
            unset($languages[array_search($locale, $languages)]);
            foreach($languages as $locale => $name){
                if(isset($values[$locale])){
                    return $values[$locale];
                }
            }

            return reset($values);
        }
    }

    /**
     * Determine if the attribute has to be casted as JSON when it is being set.
     * If it is a translatable field, it should be casted to JSON.
     * @param $key
     * @return bool
     */
    protected function isJsonCastable($key){
        if(isset($this->translatable) && in_array($key, $this->translatable)){
            return true;
        }
        return parent::isJsonCastable($key);
    }

}
