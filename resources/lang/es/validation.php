<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'El campo :attribute debe ser aceptado.',
    'active_url'           => 'El campo :attribute no es un enlacea válido.',
    'after'                => 'El campo :attribute debe ser una fecha posterior a :date.',
    'alpha'                => 'El campo :attribute solo puede contener letras.',
    'alpha_dash'           => 'El campo :attribute solo puede contener letras, números o guines.',
    'alpha_num'            => 'El campo :attribute solo puede contener letras o números.',
    'array'                => 'El campo :attribute debe ser un arreglo.',
    'before'               => 'El campo :attribute debe ser una fecha inferior a :date.',
    'between'              => [
        'numeric' => 'El campo :attribute debe estar entre :min y :max.',
        'file'    => 'El archivo :attribute debe tener un tamaño entre :min y :max kilobytes.',
        'string'  => 'El campo :attribute debe tener entre :min and :max caracteres.',
        'array'   => 'El campo :attribute debe tener entre :min and :max items.',
    ],
    'boolean'              => 'El campo :attribute debe ser verdadero o false.',
    'confirmed'            => 'El campo :attribute no coincide con el valor de confirmación.',
    'date'                 => 'El campo :attribute no es una fecha válida.',
    'date_format'          => 'El campo :attribute no coincide con el formato :format.',
    'different'            => 'El campo :attribute y :other deben tener valores distintos.',
    'digits'               => 'El campo :attribute must be :digits digits.',
    'digits_between'       => 'El campo :attribute must be between :min and :max digits.',
    'dimensions'           => 'El campo :attribute has invalid image dimensions.',
    'distinct'             => 'El campo :attribute field has a duplicate value.',
    'email'                => 'El campo :attribute must be a valid email address.',
    'exists'               => 'El campo selected :attribute is invalid.',
    'file'                 => 'El campo :attribute must be a file.',
    'filled'               => 'El campo :attribute es requerido.',
    'image'                => 'El campo :attribute must be an image.',
    'in'                   => 'El campo selected :attribute is invalid.',
    'in_array'             => 'El campo :attribute field does not exist in :other.',
    'integer'              => 'El campo :attribute must be an integer.',
    'ip'                   => 'El campo :attribute must be a valid IP address.',
    'json'                 => 'El campo :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => 'El campo :attribute may not be greater than :max.',
        'file'    => 'El campo :attribute may not be greater than :max kilobytes.',
        'string'  => 'El campo :attribute may not be greater than :max characters.',
        'array'   => 'El campo :attribute may not have more than :max items.',
    ],
    'mimes'                => 'El campo :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'El campo :attribute debe tener una longitud minima de :min caracteres.',
        'file'    => 'El campo :attribute debe tener un tamaño de al menos :min kilobytes.',
        'string'  => 'El campo :attribute debe tener una longitud minima de :min characters.',
        'array'   => 'El campo :attribute debe tener al menos :min elementos.',
    ],
    'not_in'               => 'El campo selected :attribute is invalid.',
    'numeric'              => 'El campo :attribute must be a number.',
    'present'              => 'El campo :attribute field must be present.',
    'regex'                => 'El campo :attribute format is invalid.',
    'required'             => 'El campo :attribute es obligatorio.',
    'required_if'          => 'El campo :attribute field is required when :other is :value.',
    'required_unless'      => 'El campo :attribute field is required unless :other is in :values.',
    'required_with'        => 'El campo :attribute field is required when :values is present.',
    'required_with_all'    => 'El campo :attribute field is required when :values is present.',
    'required_without'     => 'El campo :attribute field is required when :values is not present.',
    'required_without_all' => 'El campo :attribute field is required when none of :values are present.',
    'same'                 => 'El campo :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'El campo :attribute must be :size.',
        'file'    => 'El campo :attribute must be :size kilobytes.',
        'string'  => 'El campo :attribute must be :size characters.',
        'array'   => 'El campo :attribute must contain :size items.',
    ],
    'string'               => 'El campo :attribute must be a string.',
    'timezone'             => 'El campo :attribute must be a valid zone.',
    'unique'               => 'El :attribute ingresado ya esta en uso.',
    'url'                  => 'El campo :attribute format is invalid.',
    
    'recaptcha' => 'El captcha no se resolvió correctamente.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
