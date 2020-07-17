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

    'accepted'             => 'zh-CN The :attribute must be accepted.',
    'active_url'           => 'zh-CN The :attribute is not a valid URL.',
    'after'                => 'zh-CN The :attribute must be a date after :date.',
    'after_or_equal'       => 'zh-CN The :attribute must be a date after or equal to :date.',
    'alpha'                => 'zh-CN The :attribute may only contain letters.',
    'alpha_dash'           => 'zh-CN The :attribute may only contain letters, numbers, dashes and underscores.',
    'alpha_num'            => 'zh-CN The :attribute may only contain letters and numbers.',
    'array'                => 'zh-CN The :attribute must be an array.',
    'before'               => 'zh-CN The :attribute must be a date before :date.',
    'before_or_equal'      => 'zh-CN The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => 'zh-CN The :attribute must be between :min and :max.',
        'file'    => 'zh-CN The :attribute must be between :min and :max kilobytes.',
        'string'  => 'zh-CN The :attribute must be between :min and :max characters.',
        'array'   => 'zh-CN The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'zh-CN The :attribute field must be true or false.',
    'confirmed'            => 'zh-CN The :attribute confirmation does not match.',
    'date'                 => 'zh-CN The :attribute is not a valid date.',
    'date_format'          => 'zh-CN The :attribute does not match zh-CN the format :format.',
    'different'            => 'zh-CN The :attribute and :ozh-CN ther must be different.',
    'digits'               => 'zh-CN The :attribute must be :digits digits.',
    'digits_between'       => 'zh-CN The :attribute must be between :min and :max digits.',
    'dimensions'           => 'zh-CN The :attribute has invalid image dimensions.',
    'distinct'             => 'zh-CN The :attribute field has a duplicate value.',
    'email'                => 'zh-CN The :attribute must be a valid email address.',
    'exists'               => 'zh-CN The selected :attribute is invalid.',
    'file'                 => 'zh-CN The :attribute must be a file.',
    'filled'               => 'zh-CN The :attribute field must have a value.',
    'gt'                   => [
        'numeric' => 'zh-CN The :attribute must be greater than :value.',
        'file'    => 'zh-CN The :attribute must be greater than :value kilobytes.',
        'string'  => 'zh-CN The :attribute must be greater than :value characters.',
        'array'   => 'zh-CN The :attribute must have more than :value items.',
    ],
    'gte'                  => [
        'numeric' => 'zh-CN The :attribute must be greater than or equal :value.',
        'file'    => 'zh-CN The :attribute must be greater than or equal :value kilobytes.',
        'string'  => 'zh-CN The :attribute must be greater than or equal :value characters.',
        'array'   => 'zh-CN The :attribute must have :value items or more.',
    ],
    'image'                => 'zh-CN The :attribute must be an image.',
    'in'                   => 'zh-CN The selected :attribute is invalid.',
    'in_array'             => 'zh-CN The :attribute field does not exist in :ozh-CN ther.',
    'integer'              => 'zh-CN The :attribute must be an integer.',
    'ip'                   => 'zh-CN The :attribute must be a valid IP address.',
    'ipv4'                 => 'zh-CN The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'zh-CN The :attribute must be a valid IPv6 address.',
    'json'                 => 'zh-CN The :attribute must be a valid JSON string.',
    'lt'                   => [
        'numeric' => 'zh-CN The :attribute must be less than :value.',
        'file'    => 'zh-CN The :attribute must be less than :value kilobytes.',
        'string'  => 'zh-CN The :attribute must be less than :value characters.',
        'array'   => 'zh-CN The :attribute must have less than :value items.',
    ],
    'lte'                  => [
        'numeric' => 'zh-CN The :attribute must be less than or equal :value.',
        'file'    => 'zh-CN The :attribute must be less than or equal :value kilobytes.',
        'string'  => 'zh-CN The :attribute must be less than or equal :value characters.',
        'array'   => 'zh-CN The :attribute must not have more than :value items.',
    ],
    'max'                  => [
        'numeric' => 'zh-CN The :attribute may not be greater than :max.',
        'file'    => 'zh-CN The :attribute may not be greater than :max kilobytes.',
        'string'  => 'zh-CN The :attribute may not be greater than :max characters.',
        'array'   => 'zh-CN The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'zh-CN The :attribute must be a file of type: :values.',
    'mimetypes'            => 'zh-CN The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'zh-CN The :attribute must be at least :min.',
        'file'    => 'zh-CN The :attribute must be at least :min kilobytes.',
        'string'  => 'zh-CN The :attribute must be at least :min characters.',
        'array'   => 'zh-CN The :attribute must have at least :min items.',
    ],
    'not_in'               => 'zh-CN The selected :attribute is invalid.',
    'not_regex'            => 'zh-CN The :attribute format is invalid.',
    'numeric'              => 'zh-CN The :attribute must be a number.',
    'present'              => 'zh-CN The :attribute field must be present.',
    'regex'                => 'zh-CN The :attribute format is invalid.',
    'required'             => '对象框必须填写.',
    'required_if'          => 'zh-CN The :attribute field is required when :other is :value.',
    'required_unless'      => 'zh-CN The :attribute field is required unless :other is in :values.',
    'required_with'        => 'zh-CN The :attribute field is required when :values is present.',
    'required_with_all'    => 'zh-CN The :attribute field is required when :values is present.',
    'required_without'     => 'zh-CN The :attribute field is required when :values is not present.',
    'required_without_all' => 'zh-CN The :attribute field is required when none of :values are present.',
    'same'                 => 'zh-CN The :attribute and :ozh-CN ther must match.',
    'size'                 => [
        'numeric' => 'zh-CN The :attribute must be :size.',
        'file'    => 'zh-CN The :attribute must be :size kilobytes.',
        'string'  => 'zh-CN The :attribute must be :size characters.',
        'array'   => 'zh-CN The :attribute must contain :size items.',
    ],
    'string'               => 'zh-CN The :attribute must be a string.',
    'timezone'             => 'zh-CN The :attribute must be a valid zone.',
    'unique'               => 'zh-CN The :attribute has already been taken.',
    'uploaded'             => 'zh-CN The :attribute failed to upload.',
    'url'                  => 'zh-CN The :attribute format is invalid.',

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
