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

    'accepted' => 'The :attribute must be accepted.',
    'active_url' => 'The :attribute is not a valid URL.',
    'after' => 'The :attribute must be a date after :date.',
    'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
    'alpha' => 'The :attribute may only contain letters.',
    'alpha_dash' => 'The :attribute may only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'The :attribute may only contain letters and numbers.',
    'array' => 'The :attribute must be an array.',
    'before' => 'The :attribute must be a date before :date.',
    'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
    'between' => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file' => 'The :attribute must be between :min and :max kilobytes.',
        'string' => 'The :attribute must be between :min and :max characters.',
        'array' => 'The :attribute must have between :min and :max items.',
    ],
    'boolean' => 'The :attribute field must be true or false.',
    'confirmed' => ':attribute পুনরাবৃত্তি মিলছে না।',
    'date' => 'The :attribute is not a valid date.',
    'date_equals' => 'The :attribute must be a date equal to :date.',
    'date_format' => 'The :attribute does not match the format :format.',
    'different' => 'The :attribute and :other must be different.',
    'digits' => ':attribute টি অবশ্যই :digits সংখ্যার হতে হবে।',
    'digits_between' => 'The :attribute must be between :min and :max digits.',
    'dimensions' => 'The :attribute has invalid image dimensions.',
    'distinct' => 'The :attribute field has a duplicate value.',
    'email' => ':attribute সঠিক হতে হবে',
    'ends_with' => 'The :attribute must end with one of the following: :values.',
    'exists' => ':attribute টি অগ্রহণযোগ্য।',
    'file' => 'The :attribute টি অবশ্যই একটি ফাইল হতে হবে।',
    'filled' => ':attribute টি অবশ্যই মান থাকতে হবে।',
    'gt' => [
        'numeric' => 'The :attribute must be greater than :value.',
        'file' => 'The :attribute must be greater than :value kilobytes.',
        'string' => 'The :attribute must be greater than :value characters.',
        'array' => 'The :attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'The :attribute must be greater than or equal :value.',
        'file' => 'The :attribute must be greater than or equal :value kilobytes.',
        'string' => 'The :attribute must be greater than or equal :value characters.',
        'array' => 'The :attribute must have :value items or more.',
    ],
    'image' => ':attribute টি অবশ্যই একটি ছবি হতে হবে।',
    'in' => ':attribute টি অগ্রহণযোগ্য।',
    'in_array' => 'The :attribute field does not exist in :other.',
    'integer' => ':attribute টি অবশ্যই একটি পূর্ণ সংখ্যা হতে হবে।',
    'ip' => 'The :attribute must be a valid IP address.',
    'ipv4' => 'The :attribute must be a valid IPv4 address.',
    'ipv6' => 'The :attribute must be a valid IPv6 address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => 'The :attribute must be less than :value.',
        'file' => 'The :attribute must be less than :value kilobytes.',
        'string' => 'The :attribute must be less than :value characters.',
        'array' => 'The :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'The :attribute must be less than or equal :value.',
        'file' => 'The :attribute must be less than or equal :value kilobytes.',
        'string' => 'The :attribute must be less than or equal :value characters.',
        'array' => 'The :attribute must not have more than :value items.',
    ],
    'max' => [
        'numeric' => ':attribute টি সর্বোচ্চ :max হতে পারবে।',
        'file' => ':attribute টি সর্বোচ্চ :max কিলোবাইট হতে পারবে।',
        'string' => ':attribute টি সর্বোচ্চ :max সংখ্যার হতে পারবে।',
        'array' => ':attribute টি সর্বোচ্চ :max গুলো হতে পারবে।',
    ],
    'mimes' => ':attribute টি অবশ্যই নিম্নোক্ত ফরম্যাটের মধ্যে হতে হবে।: :values.',
    'mimetypes' => ':attribute টি অবশ্যই নিম্নোক্ত ফরম্যাটের মধ্যে হতে হবে।: :values.',
    'min' => [
        'numeric' => ':attribute টি কমপক্ষে :min হতে হবে।',
        'file' => ':attribute টি কমপক্ষে :min কিলোবাইট হতে হবে।',
        'string' => ':attribute টি কমপক্ষে :min সংখ্যার হতে হবে।',
        'array' => ':attribute টি কমপক্ষে :min গুলো হতে হবে।',
    ],
    'not_in' => ':attribute টি অগ্রহণযোগ্য।',
    'not_regex' => ':attribute টি অগ্রহণযোগ্য।',
    'numeric' => ':attribute টি একটি নম্বর হতে হবে।',
    'password' => 'পাসওয়ার্ডটি ভূল।',
    'present' => ':attribute তথ্যটি অবশ্যই দিতে হবে।',
    'regex' => 'The :attribute format is invalid.',
    'required' => ':attribute তথ্যটি আবশ্যক।',
    'required_if' => ':attribute তথ্যটি আবশ্যক যখন :other টি হলো :value।',
    'required_unless' => ':attribute টি আবশ্যক যখন :other টি :values মধ্যে নয়।',
    'required_with' => ':attribute টি আবশ্যক যখন :values আছে।',
    'required_with_all' => ':attribute টি আবশ্যক যখন :values সমূহ আছে।',
    'required_without' => ':attribute টি আবশ্যক যখন :values নেই।',
    'required_without_all' => ':attribute টি আবশ্যক যখন :values সমূহ নেই।',
    'same' => ':attribute এবং :other একই হতে হবে।',
    'size' => [
        'numeric' => 'The :attribute must be :size.',
        'file' => 'The :attribute must be :size kilobytes.',
        'string' => 'The :attribute must be :size characters.',
        'array' => 'The :attribute must contain :size items.',
    ],
    'starts_with' => 'The :attribute must start with one of the following: :values.',
    'string' => ':attribute টি অবশ্যই একটি স্ট্রিং হতে হবে।',
    'timezone' => 'The :attribute must be a valid zone.',
    'unique' => ':attribute টি ইতিমধ্যে নেওয়া হয়েছে।',
    'uploaded' => ':attribute আপ্লোড ব্যার্থ হয়েছে।',
    'url' => ':attribute টি অগ্রহণযোগ্য।',
    'uuid' => 'The :attribute must be a valid UUID.',
    'incorrect_number' => 'সংখ্যাটি সঠিক নয়',

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
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        //Common
        'name' => 'নাম',
        'bn_name' => 'বাংলা নাম',
        'email' => 'ইমেইল',
        'mobile' => 'মোবাইল নম্বর',
        'username' => 'ইউজারনেম',
        'date' => 'তারিখ',
        'image' => 'ছবি',
        'status' => 'স্ট্যাটাস',
        'brand_id' => 'ব্র্যান্ড',
        'model_id' => 'মডেল',
        'product_id.*' => 'গাড়ি/পাম্প(গুলো)',
        'variant_type_id.*' => 'ভেরিয়্যান্ট টাইপ(গুলো)',
        'variant_id.*' => 'ভেরিয়্যান্ট(গুলো)',

        //Product Part
        'sku' => 'এস.কে.ইউ.',
        'material' => 'ম্যাটেরিয়াল',
        'material_type' => 'ম্যাটেরিয়াল টাইপ',
        'parts' => 'পার্টস',
        'products.*' => 'গাড়ি/পাম্প(গুলো)',
        'weight' => 'ওজন',
        'minimum_stock' => 'সর্বনিম্ন স্টক যত এর নিচে এলার্ট',
    ],

];
