<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class Some of these rules have multiple versions such
    | as the size rules Feel free to tweak each of these messages here
    |
    */

    'accepted'             => 'The :attribute must be accepted',
    'active_url'           => ':attributeไม่ใช่ URL ที่ถูกต้อง',
    'after'                => 'The :attribute must be a date after :date',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date',
    'alpha'                => ':attributeต้องเป็นตัวอักษรเท่านั้น',
    'alpha_dash'           => ':attributeต้องเป็นตัวอักษร ตัวเลข หรือ - เท่านั้น',
    'alpha_num'            => ':attributeต้องเป็นตัวอักษร หรือ ตัวเลขเท่านั้น',
    'array'                => 'The :attribute must be an array',
    'before'               => 'The :attribute must be a date before :date',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date',
    'between'              => [
        'numeric' => ':attributeต้องมีค่าระหว่าง :min ถึง :max',
        'file'    => 'The :attribute must be between :min and :max kilobytes',
        'string'  => 'The :attribute must be between :min and :max characters',
        'array'   => 'The :attribute must have between :min and :max items',
    ],
    'boolean'              => 'The :attribute field must be true or false',
    'confirmed'            => 'การยืนยัน:attributeไม่ตรงกัน',
    'date'                 => 'The :attribute is not a valid date',
    'date_format'          => 'The :attribute does not match the format :format',
    'different'            => 'The :attribute and :other must be different',
    'digits'               => ':attribute ต้องมีความยาว :digits หลัก',
    'digits_between'       => ':attributeต้องมีความยาวระหว่าง :min และ :max หลัก',
    'dimensions'           => 'The :attribute has invalid image dimensions',
    'distinct'             => 'The :attribute field has a duplicate value',
    'email'                => 'ต้องเป็นอีเมลเท่านั้น',
    'exists'               => ':attributeซ้ำกับข้อมูลในระบบ',
    'file'                 => 'The :attribute must be a file',
    'filled'               => 'The :attribute field must have a value',
    'image'                => 'The :attribute must be an image',
    'in'                   => 'The selected :attribute is invalid',
    'in_array'             => 'The :attribute field does not exist in :other',
    'integer'              => 'The :attribute must be an integer',
    'ip'                   => 'The :attribute must be a valid IP address',
    'json'                 => 'The :attribute must be a valid JSON string',
    'max'                  => [
        'numeric' => ':attribute ต้องมีค่าไม่เกิน :max',
        'file'    => 'The :attribute may not be greater than :max kilobytes',
        'string'  => 'ต้องมีความยาวไม่เกิน :max ตัวอักษร',
        'array'   => 'The :attribute may not have more than :max items',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values',
    'mimetypes'            => 'The :attribute must be a file of type: :values',
    'min'                  => [
        'numeric' => ':attribute ต้องมีค่าอย่างน้อย :min',
        'file'    => ':attribute must be at least :min kilobytes',
        'string'  => ':attributeต้องมีความยาวอย่างน้อย :min ตัว',
        'array'   => ':attribute must have at least :min items',
    ],
    'not_in'               => 'The selected :attribute is invalid',
    'numeric'              => ':attributeต้องเป็นตัวเลขเท่านั้น',
    'present'              => 'The :attribute field must be present',
    'regex'                => ':attributeไม่ถูกต้องตามแบบที่กำหนดไว้',
    'required'             => 'กรุณากรอกข้อมูลในช่องนี้',
    'required_if'          => 'The :attribute field is required when :other is :value',
    'required_unless'      => 'The :attribute field is required unless :other is in :values',
    'required_with'        => 'The :attribute field is required when :values is present',
    'required_with_all'    => 'The :attribute field is required when :values is present',
    'required_without'     => 'The :attribute field is required when :values is not present',
    'required_without_all' => 'The :attribute field is required when none of :values are present',
    'same'                 => 'The :attribute and :other must match',
    'size'                 => [
        'numeric' => 'The :attribute must be :size',
        'file'    => 'The :attribute must be :size kilobytes',
        'string'  => 'The :attribute must be :size characters',
        'array'   => 'The :attribute must contain :size items',
    ],
    'string'               => 'The :attribute must be a string',
    'timezone'             => 'The :attribute must be a valid zone',
    'unique'               => ':attribute นี้ถูกใช้ไปแล้ว',
    'uploaded'             => 'The :attribute failed to upload',
    'url'                  => 'รูปแบบ URL ไม่ถูกต้อง',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attributerule" to name the lines This makes it quick to
    | specify a specific custom language line for a given attribute rule
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
    | of "email" This simply helps us make messages a little cleaner
    |
    */

    'attributes' => [
      'slug' => 'URL',
      'name' => 'ชื่อ',
      'description' => 'คำอธิบาย',
      'shop_name' => 'ชื่อโปรไฟล์',
      'email' => 'Email',
      'password' => 'รหัสผ่าน',
      'date' => 'วัน',
      'month' => 'เดือน',
      'year' => 'ปี',
    ],

];
