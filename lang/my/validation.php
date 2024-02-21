<?php

declare(strict_types=1);

return [
    'accepted'             => ':attribute ကိုလက်ခံရပါမည်။',
    'accepted_if'          => ':other မှ :value တွင် :attribute ကိုလက်ခံရပါမည်။',
    'active_url'           => ':attribute သည် မှန်ကန်သော URL မဟုတ်ပါ။',
    'after'                => ':attribute သည် :date နောက်ပိုင်းရက်စွဲဖြစ်ရမည်။',
    'after_or_equal'       => ':attribute သည် :date ၏နောက် သို့မဟုတ် ညီမျှသည့်ရက်စွဲဖြစ်ရမည်။',
    'alpha'                => ':attribute လုံးတွင် စာလုံးများသာ ပါဝင်ရပါမည်။',
    'alpha_dash'           => ':attribute တွင် စာလုံးများ၊ နံပါတ်များ၊ ဒက်ရှ်များနှင့် အောက်ခံများသာ ပါဝင်ရပါမည်။',
    'alpha_num'            => ':attribute တွင် အက္ခရာများနှင့် ဂဏန်းများသာ ပါဝင်ရပါမည်။',
    'array'                => ':attribute သည် array တစ်ခုဖြစ်ရမည်။',
    'ascii'                => 'အကွက် :attribute တွင် single-byte အက္ခရာဂဏန်းစာလုံးများနှင့် သင်္ကေတများသာ ပါဝင်ရပါမည်။',
    'before'               => ':attribute သည် :date မတိုင်မီရက်စွဲဖြစ်ရပါမည်။',
    'before_or_equal'      => ':attribute သည် :date မတိုင်မီရက်စွဲတစ်ခုဖြစ်ရမည်။',
    'between'              => [
        'array'   => ':attribute တွင် ပစ္စည်း :min မှ :max ကြားရှိရမည်။',
        'file'    => ':attribute သည် :min နှင့် :max ကီလိုဘိုက်ကြားရှိရမည်။',
        'numeric' => ':attribute သည် :min နှင့် :max ကြားရှိရမည်။',
        'string'  => ':attribute သည် စာလုံး :min နှင့် :max ကြားရှိရမည်။',
    ],
    'boolean'              => 'အကွက် :attribute သည် မှန်သည်ဖြစ်စေ မှားနေရပါမည်။',
    'can'                  => 'အကွက် :attribute တွင် ခွင့်ပြုချက်မရှိဘဲ တန်ဖိုးတစ်ခုပါရှိသည်။',
    'confirmed'            => 'အတည်ပြုချက် ၁၀ ချက်နှင့် မကိုက်ညီပါ။',
    'current_password'     => 'စကားဝှက် မမှန်ပါ။',
    'date'                 => ':attribute သည် တရားဝင်ရက်စွဲမဟုတ်ပါ။',
    'date_equals'          => ':attribute သည် :date နှင့် ညီမျှသော ရက်စွဲဖြစ်ရမည်။',
    'date_format'          => ':attribute သည် ပုံစံ :format နှင့် မကိုက်ညီပါ။',
    'decimal'              => 'အကွက် :attribute တွင် ဒဿမ :decimal နေရာရှိရမည်။',
    'declined'             => ':attribute ကို ငြင်းပယ်ရမည်။',
    'declined_if'          => ':other သည် :value ဖြစ်သောအခါ :attribute ကို ငြင်းပယ်ရပါမည်။',
    'different'            => ':attribute နှင့် :other ကွဲပြားရပါမည်။',
    'digits'               => ':attribute သည် ဂဏန်း :digits ဖြစ်ရမည်။',
    'digits_between'       => ':attribute သည် ဂဏန်း :min နှင့် :max ကြား ဖြစ်ရမည်။',
    'dimensions'           => ':attribute တွင် မမှန်ကန်သော ပုံအတိုင်းအတာများရှိသည်။',
    'distinct'             => 'အကွက် :attribute တွင် ထပ်နေသောတန်ဖိုးတစ်ခုရှိသည်။',
    'doesnt_end_with'      => 'အကွက် :attribute သည် အောက်ပါများထဲမှ တစ်ခုနှင့် အဆုံးမသတ်ရပါမည်- :values။',
    'doesnt_start_with'    => 'အကွက် :attribute သည် အောက်ပါများထဲမှ တစ်ခုနှင့် မစတင်ရပါမည်- :values။',
    'email'                => ':attribute သည် တရားဝင်အီးမေးလ်လိပ်စာဖြစ်ရမည်။',
    'ends_with'            => ':attribute သည် အောက်ပါတို့အနက်မှ တစ်ခုနှင့် အဆုံးသတ်ရပါမည်- :values။',
    'enum'                 => 'ရွေးချယ်ထားသော :attribute သည် မမှန်ကန်ပါ။',
    'exists'               => 'ရွေးချယ်ထားသော :attribute သည် မမှန်ကန်ပါ။',
    'extensions'           => 'အကွက် :attribute တွင် အောက်ပါ extension များထဲမှ တစ်ခု ရှိရမည်- :values။',
    'file'                 => ':attribute ဖိုင်ဖြစ်ရမည်။',
    'filled'               => 'အကွက် :attribute တွင် တန်ဖိုးတစ်ခုရှိရမည်။',
    'gt'                   => [
        'array'   => ':attribute တွင် ပစ္စည်း :value ကျော်ရှိရမည်။',
        'file'    => ':attribute သည် :value ကီလိုဘိုက်ထက် ကြီးရမည်။',
        'numeric' => ':attribute သည် :value ထက်ကြီးရမည်။',
        'string'  => ':attribute သည် စာလုံး :value ထက်ကြီးရပါမည်။',
    ],
    'gte'                  => [
        'array'   => ':attribute တွင် ပစ္စည်း :value နှင့်အထက်ရှိရမည်။',
        'file'    => ':attribute သည် :value ကီလိုဘိုက်ထက် ကြီးသည် သို့မဟုတ် ညီမျှရပါမည်။',
        'numeric' => ':attribute သည် :value ထက် ကြီးသည် သို့မဟုတ် ညီမျှရမည်။',
        'string'  => ':attribute သည် စာလုံး :value ထက်ကြီးရမည် သို့မဟုတ် ညီရမည်။',
    ],
    'hex_color'            => 'အကွက် :attribute သည် မှန်ကန်သော ဆဋ္ဌမတန်အရောင် ဖြစ်ရပါမည်။',
    'image'                => ':attribute ပုံတစ်ပုံဖြစ်ရမည်။',
    'in'                   => 'ရွေးချယ်ထားသော :attribute သည် မမှန်ကန်ပါ။',
    'in_array'             => ':attribute အကွက်သည် :other တွင်မရှိပါ။',
    'integer'              => ':attribute သည် ကိန်းပြည့်ဖြစ်ရမည်။',
    'ip'                   => ':attribute သည် တရားဝင် IP လိပ်စာဖြစ်ရမည်။',
    'ipv4'                 => ':attribute သည် တရားဝင် IPv4 လိပ်စာဖြစ်ရမည်။',
    'ipv6'                 => ':attribute သည် တရားဝင် IPv6 လိပ်စာဖြစ်ရမည်။',
    'json'                 => ':attribute သည် တရားဝင် JSON စာကြောင်းဖြစ်ရပါမည်။',
    'lowercase'            => 'အကွက် :attribute သည် စာလုံးသေးဖြစ်ရမည်။',
    'lt'                   => [
        'array'   => ':attribute တွင် ပစ္စည်း :value ထက်နည်းရမည်။',
        'file'    => ':attribute သည် :value ကီလိုဘိုက်ထက်နည်းရမည်။',
        'numeric' => ':attribute သည် :value ထက်နည်းရမည်။',
        'string'  => ':attribute သည် စာလုံး :value ထက်နည်းရပါမည်။',
    ],
    'lte'                  => [
        'array'   => ':attribute တွင် ပစ္စည်း :value ထက်မပိုရပါ။',
        'file'    => ':attribute သည် :value ကီလိုဘိုက်ထက် နည်းရမည် သို့မဟုတ် ညီမျှရမည်။',
        'numeric' => ':attribute သည် :value အောက် သို့မဟုတ် ညီမျှရပါမည်။',
        'string'  => ':attribute သည် စာလုံး :value အောက် သို့မဟုတ် ညီမျှရပါမည်။',
    ],
    'mac_address'          => ':attribute သည် တရားဝင် MAC လိပ်စာဖြစ်ရမည်။',
    'max'                  => [
        'array'   => ':attribute တွင် ပစ္စည်း :max ထက်မပိုရပါ။',
        'file'    => ':attribute သည် :max ကီလိုဘိုက်ထက်မကြီးရပါ။',
        'numeric' => ':attribute သည် :max ထက်မကြီးရပါ။',
        'string'  => ':attribute သည် စာလုံး :max ထက်မကြီးရပါ။',
    ],
    'max_digits'           => 'အကွက် :attribute တွင် ဂဏန်း :max ထက်မပိုရပါ။',
    'mimes'                => ':attribute သည် ဖိုင်အမျိုးအစား :values ဖြစ်ရပါမည်။',
    'mimetypes'            => ':attribute သည် ဖိုင်အမျိုးအစား :values ဖြစ်ရပါမည်။',
    'min'                  => [
        'array'   => ':attribute တွင် အနည်းဆုံး ပစ္စည်း :min ရှိရမည်။',
        'file'    => ':attribute သည် အနည်းဆုံး :min ကီလိုဘိုက်ရှိရမည်။',
        'numeric' => ':attribute သည် အနည်းဆုံး :min ဖြစ်ရမည်။',
        'string'  => ':attribute သည် အနည်းဆုံး စာလုံး :min ရှိရပါမည်။',
    ],
    'min_digits'           => 'အကွက် :attribute တွင် အနည်းဆုံး ဂဏန်း :min ရှိရမည်။',
    'missing'              => 'အကွက် :attribute ပျောက်နေရပါမည်။',
    'missing_if'           => ':other သည် :value တွင် :attribute အကွက်ပျောက်ရပါမည်။',
    'missing_unless'       => ':other သည် :value မဟုတ်ပါက :attribute အကွက်ပျောက်ရပါမည်။',
    'missing_with'         => ':values ရှိသောအခါတွင် :attribute အကွက်ပျောက်ရပါမည်။',
    'missing_with_all'     => 'အကွက် :values ရှိသောအခါ :attribute အကွက်ပျောက်ရပါမည်။',
    'multiple_of'          => ':attribute သည် :value ၏ တိုးကိန်းဖြစ်ရပါမည်။',
    'not_in'               => 'ရွေးချယ်ထားသော :attribute သည် မမှန်ကန်ပါ။',
    'not_regex'            => ':attribute ဖော်မတ်သည် မမှန်ကန်ပါ။',
    'numeric'              => ':attribute သည် ဂဏန်းဖြစ်ရမည်။',
    'password'             => [
        'letters'       => 'အကွက် :attribute တွင် အနည်းဆုံး စာလုံးတစ်လုံး ပါရှိရမည်။',
        'mixed'         => 'အကွက် :attribute တွင် အနည်းဆုံး စာလုံးအကြီးတစ်ခုနှင့် စာလုံးသေးတစ်လုံး ပါဝင်ရပါမည်။',
        'numbers'       => 'အကွက် :attribute တွင် အနည်းဆုံး နံပါတ်တစ်ခု ပါဝင်ရပါမည်။',
        'symbols'       => 'အကွက် :attribute တွင် အနည်းဆုံး သင်္ကေတတစ်ခု ပါဝင်ရပါမည်။',
        'uncompromised' => 'ပေးထားသော :attribute သည် data ပေါက်ကြားမှုတစ်ခုပေါ်လာသည်။ မတူညီသော :attribute ကို ရွေးပါ။',
    ],
    'present'              => 'အကွက် :attribute ရှိရမည်။',
    'present_if'           => ':other သည် :value ဖြစ်သောအခါ :attribute အကွက်သည် ရှိနေရပါမည်။',
    'present_unless'       => ':other သည် :value မဟုတ်ပါက :attribute အကွက်သည် ရှိနေရပါမည်။',
    'present_with'         => ':values ရှိသောအခါတွင် အကွက် :attribute ရှိရပါမည်။',
    'present_with_all'     => 'အကွက် :values ရှိသောအခါတွင် :attribute အကွက်ရှိရပါမည်။',
    'prohibited'           => ':attribute အကွက်ကို တားမြစ်ထားသည်။',
    'prohibited_if'        => ':other မှ :value တွင် :attribute အကွက်ကိုတားမြစ်သည်။',
    'prohibited_unless'    => ':other မှ :values အတွင်းမဟုတ်ပါက :attribute အကွက်ကိုတားမြစ်ထားသည်။',
    'prohibits'            => 'အကွက် :attribute သည် :other ကိုမတက်ရောက်ရန်တားမြစ်ထားသည်။',
    'regex'                => ':attribute ဖော်မတ်သည် မမှန်ကန်ပါ။',
    'required'             => ':attribute အကွက်လိုအပ်သည်။',
    'required_array_keys'  => 'အကွက် :attribute တွင် ထည့်သွင်းမှုများ ပါဝင်ရမည်- :values။',
    'required_if'          => ':other သည် :value ဖြစ်သောအခါ :attribute အကွက်လိုအပ်သည်။',
    'required_if_accepted' => ':other ကိုလက်ခံသောအခါ :attribute အကွက်လိုအပ်သည်။',
    'required_unless'      => ':other သည် :values အတွင်းမဟုတ်ပါက :attribute အကွက်လိုအပ်ပါသည်။',
    'required_with'        => ':values ရှိသောအခါတွင် :attribute အကွက်လိုအပ်သည်။',
    'required_with_all'    => ':values ရှိသောအခါတွင် :attribute အကွက်လိုအပ်သည်။',
    'required_without'     => ':values မရှိသောအခါတွင် :attribute အကွက်လိုအပ်သည်။',
    'required_without_all' => ':values တွင်တစ်ခုမျှမရှိပါက :attribute အကွက်လိုအပ်သည်။',
    'same'                 => ':attribute နှင့် :other သည် တူညီရမည်။',
    'size'                 => [
        'array'   => ':attribute တွင် ပစ္စည်း :size ပါဝင်ရမည်။',
        'file'    => ':attribute သည် :size ကီလိုဘိုက်ရှိရမည်။',
        'numeric' => ':attribute က :size ဖြစ်ရမယ်။',
        'string'  => ':attribute သည် စာလုံး :size ဖြစ်ရမည်။',
    ],
    'starts_with'          => ':attribute သည် အောက်ပါတို့အနက်မှ တစ်ခုနှင့် စတင်ရပါမည်။',
    'string'               => ':attribute သည် ကြိုးတစ်ချောင်းဖြစ်ရမည်။',
    'timezone'             => ':attribute သည် တရားဝင်အချိန်ဇုန်ဖြစ်ရမည်။',
    'ulid'                 => 'အကွက် :attribute သည် မှန်ကန်သော ULID ဖြစ်ရပါမည်။',
    'unique'               => '၁၀ လုံးယူထားပြီးသား။',
    'uploaded'             => ':attribute ကို အပ်လုဒ်လုပ်၍မရပါ။',
    'uppercase'            => 'အကွက် :attribute သည် စာလုံးအကြီးဖြစ်ရမည်။',
    'url'                  => ':attribute သည် တရားဝင် URL ဖြစ်ရပါမည်။',
    'uuid'                 => ':attribute သည် တရားဝင် UUID ဖြစ်ရပါမည်။',
    'attributes'           => [
        'address'                  => 'လိပ်စာ',
        'affiliate_url'            => 'တွဲဖက် URL',
        'age'                      => 'အသက်',
        'amount'                   => 'ပမာဏ',
        'area'                     => 'ဧရိယာ',
        'available'                => 'ရရှိနိုင်',
        'birthday'                 => 'မွေးနေ့',
        'body'                     => 'ခန္ဓာကိုယ်',
        'city'                     => 'မြို့',
        'content'                  => 'အကြောင်းအရာ',
        'country'                  => 'နိုင်ငံ',
        'created_at'               => 'တွင်ဖန်တီးခဲ့သည်။',
        'creator'                  => 'ဖန်တီးသူ',
        'currency'                 => 'ငွေကြေး',
        'current_password'         => 'လက်ရှိစကားဝှက်',
        'customer'                 => 'ဖောက်သည်',
        'date'                     => 'ရက်စွဲ',
        'date_of_birth'            => 'မွေးနေ့',
        'day'                      => 'နေ့',
        'deleted_at'               => 'တွင် ဖျက်ထားသည်။',
        'description'              => 'ဖော်ပြချက်',
        'district'                 => 'ခရိုင်',
        'duration'                 => 'ကြာချိန်',
        'email'                    => 'အီးမေးလ်',
        'excerpt'                  => 'ကောက်နုတ်ချက်',
        'filter'                   => 'ဇကာ',
        'first_name'               => 'နာမည်',
        'gender'                   => 'ကျား၊',
        'group'                    => 'အဖွဲ့',
        'hour'                     => 'နာရီ',
        'image'                    => 'ပုံ',
        'is_subscribed'            => 'စာရင်းသွင်းထားသည်။',
        'items'                    => 'ပစ္စည်းများ',
        'last_name'                => 'မျိုးနွယ်အမည်',
        'lesson'                   => 'သင်ခန်းစာ',
        'line_address_1'           => 'လိုင်းလိပ်စာ ၁',
        'line_address_2'           => 'လိုင်းလိပ်စာ ၂',
        'message'                  => 'သတင်းစကား',
        'middle_name'              => 'အလယ်နာမည်',
        'minute'                   => 'မိနစ်',
        'mobile'                   => 'မိုဘိုင်း',
        'month'                    => 'လ',
        'name'                     => 'နာမည်',
        'national_code'            => 'နိုင်ငံတော်ကုဒ်',
        'number'                   => 'နံပါတ်',
        'password'                 => 'စကားဝှက်',
        'password_confirmation'    => 'စကားဝှက်အတည်ပြုခြင်း။',
        'phone'                    => 'ဖုန်း',
        'photo'                    => 'ဓာတ်ပုံ',
        'postal_code'              => 'စာတိုက်သင်္ကေတ',
        'preview'                  => 'စမ်းကြည့်သည်။',
        'price'                    => 'စျေးနှုန်း',
        'product_id'               => 'ထုတ်ကုန် ID',
        'product_uid'              => 'ထုတ်ကုန် UID',
        'product_uuid'             => 'ထုတ်ကုန် UUID',
        'promo_code'               => 'ကြော်ငြာကုဒ်',
        'province'                 => 'ပြည်နယ်',
        'quantity'                 => 'ပမာဏ',
        'recaptcha_response_field' => 'recaptcha တုံ့ပြန်မှုအကွက်',
        'remember'                 => 'သတိရပါ။',
        'restored_at'              => 'တွင် ပြန်လည်ထိန်းသိမ်းထားသည်။',
        'result_text_under_image'  => 'ပုံအောက်တွင်ရလဒ်စာသား',
        'role'                     => 'အခန်းကဏ္ဍ',
        'second'                   => 'ဒုတိယ',
        'sex'                      => 'လိင်',
        'shipment'                 => 'ပို့ဆောင်ခြင်း။',
        'short_text'               => 'စာသားတို',
        'size'                     => 'အရွယ်အစား',
        'state'                    => 'ပြည်နယ်',
        'street'                   => 'လမ်း',
        'student'                  => 'ကျောင်းသား',
        'subject'                  => 'ဘာသာရပ်',
        'teacher'                  => 'ဆရာမ',
        'terms'                    => 'အသုံးအနှုန်းများ',
        'test_description'         => 'စမ်းသပ်ဖော်ပြချက်',
        'test_locale'              => 'စမ်းသပ်မှုဒေသ',
        'test_name'                => 'စမ်းသပ်အမည်',
        'text'                     => 'စာသား',
        'time'                     => 'အချိန်',
        'title'                    => 'ခေါင်းစဥ်',
        'updated_at'               => 'တွင် မွမ်းမံထားသည်။',
        'user'                     => 'အသုံးပြုသူကို',
        'username'                 => 'အသုံးပြုသူအမည်',
        'year'                     => 'တစ်နှစ်',
    ],
];
