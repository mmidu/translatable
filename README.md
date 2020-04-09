# translatable
Automatic translation of json multilingual fields for Laravel.

usage:

1) publish the config through php artisan vendor:publish --config.
2) use the Translatable trait to the model you want to use it for.
3) set the languages config in the config/translatable.php file, you can add and remove locales.
4) the locale used for the translation has to be put in the session.
5) add the translatable fields in the model's translatable attribute like this
      
      protected $translatable = [
        'name', 'description'
      ];
      
6) the translatable fields must be JSON with the following structure:
  
      {
        "it": "nome",
        "en": "name",
        "es": "nombre"
         etc...
      }

7) access the right locale version through $model->attribute automatically.

      es.
      Session::put('locale', 'es');
      echo $model->name;
      
      result = 'nombre'
      
8) Translatable adds two virtual attributes, multilingual_attribute and mulitilingual_attribute_str which give the multilingual version of the translatable attributes in array version. multilingual_attribute gives [] if there are no values, multilingual_attribute_str gives an empty string.

9) Enjoy!
